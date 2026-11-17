<?php

namespace App\Services;

use App\Models\CoffeeQuestion;
use App\Models\CoffeeRule;
use App\Models\Menu;
use Illuminate\Support\Collection;

class CoffeeRecommendationService
{
    /**
     * Alias mapping between question code and descriptive semantic names.
     */
    protected array $codeAliases = [
        'p01' => 'kekuatan_kopi',
        'p02' => 'kemanisan',
        'p03' => 'suka_susu',
        'p04' => 'kepahitan',
        'p05' => 'suka_espresso',
        'p06' => 'suhu',
    ];

    /**
     * Run the Forward Chaining inference engine on user answers.
     *
     * @param array $userAnswers [ 'P01' => 'tinggi', ... ]
     * @return array [ 'facts' => ..., 'recommendations' => ..., 'fired_rules' => ... ]
     */
    public function infer(array $userAnswers): array
    {
        // 1. Terima dan normalisasi fakta awal dari jawaban pelanggan
        $workingMemory = $this->buildInitialFacts($userAnswers);

        // 2. Ambil seluruh rule aktif dari knowledge base beserta kondisi dan menu tujuannya
        $rules = CoffeeRule::with(['conditions', 'targetMenu'])
            ->where('is_active', true)
            ->orderBy('priority', 'desc')
            ->orderBy('id', 'asc')
            ->get();

        $firedRules = [];
        $menuRecommendations = [];

        // 3. Mesin Inferensi: Evaluasi kondisi setiap rule terhadap fakta dalam working memory
        foreach ($rules as $rule) {
            // Validasi rule: Rule harus memiliki kondisi dan menu tujuan yang valid
            if ($rule->conditions->isEmpty()) {
                continue;
            }

            if (!$rule->targetMenu || $rule->targetMenu->is_active === false) {
                continue;
            }

            if ($this->evaluateRuleConditions($rule, $workingMemory)) {
                // Rule aktif / terpenuhi!
                $firedRules[] = [
                    'id' => $rule->id,
                    'code' => $rule->code,
                    'name' => $rule->name,
                    'description' => $rule->description,
                    'target_menu_id' => $rule->target_menu_id,
                    'target_menu_name' => $rule->targetMenu->nama_kopi,
                    'recommended_reason' => $rule->recommended_reason,
                ];

                // Tambahkan kesimpulan ke working memory jika rule berantai (derived facts)
                $workingMemory['rule_fired_' . strtolower($rule->code)] = true;
                $workingMemory['recommended_menu_' . $rule->target_menu_id] = true;

                // Catat menu tujuan
                $menuId = $rule->target_menu_id;
                if (!isset($menuRecommendations[$menuId])) {
                    $menuRecommendations[$menuId] = [
                        'menu' => $rule->targetMenu,
                        'reasons' => [],
                        'matched_rules' => [],
                        'serving_suggestion' => null,
                    ];
                }

                if (!empty($rule->recommended_reason)) {
                    $menuRecommendations[$menuId]['reasons'][] = $rule->recommended_reason;
                } elseif (!empty($rule->description)) {
                    $menuRecommendations[$menuId]['reasons'][] = $rule->description;
                }

                $menuRecommendations[$menuId]['matched_rules'][] = $rule->code . ' (' . $rule->name . ')';
            }
        }

        // 4. Evaluasi suhu penyajian (P06 / suhu) terhadap rekomendasi
        $temperaturePref = $workingMemory['suhu'] ?? ($workingMemory['p06'] ?? null);
        foreach ($menuRecommendations as $menuId => &$rec) {
            $rec['reasons'] = array_values(array_unique($rec['reasons']));
            $rec['matched_rules'] = array_values(array_unique($rec['matched_rules']));

            if ($temperaturePref === 'dingin') {
                $rec['serving_suggestion'] = 'Disajikan Dingin (Es)';
            } elseif ($temperaturePref === 'panas') {
                $rec['serving_suggestion'] = 'Disajikan Hangat (Panas)';
            } else {
                $rec['serving_suggestion'] = 'Dapat dinikmati hangat maupun dingin';
            }
        }
        unset($rec);

        // 5. Hilangkan duplikat dan susun hasil akhir
        $finalRecommendations = array_values($menuRecommendations);

        return [
            'facts' => $workingMemory,
            'user_answers' => $userAnswers,
            'fired_rules' => $firedRules,
            'recommendations' => $finalRecommendations,
            'total_fired' => count($firedRules),
            'has_matches' => count($finalRecommendations) > 0,
        ];
    }

