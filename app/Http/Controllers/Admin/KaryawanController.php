<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class KaryawanController extends Controller
{
    /**
     * Display a listing of employees / staff.
     */
    public function index()
    {
        $karyawans = User::orderBy('role', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('admin.karyawan.index', compact('karyawans'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('admin.karyawan.create');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'string', 'in:karyawan,admin'],
        ], [
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
        ]);

        User::create([
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Akun ' . ($validated['role'] === 'karyawan' ? 'Karyawan (Kasir)' : 'Administrator') . ' berhasil ditambahkan.');
    }

    /**
     * Show the form for editing an employee.
     */
    public function edit(int $id)
    {
        $karyawan = User::findOrFail($id);

        return view('admin.karyawan.edit', compact('karyawan'));
    }

    /**
     * Update employee in storage.
     */
    public function update(Request $request, int $id)
    {
        $karyawan = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $karyawan->id],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'string', 'in:karyawan,admin,pelanggan'],
        ]);

        $karyawan->name = trim($validated['name']);
        $karyawan->email = strtolower(trim($validated['email']));
        $karyawan->role = $validated['role'];

        if (!empty($validated['password'])) {
            $karyawan->password = Hash::make($validated['password']);
        }

        $karyawan->save();

        return redirect()->route('admin.karyawan.index')
            ->with('success', "Akun {$karyawan->name} berhasil diperbarui.");
    }

    /**
     * Remove employee from storage.
     */
    public function destroy(int $id)
    {
        $karyawan = User::findOrFail($id);

        // Prevent self deletion
        if (auth()->id() === $karyawan->id) {
            return redirect()->route('admin.karyawan.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $name = $karyawan->name;
        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')
            ->with('success', "Akun karyawan {$name} berhasil dihapus.");
    }
}
