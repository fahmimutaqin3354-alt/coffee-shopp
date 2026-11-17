<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CbrCase;
use App\Services\CbrReasoningService;
use Illuminate\Http\Request;

class CbrController extends Controller
{
    protected CbrReasoningService $cbrService;

    public function __construct(CbrReasoningService $cbrService)
    {
        $this->cbrService = $cbrService;
    }

    /**
     * Halaman utama: Daftar semua kasus (Case Base).
     */
    public function index()
    {
        $cases = CbrCase::orderByDesc('created_at')->get();
        $kategoris = CbrCase::distinct()->pluck('kategori_masalah')->sort()->values();
        $stats = [
            'total' => $cases->count(),
            'verified' => $cases->where('is_verified', true)->count(),
            'active' => $cases->where('is_active', true)->count(),
            'kategoris' => $kategoris->count(),
        ];

        return view('admin.cbr.index', compact('cases', 'kategoris', 'stats'));
    }

    /**
     * Form tambah kasus baru.
     */
    public function create()
    {
        $kategoris = CbrCase::distinct()->pluck('kategori_masalah')->sort()->values();
        return view('admin.cbr.create', compact('kategoris'));
    }

    /**
     * Simpan kasus baru (RETAIN).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_masalah' => 'required|string|max:255',
            'kategori_masalah' => 'required|string|max:100',
            'gejala' => 'required|array|min:1',
            'gejala.*' => 'required|string|max:255',
            'kondisi' => 'required|array|min:1',
            'kondisi.*' => 'required|string|max:255',
            'solusi' => 'required|string',
            'langkah_penanganan' => 'nullable|array',
            'langkah_penanganan.*' => 'nullable|string|max:500',
            'bobot' => 'nullable|numeric|min:0.1|max:1.0',
            'is_verified' => 'nullable|boolean',
        ]);

        // Filter empty items
        $validated['gejala'] = array_values(array_filter($validated['gejala'], fn($v) => trim($v) !== ''));
        $validated['kondisi'] = array_values(array_filter($validated['kondisi'], fn($v) => trim($v) !== ''));
        $validated['langkah_penanganan'] = array_values(array_filter($validated['langkah_penanganan'] ?? [], fn($v) => trim($v) !== ''));

        $case = $this->cbrService->retain($validated);

        return redirect()->route('admin.cbr.index')
            ->with('success', "Kasus baru [{$case->kode_kasus}] berhasil disimpan ke Case Base.");
    }

    /**
     * Form edit kasus.
     */
    public function edit($id)
    {
        $case = CbrCase::findOrFail($id);
        $kategoris = CbrCase::distinct()->pluck('kategori_masalah')->sort()->values();
        return view('admin.cbr.edit', compact('case', 'kategoris'));
    }

    /**
     * Update kasus (REVISE).
     */
    public function update(Request $request, $id)
    {
        $case = CbrCase::findOrFail($id);

        $validated = $request->validate([
            'judul_masalah' => 'required|string|max:255',
            'kategori_masalah' => 'required|string|max:100',
            'gejala' => 'required|array|min:1',
            'gejala.*' => 'required|string|max:255',
            'kondisi' => 'required|array|min:1',
            'kondisi.*' => 'required|string|max:255',
            'solusi' => 'required|string',
            'langkah_penanganan' => 'nullable|array',
            'langkah_penanganan.*' => 'nullable|string|max:500',
            'bobot' => 'nullable|numeric|min:0.1|max:1.0',
            'is_verified' => 'nullable|boolean',
        ]);

        $validated['gejala'] = array_values(array_filter($validated['gejala'], fn($v) => trim($v) !== ''));
        $validated['kondisi'] = array_values(array_filter($validated['kondisi'], fn($v) => trim($v) !== ''));
        $validated['langkah_penanganan'] = array_values(array_filter($validated['langkah_penanganan'] ?? [], fn($v) => trim($v) !== ''));
        $validated['is_verified'] = $request->boolean('is_verified');

        $case->update($validated);

        return redirect()->route('admin.cbr.index')
            ->with('success', "Kasus [{$case->kode_kasus}] berhasil diperbarui.");
    }