    /**
     * Build the working memory facts from user inputs.
     */
    protected function buildInitialFacts(array $userAnswers): array
    {
        $facts = [];

        foreach ($userAnswers as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            $normalizedKey = strtolower(trim($key));
            $normalizedValue = is_string($value) ? strtolower(trim($value)) : $value;

            $facts[$normalizedKey] = $normalizedValue;

            // Map aliases (e.g. 'P01' -> 'kekuatan_kopi')
            if (isset($this->codeAliases[$normalizedKey])) {
                $facts[$this->codeAliases[$normalizedKey]] = $normalizedValue;
            }

            // Reverse map (e.g. 'kekuatan_kopi' -> 'P01')
            $reverseKey = array_search($normalizedKey, $this->codeAliases, true);
            if ($reverseKey !== false) {
                $facts[$reverseKey] = $normalizedValue;
            }
        }

        return $facts;
    }

    /**
     * Evaluate all conditions of a rule against the current facts in working memory.
     */
    protected function evaluateRuleConditions(CoffeeRule $rule, array $facts): bool
    {
        $conditions = $rule->conditions;

        if ($conditions->isEmpty()) {
            return false;
        }

        // Group conditions by condition_group (e.g., 'AND' groups)
        // Default evaluation: ALL conditions must be true (AND logic).
        // If conditions have groups, we can evaluate groups.
        $hasOrGroups = $conditions->contains('condition_group', 'OR');

        if (!$hasOrGroups) {
            // Simple AND: All conditions must be satisfied
            foreach ($conditions as $condition) {
                if (!$this->isConditionSatisfied($condition, $facts)) {
                    return false;
                }
            }
            return true;
        }

        // Support for AND / OR groups
        $groups = $conditions->groupBy(function ($item) {
            return strtoupper(trim($item->condition_group ?: 'AND'));
        });

        // 1. Mandatory AND conditions
        if (isset($groups['AND'])) {
            foreach ($groups['AND'] as $cond) {
                if (!$this->isConditionSatisfied($cond, $facts)) {
                    return false;
                }
            }
        }

        // 2. OR conditions: At least one must be satisfied
        if (isset($groups['OR'])) {
            $orSatisfied = false;
            foreach ($groups['OR'] as $cond) {
                if ($this->isConditionSatisfied($cond, $facts)) {
                    $orSatisfied = true;
                    break;
                }
            }
            if (!$orSatisfied) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if a single condition is satisfied against working memory.
     */
    protected function isConditionSatisfied($condition, array $facts): bool
    {
        $questionCode = strtolower(trim($condition->question_code));
        $operator = trim($condition->operator ?: '=');
        $expectedValue = strtolower(trim((string)$condition->expected_value));

        // Get actual fact value
        $factValue = null;
        if (array_key_exists($questionCode, $facts)) {
            $factValue = $facts[$questionCode];
        } elseif (isset($this->codeAliases[$questionCode]) && array_key_exists($this->codeAliases[$questionCode], $facts)) {
            $factValue = $facts[$this->codeAliases[$questionCode]];
        } else {
            // Reverse lookup
            $rev = array_search($questionCode, $this->codeAliases, true);
            if ($rev !== false && array_key_exists($rev, $facts)) {
                $factValue = $facts[$rev];
            }
        }

        if ($factValue === null) {
            return false;
        }

        $factValueStr = is_string($factValue) ? strtolower(trim($factValue)) : (string)$factValue;

        switch ($operator) {
            case '=':
            case '==':
                return $factValueStr === $expectedValue;

            case '!=':
            case '<>':
                return $factValueStr !== $expectedValue;

            case 'in':
                $allowed = array_map('trim', explode(',', $expectedValue));
                return in_array($factValueStr, $allowed, true);

            case 'not_in':
                $allowed = array_map('trim', explode(',', $expectedValue));
                return !in_array($factValueStr, $allowed, true);

            case '>':
                return is_numeric($factValueStr) && is_numeric($expectedValue) && ((float)$factValueStr > (float)$expectedValue);

            case '>=':
                return is_numeric($factValueStr) && is_numeric($expectedValue) && ((float)$factValueStr >= (float)$expectedValue);

            case '<':
                return is_numeric($factValueStr) && is_numeric($expectedValue) && ((float)$factValueStr < (float)$expectedValue);

            case '<=':
                return is_numeric($factValueStr) && is_numeric($expectedValue) && ((float)$factValueStr <= (float)$expectedValue);

            default:
                return $factValueStr === $expectedValue;
        }
    }
}
