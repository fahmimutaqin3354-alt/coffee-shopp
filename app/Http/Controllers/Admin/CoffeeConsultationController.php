<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoffeeConsultation;
use App\Models\CoffeeQuestion;

class CoffeeConsultationController extends Controller
{
    /**
     * Display a listing of customer consultations.
     */
    public function index()
    {
        $consultations = CoffeeConsultation::with('user')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.sistem_pakar.riwayat.index', compact('consultations'));
    }

    /**
     * Display the specified consultation details.
     */
    public function show(int $id)
    {
        $consultation = CoffeeConsultation::with('user')->findOrFail($id);
        $questions = CoffeeQuestion::all()->keyBy('code');

        return view('admin.sistem_pakar.riwayat.show', compact('consultation', 'questions'));
    }

    /**
     * Remove the specified consultation log.
     */
    public function destroy(int $id)
    {
        $consultation = CoffeeConsultation::findOrFail($id);
        $consultation->delete();

        return redirect()->route('admin.riwayat.index')
            ->with('success', 'Riwayat konsultasi berhasil dihapus.');
    }
}
