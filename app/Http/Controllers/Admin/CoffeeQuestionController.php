<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoffeeQuestion;
use App\Models\CoffeeRuleCondition;
use Illuminate\Http\Request;

class CoffeeQuestionController extends Controller
{
    /**
     * Display a listing of questions.
     */
    public function index()
    {
        $questions = CoffeeQuestion::withCount('conditions')
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.sistem_pakar.pertanyaan.index', compact('questions'));
    }

    /**
     * Show the form for creating a new question.
     */
    public function create()
    {
        return view('admin.sistem_pakar.pertanyaan.create');
    }

    /**
     * Store a newly created question in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coffee_questions,code',
            'question' => 'required|string',
            'input_type' => 'required|string|in:radio,select',
            'order' => 'required|integer|min:0',
            'options' => 'required|array|min:2',
            'options.*.value' => 'required|string|max:50',
            'options.*.label' => 'required|string|max:100',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        // Clean options values to lowercase trimmed
        $cleanOptions = [];
        foreach ($validated['options'] as $opt) {
            $cleanOptions[] = [
                'value' => strtolower(trim($opt['value'])),
                'label' => trim($opt['label']),
            ];
        }
        $validated['options'] = $cleanOptions;

        CoffeeQuestion::create($validated);

        return redirect()->route('admin.pertanyaan.index')
            ->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(int $id)
    {
        $question = CoffeeQuestion::findOrFail($id);
        return view('admin.sistem_pakar.pertanyaan.edit', compact('question'));
    }

    /**
     * Update the specified question in storage.
     */
    public function update(Request $request, int $id)
    {
        $question = CoffeeQuestion::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coffee_questions,code,' . $question->id,
            'question' => 'required|string',
            'input_type' => 'required|string|in:radio,select',
            'order' => 'required|integer|min:0',
            'options' => 'required|array|min:2',
            'options.*.value' => 'required|string|max:50',
            'options.*.label' => 'required|string|max:100',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $cleanOptions = [];
        foreach ($validated['options'] as $opt) {
            $cleanOptions[] = [
                'value' => strtolower(trim($opt['value'])),
                'label' => trim($opt['label']),
            ];
        }
        $validated['options'] = $cleanOptions;

        $question->update($validated);

        return redirect()->route('admin.pertanyaan.index')
            ->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    /**
     * Toggle active status of a question.
     */
    public function toggle(int $id)
    {
        $question = CoffeeQuestion::findOrFail($id);
        $question->is_active = !$question->is_active;
        $question->save();

        return redirect()->route('admin.pertanyaan.index')
            ->with('success', 'Status pertanyaan ' . $question->code . ' berhasil diubah.');
    }

    /**
     * Remove the specified question from storage.
     */
    public function destroy(int $id)
    {
        $question = CoffeeQuestion::findOrFail($id);

        $conditionsCount = CoffeeRuleCondition::where('question_code', $question->code)->count();
        if ($conditionsCount > 0) {
            return redirect()->route('admin.pertanyaan.index')
                ->with('error', "Pertanyaan {$question->code} tidak dapat dihapus karena digunakan oleh {$conditionsCount} kondisi aturan.");
        }

        $question->delete();

        return redirect()->route('admin.pertanyaan.index')
            ->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
