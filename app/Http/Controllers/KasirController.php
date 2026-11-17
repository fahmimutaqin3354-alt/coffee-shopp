<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Penjualan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    /**
     * Display the main POS Cashier interface.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $kategori = $request->query('kategori');
        $jenisMenu = $request->query('jenis_menu');

        // Menyesuaikan menu dari admin: hanya menampilkan menu yang aktif
        $menus = Menu::where('is_active', true)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama_kopi', 'like', "%{$search}%")
                      ->orWhere('kategori', 'like', "%{$search}%");
                });
            })
            ->when($kategori && $kategori !== 'Semua', function ($query) use ($kategori) {
                return $query->where('kategori', $kategori);
            })
            ->when($jenisMenu && $jenisMenu !== 'Semua', function ($query) use ($jenisMenu) {
                return $query->where('jenis_menu', $jenisMenu);
            })
            ->orderBy('jenis_menu', 'asc')
            ->orderBy('nama_kopi', 'asc')
            ->get();

        // Kategori list for filters
        $kategoris = Menu::where('is_active', true)
            ->whereNotNull('kategori')
            ->pluck('kategori')
            ->unique()
            ->values();

        // Ringkasan transaksi kasir hari ini
        $today = now()->toDateString();
        $totalTransaksiHariIni = Pesanan::whereDate('created_at', $today)
            ->distinct('kode_pesanan')
            ->count('kode_pesanan');

        $totalPendapatanHariIni = Pesanan::whereDate('created_at', $today)
            ->where('status_pembayaran', 'Sudah Dibayar')
            ->sum('total_harga');

        $pesananAktifHariIni = Pesanan::whereDate('created_at', $today)
            ->whereIn('status', ['Menunggu', 'Diproses'])
            ->distinct('kode_pesanan')
            ->count('kode_pesanan');

        // 5 Transaksi terakhir untuk akses cepat cetak struk
        $recentOrders = Pesanan::with('menu')
            ->latest()
            ->get()
            ->groupBy('kode_pesanan')
            ->take(6);

        return view('kasir.index', compact(
            'menus',
            'kategoris',
            'search',
            'kategori',
            'jenisMenu',
            'totalTransaksiHariIni',
            'totalPendapatanHariIni',
            'pesananAktifHariIni',
            'recentOrders'
        ));
    }

    /**
     * Process POS transaction created by the cashier.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pembeli' => 'nullable|string|max:255',
            'nomor_meja' => 'nullable|string|max:50',
            'metode_pembayaran' => 'required|string|in:Cash,QRIS,Debit,Transfer',
            'status_pembayaran' => 'required|string|in:Sudah Dibayar,Belum Dibayar',
            'uang_diterima' => 'nullable|numeric|min:0',
            'kembalian' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ], [
            'items.required' => 'Keranjang pesanan masih kosong. Pilih minimal 1 menu.',
            'items.min' => 'Pilih minimal 1 menu untuk diproses.',
        ]);

        $namaPembeli = trim($validated['nama_pembeli'] ?? '') ?: 'Pelanggan Walk-in';
        $nomorMeja = trim($validated['nomor_meja'] ?? '') ?: 'Take Away';
        $metodePembayaran = $validated['metode_pembayaran'];
        $statusPembayaran = $validated['status_pembayaran'];
        $uangDiterima = $validated['uang_diterima'] ?? 0;
        $kembalian = $validated['kembalian'] ?? 0;
        $kasirNama = Auth::check() ? Auth::user()->name : 'Kasir';

        $kodePesanan = 'POS' . date('ymd') . strtoupper(substr(uniqid(), -4));

        DB::transaction(function () use (
            $validated,
            $namaPembeli,
            $nomorMeja,
            $metodePembayaran,
            $statusPembayaran,
            $uangDiterima,
            $kembalian,
            $kasirNama,
            $kodePesanan
        ) {
            foreach ($validated['items'] as $item) {
                $menu = Menu::findOrFail($item['menu_id']);
                $qty = (int)$item['jumlah'];
                $subtotal = $qty * $menu->harga;

                Pesanan::create([
                    'nama_pembeli' => $namaPembeli,
                    'nomor_meja' => $nomorMeja,
                    'menu_id' => $menu->id,
                    'jumlah' => $qty,
                    'total_harga' => $subtotal,
                    'metode_pembayaran' => $metodePembayaran,
                    'status_pembayaran' => $statusPembayaran,
                    'uang_diterima' => $uangDiterima,
                    'kembalian' => $kembalian,
                    'kasir_nama' => $kasirNama,
                    'status' => $statusPembayaran === 'Sudah Dibayar' ? 'Diproses' : 'Menunggu',
                    'kode_pesanan' => $kodePesanan,
                ]);

                // Jika sudah dibayar, catat otomatis ke tabel penjualans agar sinkron dengan laporan penjualan
                if ($statusPembayaran === 'Sudah Dibayar') {
                    Penjualan::create([
                        'nama_pembeli' => $namaPembeli,
                        'nama_kopi' => $menu->nama_kopi,
                        'jumlah' => $qty,
                        'harga' => $menu->harga,
                        'total' => $subtotal,
                    ]);
                }
            }
        });

        return redirect()->route('kasir.index')
            ->with('success_pesanan', "Transaksi {$kodePesanan} berhasil disimpan!")
            ->with('last_kode_pesanan', $kodePesanan);
    }

    /**
     * Display order queue and management list for cashier.
     */
    public function pesanan(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = Pesanan::with('menu')->latest();

        if ($status && $status !== 'Semua') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_pesanan', 'like', "%{$search}%")
                  ->orWhere('nama_pembeli', 'like', "%{$search}%")
                  ->orWhere('nomor_meja', 'like', "%{$search}%");
            });
        }

        $pesanans = $query->get()->groupBy('kode_pesanan');

        return view('kasir.pesanan', compact('pesanans', 'status', 'search'));
    }

    /**
     * Update order status from Cashier panel.
     */
    public function updateStatus($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $newStatus = match ($pesanan->status) {
            'Menunggu' => 'Diproses',
            'Diproses' => 'Selesai',
            default => $pesanan->status,
        };

        if ($newStatus !== $pesanan->status) {
            if (!empty($pesanan->kode_pesanan)) {
                Pesanan::where('kode_pesanan', $pesanan->kode_pesanan)
                    ->update(['status' => $newStatus]);
            } else {
                $pesanan->status = $newStatus;
                $pesanan->save();
            }
        }

        return redirect()->back()->with('success', "Status pesanan berhasil diubah menjadi {$newStatus}");
    }

    /**
     * Confirm payment from Cashier panel.
     */
    public function payment($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        DB::transaction(function () use ($pesanan) {
            $items = !empty($pesanan->kode_pesanan)
                ? Pesanan::with('menu')->where('kode_pesanan', $pesanan->kode_pesanan)->get()
                : collect([$pesanan]);

            foreach ($items as $item) {
                $item->status_pembayaran = 'Sudah Dibayar';
                $item->save();

                // Catat ke penjualan jika belum tercatat
                if ($item->menu) {
                    Penjualan::create([
                        'nama_pembeli' => $item->nama_pembeli,
                        'nama_kopi' => $item->menu->nama_kopi,
                        'jumlah' => $item->jumlah,
                        'harga' => $item->menu->harga,
                        'total' => $item->total_harga,
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', "Pembayaran pesanan {$pesanan->kode_pesanan} berhasil dikonfirmasi lunas!");
    }

    /**
     * Display printable receipt (Thermal POS Receipt) for a specific order.
     */
    public function struk($kode_pesanan)
    {
        $pesanans = Pesanan::with('menu')
            ->where('kode_pesanan', $kode_pesanan)
            ->get();

        if ($pesanans->isEmpty()) {
            abort(404, 'Data pesanan untuk struk ini tidak ditemukan.');
        }

        $first = $pesanans->first();
        $grandTotal = $pesanans->sum('total_harga');

        return view('kasir.struk', compact('pesanans', 'first', 'grandTotal'));
    }

    /**
     * Display daily cashier sales report.
     */
    public function laporan(Request $request)
    {
        $tanggal = $request->query('tanggal', now()->toDateString());

        $pesanans = Pesanan::with('menu')
            ->whereDate('created_at', $tanggal)
            ->latest()
            ->get();

        $groupedOrders = $pesanans->groupBy('kode_pesanan');

        $totalOmzet = $pesanans->where('status_pembayaran', 'Sudah Dibayar')->sum('total_harga');
        $totalTransaksi = $groupedOrders->count();
        $totalItemTerjual = $pesanans->sum('jumlah');

        // Omzet per metode pembayaran
        $metodeSummary = $pesanans->where('status_pembayaran', 'Sudah Dibayar')
            ->groupBy('metode_pembayaran')
            ->map(function ($rows) {
                return [
                    'count' => $rows->count(),
                    'total' => $rows->sum('total_harga'),
                ];
            });

        return view('kasir.laporan', compact(
            'groupedOrders',
            'tanggal',
            'totalOmzet',
            'totalTransaksi',
            'totalItemTerjual',
            'metodeSummary'
        ));
    }

    /**
     * Display the Mood Expert System page (Certainty Factor).
     * Integrated directly into kasir — no separate server needed.
     */
    public function mood()
    {
        $menus = Menu::where('is_active', true)
            ->orderBy('nama_kopi')
            ->get(['id', 'nama_kopi', 'kategori', 'harga', 'gambar']);

        return view('kasir.mood', compact('menus'));
    }
}
