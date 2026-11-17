<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Add an item to the shopping cart.
     */
    public function add(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $sessionId = session()->getId();

        $cart = Cart::where('menu_id', $menu->id)
            ->where('session_id', $sessionId)
            ->first();

        if ($cart) {
            $cart->jumlah += 1;
            $cart->total_harga = $cart->jumlah * $menu->harga;
            $cart->save();
        } else {
            Cart::create([
                'menu_id' => $menu->id,
                'jumlah' => 1,
                'total_harga' => $menu->harga,
                'session_id' => $sessionId,
            ]);
        }

        return back()->with('success', true);
    }

    /**
     * Display the cart index page.
     */
    public function index()
    {
        $carts = Cart::with('menu')
            ->where('session_id', session()->getId())
            ->get();

        return view('cart.index', compact('carts'));
    }

    /**
     * Cancel checkout and clear current session's cart.
     */
    public function cancel()
    {
        Cart::where('session_id', session()->getId())->delete();

        return redirect('/menu-pelanggan')
            ->with('success', 'Checkout dibatalkan');
    }

    /**
     * Process checkout for the current cart.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'nomor_meja' => 'required',
            'metode_pembayaran' => 'nullable|string|max:100',
        ]);

        $sessionId = session()->getId();
        $carts = Cart::with('menu')
            ->where('session_id', $sessionId)
            ->get();

        if ($carts->isEmpty()) {
            return redirect('/menu-pelanggan')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $metodePembayaran = $request->input('metode_pembayaran', 'Cash') ?: 'Cash';
        $kodePesanan = 'INV' . time();

        DB::transaction(function () use ($carts, $request, $kodePesanan, $metodePembayaran, $sessionId) {
            foreach ($carts as $cart) {
                Pesanan::create([
                    'nama_pembeli' => $request->nama_pembeli,
                    'nomor_meja' => $request->nomor_meja,
                    'menu_id' => $cart->menu_id,
                    'jumlah' => $cart->jumlah,
                    'kode_pesanan' => $kodePesanan,
                    'total_harga' => $cart->total_harga,
                    'metode_pembayaran' => $metodePembayaran,
                    'status_pembayaran' => 'Belum Dibayar',
                    'status' => 'Menunggu',
                ]);
            }

            Cart::where('session_id', $sessionId)->delete();
        });

        return redirect()->route('checkout.success');
    }

    /**
     * Increase item quantity in cart.
     */
    public function increase($id)
    {
        $cart = Cart::with('menu')
            ->where('id', $id)
            ->where('session_id', session()->getId())
            ->firstOrFail();

        $cart->jumlah += 1;
        $cart->total_harga = $cart->jumlah * ($cart->menu->harga ?? 0);
        $cart->save();

        return back();
    }

    /**
     * Decrease item quantity in cart or remove if 1.
     */
    public function decrease($id)
    {
        $cart = Cart::with('menu')
            ->where('id', $id)
            ->where('session_id', session()->getId())
            ->firstOrFail();

        if ($cart->jumlah > 1) {
            $cart->jumlah -= 1;
            $cart->total_harga = $cart->jumlah * ($cart->menu->harga ?? 0);
            $cart->save();
        } else {
            $cart->delete();
        }

        return back();
    }

    /**
     * Plus action (compatibility alias with modal).
     */
    public function plus($id)
    {
        return $this->increase($id);
    }

    /**
     * Min action (compatibility alias with modal).
     */
    public function min($id)
    {
        $cart = Cart::with('menu')
            ->where('id', $id)
            ->where('session_id', session()->getId())
            ->firstOrFail();

        if ($cart->jumlah > 1) {
            $cart->jumlah -= 1;
            $cart->total_harga = $cart->jumlah * ($cart->menu->harga ?? 0);
            $cart->save();
        }

        return back();
    }

    /**
     * Remove an item from the cart.
     */
    public function remove($id)
    {
        Cart::where('id', $id)
            ->where('session_id', session()->getId())
            ->delete();

        return back();
    }
}
