<?php

namespace App\Services;

class FuzzyStockService
{
    /**
     * Hitung inferensi Fuzzy Logic (Metode Tsukamoto / Mamdani)
     * untuk rekomendasi pengelolaan stok bahan baku kafe.
     *
     * @param float $stok Tersedia (unit/kg/liter/dll)
     * @param float $permintaan Rata-rata harian (unit/kg/liter/dll)
     * @param float $kapasitas Kapasitas maksimal penyimpanan
     * @param int $leadTime Estimasi waktu tunggu pengiriman supplier (hari)
     * @param float $stokMinimum Batas aman minimum
     * @return array
     */
    public function evaluate(
        float $stok,
        float $permintaan,
        float $kapasitas = 50.0,
        int $leadTime = 2,
        float $stokMinimum = 5.0
    ): array {
        // Amankan nilai agar tidak ada angka negatif
        $stok = max(0.0, $stok);
        $permintaan = max(0.01, $permintaan);
        $kapasitas = max(1.0, $kapasitas);
        $leadTime = max(1, $leadTime);
        $stokMinimum = max(0.1, $stokMinimum);

        // 1. Fuzzifikasi Variabel 1: Persentase Stok Tersedia terhadap Kapasitas Normal
        // Rasio stok (%) = (Stok / Kapasitas) * 100
        $stokPct = ($stok / $kapasitas) * 100.0;

        // Derajat keanggotaan Stok: Rendah, Sedang, Tinggi
        $muStokRendah = $this->membershipStokRendah($stokPct);
        $muStokSedang = $this->membershipStokSedang($stokPct);
        $muStokTinggi = $this->membershipStokTinggi($stokPct);

        // 2. Fuzzifikasi Variabel 2: Laju Permintaan / Konsumsi
        // Dihitung berdasarkan rasio hari ketahanan stok atau rasio permintaan terhadap kapasitas (harian)
        // Standar kafe: kebutuhan 14 hari = kapasitas normal.
        $permintaanNormalHarian = max(0.5, $kapasitas / 14.0);
        $permintaanRatioPct = ($permintaan / $permintaanNormalHarian) * 100.0;

        $muPermintaanRendah = $this->membershipPermintaanRendah($permintaanRatioPct);
        $muPermintaanSedang = $this->membershipPermintaanSedang($permintaanRatioPct);
        $muPermintaanTinggi = $this->membershipPermintaanTinggi($permintaanRatioPct);

        // 3. Fuzzifikasi Variabel 3: Buffer Kebutuhan / Lead Time Urgensi
        // Kebutuhan saat lead time = permintaan * lead time
        $kebutuhanLeadTime = $permintaan * $leadTime;
        $kebutuhanMingguan = $permintaan * 7.0;

        // 4. Evaluasi Basis Aturan (Fuzzy Rules - Tsukamoto / Mamdani)
        // Output Universe: Nilai Derajat Kelayakan Restok (0 - 100)
        // Nilai crisp z untuk masing-masing konsekuen:
        // - "Restok Segera" (Prioritas Tinggi): z = 80 s/d 100
        // - "Perlu Restok" (Prioritas Sedang): z = 45 s/d 65
        // - "Stok Masih Aman" (Prioritas Rendah): z = 10 s/d 30
        $rules = [
            [
                'code' => 'R1',
                'name' => 'IF Stok Rendah AND Permintaan Rendah THEN Perlu Restok',
                'stok_label' => 'Rendah',
                'permintaan_label' => 'Rendah',
                'mu_stok' => $muStokRendah,
                'mu_permintaan' => $muPermintaanRendah,
                'alpha' => min($muStokRendah, $muPermintaanRendah),
                'consequent' => 'Perlu Restok',
                'z' => 60.0,
            ],
            [
                'code' => 'R2',
                'name' => 'IF Stok Rendah AND Permintaan Sedang THEN Restok Segera',
                'stok_label' => 'Rendah',
                'permintaan_label' => 'Sedang',
                'mu_stok' => $muStokRendah,
                'mu_permintaan' => $muPermintaanSedang,
                'alpha' => min($muStokRendah, $muPermintaanSedang),
                'consequent' => 'Restok Segera',
                'z' => 88.0,
            ],
            [
                'code' => 'R3',
                'name' => 'IF Stok Rendah AND Permintaan Tinggi THEN Restok Segera',
                'stok_label' => 'Rendah',
                'permintaan_label' => 'Tinggi',
                'mu_stok' => $muStokRendah,
                'mu_permintaan' => $muPermintaanTinggi,
                'alpha' => min($muStokRendah, $muPermintaanTinggi),
                'consequent' => 'Restok Segera',
                'z' => 100.0,
            ],
            [
                'code' => 'R4',
                'name' => 'IF Stok Sedang AND Permintaan Rendah THEN Stok Masih Aman',
                'stok_label' => 'Sedang',
                'permintaan_label' => 'Rendah',
                'mu_stok' => $muStokSedang,
                'mu_permintaan' => $muPermintaanRendah,
                'alpha' => min($muStokSedang, $muPermintaanRendah),
                'consequent' => 'Stok Masih Aman',
                'z' => 25.0,
            ],
            [
                'code' => 'R5',
                'name' => 'IF Stok Sedang AND Permintaan Sedang THEN Perlu Restok',
                'stok_label' => 'Sedang',
                'permintaan_label' => 'Sedang',
                'mu_stok' => $muStokSedang,
                'mu_permintaan' => $muPermintaanSedang,
                'alpha' => min($muStokSedang, $muPermintaanSedang),
                'consequent' => 'Perlu Restok',
                'z' => 55.0,
            ],
            [
                'code' => 'R6',
                'name' => 'IF Stok Sedang AND Permintaan Tinggi THEN Restok Segera',
                'stok_label' => 'Sedang',
                'permintaan_label' => 'Tinggi',
                'mu_stok' => $muStokSedang,
                'mu_permintaan' => $muPermintaanTinggi,
                'alpha' => min($muStokSedang, $muPermintaanTinggi),
                'consequent' => 'Restok Segera',
                'z' => 80.0,
            ],
            [
                'code' => 'R7',
                'name' => 'IF Stok Tinggi AND Permintaan Rendah THEN Stok Masih Aman',
                'stok_label' => 'Tinggi',
                'permintaan_label' => 'Rendah',
                'mu_stok' => $muStokTinggi,
                'mu_permintaan' => $muPermintaanRendah,
                'alpha' => min($muStokTinggi, $muPermintaanRendah),
                'consequent' => 'Stok Masih Aman',
                'z' => 10.0,
            ],
            [
                'code' => 'R8',
                'name' => 'IF Stok Tinggi AND Permintaan Sedang THEN Stok Masih Aman',
                'stok_label' => 'Tinggi',
                'permintaan_label' => 'Sedang',
                'mu_stok' => $muStokTinggi,
                'mu_permintaan' => $muPermintaanSedang,
                'alpha' => min($muStokTinggi, $muPermintaanSedang),
                'consequent' => 'Stok Masih Aman',
                'z' => 30.0,
            ],
            [
                'code' => 'R9',
                'name' => 'IF Stok Tinggi AND Permintaan Tinggi THEN Perlu Restok',
                'stok_label' => 'Tinggi',
                'permintaan_label' => 'Tinggi',
                'mu_stok' => $muStokTinggi,
                'mu_permintaan' => $muPermintaanTinggi,
                'alpha' => min($muStokTinggi, $muPermintaanTinggi),
                'consequent' => 'Perlu Restok',
                'z' => 50.0,
            ],
        ];

        // 5. Defuzzifikasi Rata-Rata Terbobot (Weighted Average / Tsukamoto Centroid)
        $numerator = 0.0;
        $denominator = 0.0;
        $activeRules = [];

        foreach ($rules as $rule) {
            if ($rule['alpha'] > 0.0001) {
                $numerator += ($rule['alpha'] * $rule['z']);
                $denominator += $rule['alpha'];
                $activeRules[] = $rule;
            }
        }

        if ($denominator > 0) {
            $crispValue = $numerator / $denominator;
        } else {
            // Default netral jika tidak ada irisan aktif
            $crispValue = 50.0;
        }

        $crispValue = round(min(100.0, max(0.0, $crispValue)), 2);

        // 6. Penentuan Kategori Status & Warna
        if ($crispValue >= 70.0) {
            $status = 'Restok Segera';
            $warna = '#B94A48'; // Merah Bata
            $bgWarna = '#FDF2F2';
            $badgeClass = 'badge-danger-fuzzy';
            $prioritas = 'Tinggi';
            $keteranganAksi = 'Stok menipis atau berada di bawah ambang batas aman. Segera lakukan pesanan ke supplier.';
        } elseif ($crispValue >= 40.0) {
            $status = 'Perlu Restok';
            $warna = '#D99B26'; // Oranye / Kuning Hangat
            $bgWarna = '#FEF9E7';
            $badgeClass = 'badge-warning-fuzzy';
            $prioritas = 'Sedang';
            $keteranganAksi = 'Stok masih mencukupi beberapa hari ke depan, namun mulai mendekati batas pemesanan ulang (Reorder Point).';
        } else {
            $status = 'Stok Masih Aman';
            $warna = '#4E7852'; // Hijau Sage
            $bgWarna = '#F0FDF4';
            $badgeClass = 'badge-success-fuzzy';
            $prioritas = 'Rendah';
            $keteranganAksi = 'Persediaan bahan baku sangat mencukupi untuk operasional kafe saat ini.';
        }

        // 7. Estimasi Kuantitas Bahan yang Disarankan untuk Dibeli (Reorder Quantity)
        // Target persediaan = Kapasitas maksimal atau (Lead Time Kebutuhan + Safety Stock)
        $targetStok = $kapasitas;
        $kekuranganStok = max(0.0, $targetStok - $stok + $kebutuhanLeadTime);
        $faktorUrgensi = $crispValue / 100.0;

        if ($crispValue < 40.0) {
            $saranRestok = 0.0;
        } else {
            // Saran kuantitas disesuaikan dengan derajat fuzzy
            $saranRestok = round($kekuranganStok * max(0.6, $faktorUrgensi), 1);
            if ($saranRestok > 0 && $saranRestok < 1.0 && $kapasitas > 5) {
                $saranRestok = 1.0;
            }
        }

        // Estimasi hari ketahanan stok (Days of Inventory)
        $hariKetahanan = $permintaan > 0 ? round($stok / $permintaan, 1) : 999;

        return [
            'skor' => $crispValue,
            'status' => $status,
            'warna' => $warna,
            'bg_warna' => $bgWarna,
            'badge_class' => $badgeClass,
            'prioritas' => $prioritas,
            'keterangan_aksi' => $keteranganAksi,
            'saran_restok' => $saranRestok,
            'hari_ketahanan' => $hariKetahanan,
            'kebutuhan_lead_time' => round($kebutuhanLeadTime, 2),
            'kebutuhan_mingguan' => round($kebutuhanMingguan, 2),
            'fuzzifikasi' => [
                'stok' => [
                    'persen' => round($stokPct, 1),
                    'rendah' => round($muStokRendah, 3),
                    'sedang' => round($muStokSedang, 3),
                    'tinggi' => round($muStokTinggi, 3),
                ],
                'permintaan' => [
                    'persen' => round($permintaanRatioPct, 1),
                    'rendah' => round($muPermintaanRendah, 3),
                    'sedang' => round($muPermintaanSedang, 3),
                    'tinggi' => round($muPermintaanTinggi, 3),
                ],
            ],
            'rules' => $rules,
            'active_rules' => $activeRules,
            'numerator' => round($numerator, 2),
            'denominator' => round($denominator, 3),
        ];
    }

