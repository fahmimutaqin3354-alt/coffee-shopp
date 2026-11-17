<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoffeeQuestion;
use App\Models\CoffeeRule;
use App\Models\CoffeeRuleCondition;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoffeeRuleController extends Controller
{
    /**
     * Display a listing of rules.
     */
    public function index()
    {
        $rules = CoffeeRule::with(['targetMenu', 'conditions.question'])
            ->withCount('conditions')
            ->orderBy('priority', 'desc')
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.sistem_pakar.aturan.index', compact('rules'));
    }

    /**
     * Show the form for creating a new rule.
     */
    public function create()
    {
        $menus = Menu::where('is_active', true)->orderBy('nama_kopi', 'asc')->get();
        $questions = CoffeeQuestion::where('is_active', true)->orderBy('order', 'asc')->get();

        return view('admin.sistem_pakar.aturan.create', compact('menus', 'questions'));
    }

    /**
     * Store a newly created rule in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coffee_rules,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_menu_id' => 'required|exists:menus,id',
            'recommended_reason' => 'required|string',
            'priority' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'conditions' => 'required|array|min:1',
            'conditions.*.question_code' => 'required|string|exists:coffee_questions,code',
            'conditions.*.operator' => 'required|string|in:=,!=,in,not_in,>,<,>=,<=',
            'conditions.*.expected_value' => 'required|string|max:255',
            'conditions.*.condition_group' => 'nullable|string|in:AND,OR',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $rule = CoffeeRule::create([
                'code' => strtoupper(trim($validated['code'])),
                'name' => trim($validated['name']),
                'description' => $validated['description'] ?? null,
                'target_menu_id' => $validated['target_menu_id'],
                'recommended_reason' => trim($validated['recommended_reason']),
                'priority' => $validated['priority'] ?? 0,
                'is_active' => $request->has('is_active'),
            ]);

            foreach ($validated['conditions'] as $cond) {
                CoffeeRuleCondition::create([
                    'rule_id' => $rule->id,
                    'question_code' => $cond['question_code'],
                    'operator' => $cond['operator'] ?? '=',
                    'expected_value' => strtolower(trim($cond['expected_value'])),
                    'condition_group' => $cond['condition_group'] ?? 'AND',
                ]);
            }
        });

        return redirect()->route('admin.aturan.index')
            ->with('success', 'Aturan rekomendasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified rule.
     */
    public function edit(int $id)
    {
        $rule = CoffeeRule::with(['conditions', 'targetMenu'])->findOrFail($id);
        $menus = Menu::orderBy('nama_kopi', 'asc')->get();
        $questions = CoffeeQuestion::where('is_active', true)->orderBy('order', 'asc')->get();

        return view('admin.sistem_pakar.aturan.edit', compact('rule', 'menus', 'questions'));
    }

    /**
     * Update the specified rule in storage.
     */
    public function update(Request $request, int $id)
    {
        $rule = CoffeeRule::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coffee_rules,code,' . $rule->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_menu_id' => 'required|exists:menus,id',
            'recommended_reason' => 'required|string',
            'priority' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'conditions' => 'required|array|min:1',
            'conditions.*.question_code' => 'required|string|exists:coffee_questions,code',
            'conditions.*.operator' => 'required|string|in:=,!=,in,not_in,>,<,>=,<=',
            'conditions.*.expected_value' => 'required|string|max:255',
            'conditions.*.condition_group' => 'nullable|string|in:AND,OR',
        ]);

        DB::transaction(function () use ($rule, $validated, $request) {
            $rule->update([
                'code' => strtoupper(trim($validated['code'])),
                'name' => trim($validated['name']),
                'description' => $validated['description'] ?? null,
                'target_menu_id' => $validated['target_menu_id'],
                'recommended_reason' => trim($validated['recommended_reason']),
                'priority' => $validated['priority'] ?? 0,
                'is_active' => $request->has('is_active'),
            ]);

            // Recreate conditions
            CoffeeRuleCondition::where('rule_id', $rule->id)->delete();
            foreach ($validated['conditions'] as $cond) {
                CoffeeRuleCondition::create([
                    'rule_id' => $rule->id,
                    'question_code' => $cond['question_code'],
                    'operator' => $cond['operator'] ?? '=',
                    'expected_value' => strtolower(trim($cond['expected_value'])),
                    'condition_group' => $cond['condition_group'] ?? 'AND',
                ]);
            }
        });

        return redirect()->route('admin.aturan.index')
            ->with('success', 'Aturan rekomendasi berhasil diperbarui.');
    }

    /**
     * Toggle active status of a rule.
     */
    public function toggle(int $id)
    {
        $rule = CoffeeRule::findOrFail($id);
        $rule->is_active = !$rule->is_active;
        $rule->save();

        return redirect()->route('admin.aturan.index')
            ->with('success', 'Status aturan ' . $rule->code . ' berhasil diubah menjadi ' . ($rule->is_active ? 'Aktif' : 'Nonaktif') . '.');
    }

    /**
     * Remove the specified rule from storage.
     */
    public function destroy(int $id)
    {
        $rule = CoffeeRule::findOrFail($id);
        $code = $rule->code;
        $rule->delete();

        return redirect()->route('admin.aturan.index')
            ->with('success', "Aturan {$code} berhasil dihapus.");
    }
}
