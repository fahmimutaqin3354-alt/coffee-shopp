<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $menus = Menu::all();
        $pesanans = Pesanan::all();
        $rulesCount = \App\Models\CoffeeRule::count();
        $questionsCount = \App\Models\CoffeeQuestion::count();
        $consultationsCount = \App\Models\CoffeeConsultation::count();
        $karyawanCount = \App\Models\User::where('role', 'karyawan')->count();

        return view('dashboard', compact('menus', 'pesanans', 'rulesCount', 'questionsCount', 'consultationsCount', 'karyawanCount'));
    }
}
