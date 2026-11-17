<?php

namespace App\Http\Controllers;

use App\Events\StatusPesananUpdated;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Display a listing of orders for admin dashboard.
     */
    public function index()
    {
        $pesanans = Pesanan::with('menu')
            ->latest()
            ->get()
            ->groupBy('kode_pesanan');

        return view('pesanan.index', compact('pesanans'));
    }

    /**
     * Update order progress status (Menunggu -> Diproses -> Selesai).
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

            $pesanan->status = $newStatus;
            event(new StatusPesananUpdated($pesanan));
        }

        return redirect()->back();
    }

    /**
     * Display orders status tracking page for customers.
     */
    public function statusPesanan()
    {
        $pesanans = Pesanan::with('menu')
            ->latest()
            ->get()
            ->groupBy('kode_pesanan');

        return view('pelanggan.status', compact('pesanans'));
    }

    /**
     * Mark an order as paid.
     */
    public function payment($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if (!empty($pesanan->kode_pesanan)) {
            Pesanan::where('kode_pesanan', $pesanan->kode_pesanan)
                ->update(['status_pembayaran' => 'Sudah Dibayar']);
        } else {
            $pesanan->status_pembayaran = 'Sudah Dibayar';
            $pesanan->save();
        }

        return back();
    }
}