    // --- Membership Functions (Kurva Segitiga & Trapesium) ---

    /**
     * Kurva Trapesium Bahu Kiri: Stok Rendah (0 - 50%)
     */
    private function membershipStokRendah(float $x): float
    {
        if ($x <= 25.0) {
            return 1.0;
        }
        if ($x > 25.0 && $x < 50.0) {
            return (50.0 - $x) / (50.0 - 25.0);
        }
        return 0.0;
    }

    /**
     * Kurva Segitiga: Stok Sedang (25% - 75%, puncak 50%)
     */
    private function membershipStokSedang(float $x): float
    {
        if ($x <= 25.0 || $x >= 75.0) {
            return 0.0;
        }
        if ($x > 25.0 && $x <= 50.0) {
            return ($x - 25.0) / (50.0 - 25.0);
        }
        if ($x > 50.0 && $x < 75.0) {
            return (75.0 - $x) / (75.0 - 50.0);
        }
        return 0.0;
    }

    /**
     * Kurva Trapesium Bahu Kanan: Stok Tinggi (50% - 100%+)
     */
    private function membershipStokTinggi(float $x): float
    {
        if ($x <= 50.0) {
            return 0.0;
        }
        if ($x > 50.0 && $x < 75.0) {
            return ($x - 50.0) / (75.0 - 50.0);
        }
        return 1.0;
    }

