<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Cart;

class PelangganController extends Controller
{
    public function index()
    {
        $menus = Menu::all();

        $carts = Cart::with('menu')
            ->where('session_id', session()->getId())
            ->get();

        $grandTotal = $carts->sum('total_harga');

        return view(
            'pelanggan.index',
            compact(
                'menus',
                'carts',
                'grandTotal'
            )
        );
    }

    public function pesan(int $id)
    {
        $menu = Menu::findOrFail($id);

        return view(
            'pelanggan.pesan',
            compact('menu')
        );
    }
}