    /**
     * Hapus kasus.
     */
    public function destroy($id)
    {
        $case = CbrCase::findOrFail($id);
        $kode = $case->kode_kasus;
        $case->delete();

        return redirect()->route('admin.cbr.index')
            ->with('success', "Kasus [{$kode}] berhasil dihapus dari Case Base.");
    }

    /**
     * Toggle aktif/nonaktif kasus.
     */
    public function toggle($id)
    {
        $case = CbrCase::findOrFail($id);
        $case->is_active = !$case->is_active;
        $case->save();

        $status = $case->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Kasus [{$case->kode_kasus}] berhasil {$status}.");
    }

    /**
     * Halaman konsultasi CBR — Admin input masalah, sistem cari kasus mirip.
     */
    public function konsultasi()
    {
        $kategoris = CbrCase::where('is_active', true)->distinct()->pluck('kategori_masalah')->sort()->values();
        $allGejala = CbrCase::where('is_active', true)->pluck('gejala')->flatten()->unique()->sort()->values();
        $allKondisi = CbrCase::where('is_active', true)->pluck('kondisi')->flatten()->unique()->sort()->values();

        return view('admin.cbr.konsultasi', compact('kategoris', 'allGejala', 'allKondisi'));
    }

    /**
     * Proses konsultasi CBR — RETRIEVE + REUSE.
     */
    public function prosesKonsultasi(Request $request)
    {
        $validated = $request->validate([
            'kategori_masalah' => 'required|string',
            'gejala' => 'required|array|min:1',
            'gejala.*' => 'required|string',
            'kondisi' => 'required|array|min:1',
            'kondisi.*' => 'required|string',
        ]);

        $gejala = array_values(array_filter($validated['gejala'], fn($v) => trim($v) !== ''));
        $kondisi = array_values(array_filter($validated['kondisi'], fn($v) => trim($v) !== ''));

        // Step 1: RETRIEVE
        $retrieveResults = $this->cbrService->retrieve(
            $validated['kategori_masalah'],
            $gejala,
            $kondisi,
            0.10 // low threshold to show partial matches too
        );

        // Step 2: REUSE
        $reuseSolution = $this->cbrService->reuse($retrieveResults);

        $kategoris = CbrCase::where('is_active', true)->distinct()->pluck('kategori_masalah')->sort()->values();
        $allGejala = CbrCase::where('is_active', true)->pluck('gejala')->flatten()->unique()->sort()->values();
        $allKondisi = CbrCase::where('is_active', true)->pluck('kondisi')->flatten()->unique()->sort()->values();

        return view('admin.cbr.konsultasi', compact(
            'kategoris', 'allGejala', 'allKondisi',
            'retrieveResults', 'reuseSolution'
        ))->withInput($validated);
    }

    /**
     * Simpan kasus baru dari hasil konsultasi (RETAIN dari halaman konsultasi).
     */
    public function retainFromKonsultasi(Request $request)
    {
        $validated = $request->validate([
            'judul_masalah' => 'required|string|max:255',
            'kategori_masalah' => 'required|string|max:100',
            'gejala' => 'required|array|min:1',
            'gejala.*' => 'required|string',
            'kondisi' => 'required|array|min:1',
            'kondisi.*' => 'required|string',
            'solusi' => 'required|string',
            'langkah_penanganan' => 'nullable|array',
            'langkah_penanganan.*' => 'nullable|string',
        ]);

        $validated['gejala'] = array_values(array_filter($validated['gejala'], fn($v) => trim($v) !== ''));
        $validated['kondisi'] = array_values(array_filter($validated['kondisi'], fn($v) => trim($v) !== ''));
        $validated['langkah_penanganan'] = array_values(array_filter($validated['langkah_penanganan'] ?? [], fn($v) => trim($v) !== ''));

        $case = $this->cbrService->retain($validated);

        return redirect()->route('admin.cbr.konsultasi')
            ->with('success', "Kasus baru [{$case->kode_kasus}] berhasil disimpan ke Case Base (RETAIN).");
    }
}
