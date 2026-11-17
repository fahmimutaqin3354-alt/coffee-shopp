<?php

namespace App\Http\Controllers;

use App\Models\CoffeeConsultation;
use App\Models\CoffeeQuestion;
use App\Services\CoffeeRecommendationService;
use Illuminate\Http\Request;

class CoffeeRecommendationController extends Controller
{
    protected CoffeeRecommendationService $recommendationService;

    public function __construct(CoffeeRecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    /**
     * Display the introductory page for coffee recommendation consultation.
     */
    public function index()
    {
        $questionCount = CoffeeQuestion::where('is_active', true)->count();
        return view('pelanggan.rekomendasi.index', compact('questionCount'));
    }

    /**
     * Display the interactive consultation question form.
     */
    public function consult()
    {
        $questions = CoffeeQuestion::where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        if ($questions->isEmpty()) {
            return redirect()->route('pelanggan.menu')
                ->with('info', 'Layanan konsultasi rekomendasi kopi sedang dalam pemeliharaan.');
        }

        return view('pelanggan.rekomendasi.konsultasi', compact('questions'));
    }

    /**
     * Process customer answers using Forward Chaining inference engine.
     */
    public function process(Request $request)
    {
        $questions = CoffeeQuestion::where('is_active', true)->get();

        // Build dynamic validation rules for all active questions
        $validationRules = [];
        $validationMessages = [];

        foreach ($questions as $q) {
            $allowedValues = collect($q->options)->pluck('value')->implode(',');
            $validationRules[$q->code] = ['required', 'string', 'in:' . $allowedValues];
            $validationMessages[$q->code . '.required'] = 'Pertanyaan "' . $q->question . '" wajib dijawab.';
            $validationMessages[$q->code . '.in'] = 'Jawaban untuk pertanyaan "' . $q->question . '" tidak valid.';
        }

        $validatedData = $request->validate($validationRules, $validationMessages);

        // Run Forward Chaining Inference Engine
        $result = $this->recommendationService->infer($validatedData);

        // Store consultation log into database
        $consultation = CoffeeConsultation::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'session_id' => session()->getId(),
            'answers' => $validatedData,
            'result_summary' => [
                'total_fired' => $result['total_fired'],
                'has_matches' => $result['has_matches'],
                'fired_rules' => $result['fired_rules'],
                'recommended_menus' => collect($result['recommendations'])->map(function ($r) {
                    return [
                        'menu_id' => $r['menu']->id,
                        'menu_nama' => $r['menu']->nama_kopi,
                        'reasons' => $r['reasons'],
                        'matched_rules' => $r['matched_rules'],
                    ];
                })->toArray(),
            ],
        ]);

        // Keep result in session for the result page
        session()->put('coffee_recommendation_result', $result);
        session()->put('coffee_recommendation_id', $consultation->id);

        return redirect()->route('rekomendasi.hasil');
    }

    /**
     * Display the recommendation result page.
     */
    public function result()
    {
        $result = session()->get('coffee_recommendation_result');

        if (!$result) {
            return redirect()->route('rekomendasi.konsultasi')
                ->with('warning', 'Silakan isi pertanyaan konsultasi terlebih dahulu.');
        }

        $questions = CoffeeQuestion::where('is_active', true)
            ->get()
            ->keyBy('code');

        return view('pelanggan.rekomendasi.hasil', [
            'result' => $result,
            'recommendations' => $result['recommendations'],
            'firedRules' => $result['fired_rules'],
            'userAnswers' => $result['user_answers'],
            'hasMatches' => $result['has_matches'],
            'questions' => $questions,
        ]);
    }
}
