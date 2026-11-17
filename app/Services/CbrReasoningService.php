<?php

namespace App\Services;

use App\Models\CbrCase;

/**
 * Case Based Reasoning (CBR) Engine Service
 *
 * Implements the 4-step CBR cycle:
 *   1. RETRIEVE — Find most similar past cases
 *   2. REUSE   — Adapt the solution from the best match
 *   3. REVISE  — Allow admin to adjust solution
 *   4. RETAIN  — Save new case to case base
 */
class CbrReasoningService
{
    /**
     * RETRIEVE: Find similar cases from the case base.
     *
     * Similarity is calculated using weighted Jaccard similarity:
     *   sim(A,B) = |A ∩ B| / |A ∪ B|
     *
     * Combined similarity from gejala + kondisi + kategori with weights.
     *
     * @param string $kategori  Kategori masalah input
     * @param array  $gejala    Array gejala yang dialami
     * @param array  $kondisi   Array kondisi yang terjadi
     * @param float  $threshold Minimum similarity threshold (0-1)
     * @return array  Sorted results with similarity scores
     */
    public function retrieve(string $kategori, array $gejala, array $kondisi, float $threshold = 0.3): array
    {
        $cases = CbrCase::where('is_active', true)->get();
        $results = [];

        foreach ($cases as $case) {
            $similarity = $this->calculateSimilarity(
                $kategori,
                $gejala,
                $kondisi,
                $case
            );

            if ($similarity >= $threshold) {
                $results[] = [
                    'case' => $case,
                    'similarity' => round($similarity, 4),
                    'similarity_pct' => round($similarity * 100, 1),
                    'detail' => $this->getSimilarityDetail($kategori, $gejala, $kondisi, $case),
                ];
            }
        }

        // Sort by similarity descending
        usort($results, fn($a, $b) => $b['similarity'] <=> $a['similarity']);

        return $results;
    }

    /**
     * REUSE: Get the solution from the best matching case.
     * Returns the top match with its solution adapted for the new problem.
     */
    public function reuse(array $retrieveResults): ?array
    {
        if (empty($retrieveResults)) {
            return null;
        }

        $best = $retrieveResults[0];
        $case = $best['case'];

        return [
            'kode_kasus_referensi' => $case->kode_kasus,
            'judul_referensi' => $case->judul_masalah,
            'solusi' => $case->solusi,
            'langkah_penanganan' => $case->langkah_penanganan ?? [],
            'similarity' => $best['similarity'],
            'similarity_pct' => $best['similarity_pct'],
            'is_verified' => $case->is_verified,
            'catatan' => $best['similarity'] >= 0.8
                ? 'Kasus sangat mirip — solusi dapat langsung diterapkan.'
                : ($best['similarity'] >= 0.5
                    ? 'Kasus cukup mirip — solusi perlu disesuaikan dengan kondisi saat ini.'
                    : 'Kemiripan rendah — solusi perlu direvisi secara signifikan.'),
        ];
    }

    /**
     * RETAIN: Save a new case to the case base.
     */
    public function retain(array $data): CbrCase
    {
        // Auto-generate unique code
        $lastCase = CbrCase::orderByDesc('id')->first();
        $nextNum = $lastCase ? ((int) substr($lastCase->kode_kasus, 3)) + 1 : 1;
        $kodeKasus = 'CBR' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        return CbrCase::create([
            'kode_kasus' => $kodeKasus,
            'judul_masalah' => $data['judul_masalah'],
            'kategori_masalah' => $data['kategori_masalah'],
            'gejala' => $data['gejala'],
            'kondisi' => $data['kondisi'],
            'solusi' => $data['solusi'],
            'langkah_penanganan' => $data['langkah_penanganan'] ?? [],
            'bobot' => $data['bobot'] ?? 1.00,
            'is_verified' => $data['is_verified'] ?? false,
            'is_active' => true,
        ]);
    }

    /**
     * Calculate combined similarity between input and a stored case.
     * Uses weighted Jaccard similarity with 3 components:
     *   - Kategori match:   weight 0.20 (exact match = 1, else 0)
     *   - Gejala similarity: weight 0.45 (Jaccard)
     *   - Kondisi similarity: weight 0.35 (Jaccard)
     */
    private function calculateSimilarity(string $kategori, array $gejala, array $kondisi, CbrCase $case): float
    {
        $wKategori = 0.20;
        $wGejala   = 0.45;
        $wKondisi  = 0.35;

        // Kategori: exact match
        $simKategori = (mb_strtolower(trim($kategori)) === mb_strtolower(trim($case->kategori_masalah))) ? 1.0 : 0.0;

        // Gejala: Jaccard with fuzzy token matching
        $simGejala = $this->jaccardSimilarity(
            $this->normalizeFeatures($gejala),
            $this->normalizeFeatures($case->gejala ?? [])
        );

        // Kondisi: Jaccard with fuzzy token matching
        $simKondisi = $this->jaccardSimilarity(
            $this->normalizeFeatures($kondisi),
            $this->normalizeFeatures($case->kondisi ?? [])
        );

        // Apply case weight
        $caseBobot = (float) ($case->bobot ?? 1.00);

        return ($wKategori * $simKategori + $wGejala * $simGejala + $wKondisi * $simKondisi) * $caseBobot;
    }

    /**
     * Get detailed breakdown of similarity components.
     */
    private function getSimilarityDetail(string $kategori, array $gejala, array $kondisi, CbrCase $case): array
    {
        $simKategori = (mb_strtolower(trim($kategori)) === mb_strtolower(trim($case->kategori_masalah))) ? 1.0 : 0.0;
        $simGejala = $this->jaccardSimilarity(
            $this->normalizeFeatures($gejala),
            $this->normalizeFeatures($case->gejala ?? [])
        );
        $simKondisi = $this->jaccardSimilarity(
            $this->normalizeFeatures($kondisi),
            $this->normalizeFeatures($case->kondisi ?? [])
        );

        // Find matched/unmatched gejala
        $normalizedInput = $this->normalizeFeatures($gejala);
        $normalizedCase = $this->normalizeFeatures($case->gejala ?? []);
        $matchedGejala = array_values(array_intersect($normalizedInput, $normalizedCase));

        $normalizedInputK = $this->normalizeFeatures($kondisi);
        $normalizedCaseK = $this->normalizeFeatures($case->kondisi ?? []);
        $matchedKondisi = array_values(array_intersect($normalizedInputK, $normalizedCaseK));

        return [
            'kategori' => ['similarity' => round($simKategori * 100, 1), 'match' => $simKategori > 0],
            'gejala' => ['similarity' => round($simGejala * 100, 1), 'matched' => $matchedGejala],
            'kondisi' => ['similarity' => round($simKondisi * 100, 1), 'matched' => $matchedKondisi],
        ];
    }

    /**
     * Jaccard Similarity: |A ∩ B| / |A ∪ B|
     */
    private function jaccardSimilarity(array $setA, array $setB): float
    {
        if (empty($setA) && empty($setB)) {
            return 1.0; // Both empty => identical
        }

        if (empty($setA) || empty($setB)) {
            return 0.0;
        }

        $intersection = array_intersect($setA, $setB);
        $union = array_unique(array_merge($setA, $setB));

        if (count($union) === 0) {
            return 0.0;
        }

        return count($intersection) / count($union);
    }

    /**
     * Normalize features for comparison (lowercase, trim).
     */
    private function normalizeFeatures(array $features): array
    {
        return array_values(array_map(function ($f) {
            return mb_strtolower(trim((string)$f));
        }, $features));
    }
}
