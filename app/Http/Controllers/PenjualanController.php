<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of sales for admin.
     */
    public function index()
    {
        $penjualans = Penjualan::latest()->get();
        $totalPendapatan = Penjualan::sum('total');

        return view('penjualan.index', compact('penjualans', 'totalPendapatan'));
    }

    /**
     * Show form for creating a sale record manually.
     */
    public function create(Request $request)
    {
        $menu = $request->query('menu');
        $harga = $request->query('harga');

        return view('penjualan.create', compact('menu', 'harga'));
    }

    /**
     * Store a newly created sale record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'nama_kopi' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        $total = $validated['jumlah'] * $validated['harga'];

        Penjualan::create([
            'nama_pembeli' => $validated['nama_pembeli'],
            'nama_kopi' => $validated['nama_kopi'],
            'jumlah' => $validated['jumlah'],
            'harga' => $validated['harga'],
            'total' => $total,
        ]);

        return redirect()->route('pesanan.sukses');
    }
}
