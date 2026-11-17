<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    /**
     * Display a listing of the menus.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $menus = Menu::when($search, function ($query, $search) {
            return $query->where('nama_kopi', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%");
        })->get();

        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create()
    {
        return view('menu.create');
    }

    /**
     * Store a newly created menu item in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kopi' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:255',
            'jenis_menu' => 'required|in:Coffee,Non Coffee,Makanan',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $gambar = time() . '_' . uniqid() . '.' . $file->extension();
            $file->move(public_path('images'), $gambar);
        }

        Menu::create([
            'nama_kopi' => $validated['nama_kopi'],
            'harga' => $validated['harga'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'kategori' => $validated['kategori'],
            'jenis_menu' => $validated['jenis_menu'],
            'gambar' => $gambar,
        ]);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    /**
     * Display the specified menu.
     */
    public function show(string $id)
    {
        $menu = Menu::findOrFail($id);
        return redirect()->route('menu.edit', $menu->id);
    }

    /**
     * Show the form for editing the specified menu.
     */
    public function edit(string $id)
    {
        $menu = Menu::findOrFail($id);

        return view('menu.edit', compact('menu'));
    }

    /**
     * Update the specified menu in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'nama_kopi' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:255',
            'jenis_menu' => 'required|in:Coffee,Non Coffee,Makanan',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Delete old image if exists and not default
            if ($menu->gambar && $menu->gambar !== 'logo.jpg') {
                $oldPath = public_path('images/' . $menu->gambar);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('gambar');
            $gambar = time() . '_' . uniqid() . '.' . $file->extension();
            $file->move(public_path('images'), $gambar);
            $menu->gambar = $gambar;
        }

        $menu->nama_kopi = $validated['nama_kopi'];
        $menu->harga = $validated['harga'];
        $menu->deskripsi = $validated['deskripsi'] ?? null;
        $menu->kategori = $validated['kategori'];
        $menu->jenis_menu = $validated['jenis_menu'];
        $menu->save();

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil diperbarui');
    }

    /**
     * Remove the specified menu from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->gambar && $menu->gambar !== 'logo.jpg') {
            $imagePath = public_path('images/' . $menu->gambar);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $menu->delete();

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil dihapus');
    }
}
