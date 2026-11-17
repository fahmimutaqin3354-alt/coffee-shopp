<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;

class PelangganController extends Controller
{
    /**
     * Display customer menu and cart preview.
     */
    public function index()
    {
        $menus = Menu::all();

        $carts = Cart::with('menu')
            ->where('session_id', session()->getId())
            ->get();

        $grandTotal = $carts->sum('total_harga');

        return view('pelanggan.index', compact('menus', 'carts', 'grandTotal'));
    }

    /**
     * Show single item order page.
     */
    public function pesan(int $id)
    {
        $menu = Menu::findOrFail($id);

        return view('pelanggan.pesan', compact('menu'));
    }
}
