<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use App\Services\FuzzyStockService;
use Illuminate\Http\Request;

class FuzzyStockController extends Controller
{
    protected FuzzyStockService $fuzzyService;

    public function __construct(FuzzyStockService $fuzzyService)
    {
        $this->fuzzyService = $fuzzyService;
    }

    /**
     * Tampilkan halaman utama Sistem Pakar Rekomendasi Stok Fuzzy.
     */
    public function index(Request $request)
    {
        $kategoriFilter = $request->query('kategori');
        $search = $request->query('search');

        $query = BahanBaku::query();

        if ($kategoriFilter && $kategoriFilter !== 'Semua') {
            $query->where('kategori', $kategoriFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_bahan', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $bahanBakus = $query->orderBy('nama_bahan', 'asc')->get();

        // Hitung hasil Fuzzy untuk setiap bahan baku
        $restokSegeraCount = 0;
        $perluRestokCount = 0;
        $stokAmanCount = 0;
        $totalEstimasiBiayaRestok = 0;

        foreach ($bahanBakus as $bahan) {
            $eval = $this->fuzzyService->evaluate(
                (float) $bahan->stok,
                (float) $bahan->rata_rata_harian,
                (float) $bahan->kapasitas_maksimal,
                (int) $bahan->lead_time_hari,
                (float) $bahan->stok_minimum
            );

            $bahan->fuzzy = $eval;

            if ($eval['status'] === 'Restok Segera') {
                $restokSegeraCount++;
            } elseif ($eval['status'] === 'Perlu Restok') {
                $perluRestokCount++;
            } else {
                $stokAmanCount++;
            }

            if ($eval['saran_restok'] > 0 && $bahan->harga_satuan > 0) {
                $totalEstimasiBiayaRestok += ($eval['saran_restok'] * $bahan->harga_satuan);
            }
        }

        $kategoris = BahanBaku::select('kategori')->distinct()->pluck('kategori');

        return view('admin.fuzzy_stok.index', compact(
            'bahanBakus',
            'restokSegeraCount',
            'perluRestokCount',
            'stokAmanCount',
            'totalEstimasiBiayaRestok',
            'kategoris',
            'kategoriFilter',
            'search'
        ));
    }

    /**
     * Hitung simulasi mandiri kalkulator Fuzzy via AJAX atau POST.
     */
    public function simulate(Request $request)
    {
        $validated = $request->validate([
            'nama_bahan' => 'nullable|string|max:100',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'nullable|string|max:20',
            'rata_rata_harian' => 'required|numeric|min:0.01',
            'kapasitas_maksimal' => 'required|numeric|min:0.1',
            'lead_time_hari' => 'nullable|integer|min:1',
            'stok_minimum' => 'nullable|numeric|min:0',
        ]);

        $stok = (float) $validated['stok'];
        $permintaan = (float) $validated['rata_rata_harian'];
        $kapasitas = (float) $validated['kapasitas_maksimal'];
        $leadTime = (int) ($validated['lead_time_hari'] ?? 2);
        $stokMinimum = (float) ($validated['stok_minimum'] ?? ($kapasitas * 0.2));

        $result = $this->fuzzyService->evaluate(
            $stok,
            $permintaan,
            $kapasitas,
            $leadTime,
            $stokMinimum
        );

        $result['input'] = [
            'nama_bahan' => $validated['nama_bahan'] ?? 'Simulasi Bahan Baku',
            'stok' => $stok,
            'satuan' => $validated['satuan'] ?? 'unit',
            'rata_rata_harian' => $permintaan,
            'kapasitas_maksimal' => $kapasitas,
            'lead_time_hari' => $leadTime,
            'stok_minimum' => $stokMinimum,
        ];

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        }

        return back()->with('simulation_result', $result);
    }

    /**
     * Aksi Cepat Restok: Menambahkan kuantitas stok yang baru tiba.
     */
    public function quickRestock(Request $request, $id)
    {
        $validated = $request->validate([
            'jumlah_tambah' => 'required|numeric|min:0.01',
            'keterangan_restok' => 'nullable|string|max:255',
        ]);

        $bahan = BahanBaku::findOrFail($id);
        $bahan->stok += (float) $validated['jumlah_tambah'];
        $bahan->save();

        return redirect()->back()->with('success', "Stok {$bahan->nama_bahan} berhasil ditambah sebanyak {$validated['jumlah_tambah']} {$bahan->satuan}. Total stok saat ini: {$bahan->stok} {$bahan->satuan}.");
    }

    /**
     * Tambah data bahan baku baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:30',
            'rata_rata_harian' => 'required|numeric|min:0',
            'stok_minimum' => 'required|numeric|min:0',
            'kapasitas_maksimal' => 'required|numeric|min:0.1',
            'lead_time_hari' => 'required|integer|min:1',
            'harga_satuan' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        BahanBaku::create($validated);

        return redirect()->route('admin.fuzzy-stok.index')->with('success', "Bahan baku '{$validated['nama_bahan']}' berhasil ditambahkan ke inventaris.");
    }

    /**
     * Update data bahan baku.
     */
    public function update(Request $request, $id)
    {
        $bahan = BahanBaku::findOrFail($id);

        $validated = $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:30',
            'rata_rata_harian' => 'required|numeric|min:0',
            'stok_minimum' => 'required|numeric|min:0',
            'kapasitas_maksimal' => 'required|numeric|min:0.1',
            'lead_time_hari' => 'required|integer|min:1',
            'harga_satuan' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $bahan->update($validated);

        return redirect()->route('admin.fuzzy-stok.index')->with('success', "Data bahan baku '{$bahan->nama_bahan}' berhasil diperbarui.");
    }

    /**
     * Hapus data bahan baku.
     */
    public function destroy($id)
    {
        $bahan = BahanBaku::findOrFail($id);
        $nama = $bahan->nama_bahan;
        $bahan->delete();

        return redirect()->route('admin.fuzzy-stok.index')->with('success', "Bahan baku '{$nama}' berhasil dihapus dari sistem.");
    }
}
