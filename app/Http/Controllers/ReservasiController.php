<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Show reservation form for customers.
     */
    public function index()
    {
        return view('reservasi.index');
    }

    /**
     * Store customer reservation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:30',
            'nomor_meja' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'jumlah_orang' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        Reservasi::create([
            'nama' => $validated['nama'],
            'telepon' => $validated['telepon'],
            'nomor_meja' => $validated['nomor_meja'],
            'tanggal' => $validated['tanggal'],
            'jam' => $validated['jam'],
            'jumlah_orang' => $validated['jumlah_orang'],
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('reservasi.status')
            ->with('success', 'Reservasi berhasil dikirim!');
    }

    /**
     * Show reservation status list for customers.
     */
    public function status()
    {
        $reservasis = Reservasi::latest()->get();

        return view('reservasi.status', compact('reservasis'));
    }

    /**
     * Show reservations list for admin.
     */
    public function admin()
    {
        $reservasis = Reservasi::latest()->get();

        return view('admin.reservasi', compact('reservasis'));
    }

    /**
     * Update reservation status (Menunggu, Disetujui, Dibatalkan).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Menunggu,Disetujui,Dibatalkan',
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->status = $request->status;
        $reservasi->save();

        return back()->with('success', 'Status reservasi berhasil diperbarui');
    }
}
