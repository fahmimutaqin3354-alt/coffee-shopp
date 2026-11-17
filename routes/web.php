<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\CoffeeRecommendationController;
use App\Http\Controllers\Admin\CoffeeQuestionController;
use App\Http\Controllers\Admin\CoffeeRuleController;
use App\Http\Controllers\Admin\CoffeeConsultationController;
use App\Http\Controllers\Admin\CbrController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\Admin\KaryawanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PELANGGAN (PUBLIC) ROUTES
|--------------------------------------------------------------------------
*/

// Landing & Menu
Route::view('/', 'landing')->name('landing');
Route::get('/menu-pelanggan', [PelangganController::class, 'index'])->name('pelanggan.menu');
Route::get('/pesan/{id}', [PelangganController::class, 'pesan'])->name('pelanggan.pesan');
Route::get('/pesanan-berhasil', function () {
    return view('pelanggan.sukses');
})->name('pesanan.sukses');

// Cart & Checkout
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/cancel', [CartController::class, 'cancel'])->name('cart.cancel');
Route::get('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
Route::get('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::get('/cart/plus/{id}', [CartController::class, 'plus'])->name('cart.plus');
Route::get('/cart/min/{id}', [CartController::class, 'min'])->name('cart.min');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::get('/checkout-success', function () {
    return view('checkout.success');
})->name('checkout.success');

// Status Pesanan (Customer view)
Route::get('/status-pesanan', [PesananController::class, 'statusPesanan'])->name('status.pesanan');

// Reservasi (Customer view & submission)
Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
Route::post('/reservasi/store', [ReservasiController::class, 'store'])->name('reservasi.store');
Route::get('/status-reservasi', [ReservasiController::class, 'status'])->name('reservasi.status');

// Direct order store from pesan page
Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');

// Sistem Pakar Rekomendasi Kopi (Pelanggan)
Route::get('/rekomendasi', [CoffeeRecommendationController::class, 'index'])->name('rekomendasi.index');
Route::get('/rekomendasi/konsultasi', [CoffeeRecommendationController::class, 'consult'])->name('rekomendasi.konsultasi');
Route::post('/rekomendasi/proses', [CoffeeRecommendationController::class, 'process'])->name('rekomendasi.proses');
Route::get('/rekomendasi/hasil', [CoffeeRecommendationController::class, 'result'])->name('rekomendasi.hasil');

/*
|--------------------------------------------------------------------------
| ADMIN (AUTHENTICATED) ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Menu Management
    Route::resource('menu', MenuController::class);

    // Penjualan Management (admin report & create)
    Route::resource('penjualan', PenjualanController::class)->except(['store']);

    // Pesanan Management (Admin view, update status, confirm payment)
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/status/{id}', [PesananController::class, 'updateStatus'])->name('pesanan.status');
    Route::put('/payment/{id}', [PesananController::class, 'payment'])->name('pesanan.payment');

    // Reservasi Management (Admin view & status update)
    Route::get('/admin/reservasi', [ReservasiController::class, 'admin'])->name('admin.reservasi');
    Route::post('/reservasi/status/{id}', [ReservasiController::class, 'updateStatus'])->name('admin.reservasi.status');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Sistem Pakar - Knowledge Base Management (Protected with Admin authorization)
    Route::middleware(['admin'])->prefix('admin/sistem-pakar')->group(function () {
        // Pertanyaan
        Route::get('/pertanyaan', [CoffeeQuestionController::class, 'index'])->name('admin.pertanyaan.index');
        Route::get('/pertanyaan/create', [CoffeeQuestionController::class, 'create'])->name('admin.pertanyaan.create');
        Route::post('/pertanyaan', [CoffeeQuestionController::class, 'store'])->name('admin.pertanyaan.store');
        Route::get('/pertanyaan/{id}/edit', [CoffeeQuestionController::class, 'edit'])->name('admin.pertanyaan.edit');
        Route::put('/pertanyaan/{id}', [CoffeeQuestionController::class, 'update'])->name('admin.pertanyaan.update');
        Route::delete('/pertanyaan/{id}', [CoffeeQuestionController::class, 'destroy'])->name('admin.pertanyaan.destroy');
        Route::post('/pertanyaan/{id}/toggle', [CoffeeQuestionController::class, 'toggle'])->name('admin.pertanyaan.toggle');

        // Aturan / Rules
        Route::get('/aturan', [CoffeeRuleController::class, 'index'])->name('admin.aturan.index');
        Route::get('/aturan/create', [CoffeeRuleController::class, 'create'])->name('admin.aturan.create');
        Route::post('/aturan', [CoffeeRuleController::class, 'store'])->name('admin.aturan.store');
        Route::get('/aturan/{id}/edit', [CoffeeRuleController::class, 'edit'])->name('admin.aturan.edit');
        Route::put('/aturan/{id}', [CoffeeRuleController::class, 'update'])->name('admin.aturan.update');
        Route::delete('/aturan/{id}', [CoffeeRuleController::class, 'destroy'])->name('admin.aturan.destroy');
        Route::post('/aturan/{id}/toggle', [CoffeeRuleController::class, 'toggle'])->name('admin.aturan.toggle');

        // Riwayat Konsultasi
        Route::get('/riwayat', [CoffeeConsultationController::class, 'index'])->name('admin.riwayat.index');
        Route::get('/riwayat/{id}', [CoffeeConsultationController::class, 'show'])->name('admin.riwayat.show');
        Route::delete('/riwayat/{id}', [CoffeeConsultationController::class, 'destroy'])->name('admin.riwayat.destroy');
    });

    // Sistem Pakar Penanganan Masalah — Case Based Reasoning (CBR) (Admin Only)
    Route::middleware(['admin'])->prefix('admin/cbr')->group(function () {
        Route::get('/', [CbrController::class, 'index'])->name('admin.cbr.index');
        Route::get('/konsultasi', [CbrController::class, 'konsultasi'])->name('admin.cbr.konsultasi');
        Route::post('/konsultasi', [CbrController::class, 'prosesKonsultasi'])->name('admin.cbr.proses');
        Route::post('/retain', [CbrController::class, 'retainFromKonsultasi'])->name('admin.cbr.retain');
        Route::get('/create', [CbrController::class, 'create'])->name('admin.cbr.create');
        Route::post('/', [CbrController::class, 'store'])->name('admin.cbr.store');
        Route::get('/{id}/edit', [CbrController::class, 'edit'])->name('admin.cbr.edit');
        Route::put('/{id}', [CbrController::class, 'update'])->name('admin.cbr.update');
        Route::delete('/{id}', [CbrController::class, 'destroy'])->name('admin.cbr.destroy');
        Route::post('/{id}/toggle', [CbrController::class, 'toggle'])->name('admin.cbr.toggle');
    });

    // Kasir POS Management (Karyawan & Admin)
    Route::middleware(['kasir'])->prefix('kasir')->group(function () {
        Route::get('/', [KasirController::class, 'index'])->name('kasir.index');
        Route::post('/store', [KasirController::class, 'store'])->name('kasir.store');
        Route::get('/pesanan', [KasirController::class, 'pesanan'])->name('kasir.pesanan');
        Route::get('/pesanan/status/{id}', [KasirController::class, 'updateStatus'])->name('kasir.pesanan.status');
        Route::put('/payment/{id}', [KasirController::class, 'payment'])->name('kasir.payment');
        Route::get('/struk/{kode_pesanan}', [KasirController::class, 'struk'])->name('kasir.struk');
        Route::get('/laporan', [KasirController::class, 'laporan'])->name('kasir.laporan');
        Route::get('/mood', [KasirController::class, 'mood'])->name('kasir.mood');
    });

    // Kelola Karyawan (Admin only)
    Route::middleware(['admin'])->prefix('admin/karyawan')->group(function () {
        Route::get('/', [KaryawanController::class, 'index'])->name('admin.karyawan.index');
        Route::get('/create', [KaryawanController::class, 'create'])->name('admin.karyawan.create');
        Route::post('/', [KaryawanController::class, 'store'])->name('admin.karyawan.store');
        Route::get('/{id}/edit', [KaryawanController::class, 'edit'])->name('admin.karyawan.edit');
        Route::put('/{id}', [KaryawanController::class, 'update'])->name('admin.karyawan.update');
        Route::delete('/{id}', [KaryawanController::class, 'destroy'])->name('admin.karyawan.destroy');
    });
});

require __DIR__.'/auth.php';