    /**
     * Kurva Trapesium Bahu Kiri: Permintaan Rendah (0 - 80%)
     */
    private function membershipPermintaanRendah(float $x): float
    {
        if ($x <= 50.0) {
            return 1.0;
        }
        if ($x > 50.0 && $x < 85.0) {
            return (85.0 - $x) / (85.0 - 50.0);
        }
        return 0.0;
    }

    /**
     * Kurva Segitiga: Permintaan Sedang (50% - 140%, puncak 100%)
     */
    private function membershipPermintaanSedang(float $x): float
    {
        if ($x <= 50.0 || $x >= 140.0) {
            return 0.0;
        }
        if ($x > 50.0 && $x <= 100.0) {
            return ($x - 50.0) / (100.0 - 50.0);
        }
        if ($x > 100.0 && $x < 140.0) {
            return (140.0 - $x) / (140.0 - 100.0);
        }
        return 0.0;
    }

    /**
     * Kurva Trapesium Bahu Kanan: Permintaan Tinggi (100%+)
     */
    private function membershipPermintaanTinggi(float $x): float
    {
        if ($x <= 100.0) {
            return 0.0;
        }
        if ($x > 100.0 && $x < 140.0) {
            return ($x - 100.0) / (140.0 - 100.0);
        }
        return 1.0;
    }
}
