<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Pengelola;

// ── Auth ─────────────────────────────────────────────────────
Route::get('/',      [LoginController::class, 'showForm'])->name('login');
Route::get('/login', [LoginController::class, 'showForm']);
Route::post('/login',[LoginController::class, 'login'])->name('login.post');
Route::post('/logout',[LoginController::class,'logout'])->name('logout');

// ── Admin ─────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('auth.web:admin')->group(function () {
    Route::get('dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('users',                    [Admin\UserController::class, 'index'])->name('users');
    Route::post('users',                   [Admin\UserController::class, 'store'])->name('users.store');
    Route::put('users/{id}',               [Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}',            [Admin\UserController::class, 'destroy'])->name('users.destroy');
    Route::put('users/{id}/role',          [Admin\UserController::class, 'changeRole'])->name('users.role');

    // Wisata
    Route::get('wisata',                   [Admin\WisataController::class, 'index'])->name('wisata');
    Route::post('wisata',                  [Admin\WisataController::class, 'store'])->name('wisata.store');
    Route::put('wisata/{id}',              [Admin\WisataController::class, 'update'])->name('wisata.update');
    Route::delete('wisata/{id}',           [Admin\WisataController::class, 'destroy'])->name('wisata.destroy');

    // Kategori
    Route::get('kategori',                 [Admin\KategoriController::class, 'index'])->name('kategori');
    Route::post('kategori',                [Admin\KategoriController::class, 'store'])->name('kategori.store');
    Route::put('kategori/{id}',            [Admin\KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('kategori/{id}',         [Admin\KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Pembayaran
    Route::get('pembayaran',               [Admin\PembayaranController::class, 'index'])->name('pembayaran');
    Route::get('pembayaran/{id}',          [Admin\PembayaranController::class, 'show'])->name('pembayaran.show');

    // Laporan
    Route::get('laporan',                  [Admin\LaporanController::class, 'index'])->name('laporan');
});

// ── Pengelola ─────────────────────────────────────────────────
Route::prefix('pengelola')->name('pengelola.')->middleware('auth.web:pengelola')->group(function () {
    Route::get('dashboard', [Pengelola\DashboardController::class, 'index'])->name('dashboard');

    // Wisata
    Route::get('wisata',                   [Pengelola\WisataController::class, 'index'])->name('wisata');
    Route::put('wisata',                   [Pengelola\WisataController::class, 'update'])->name('wisata.update');
    Route::post('wisata/galeri',           [Pengelola\WisataController::class, 'uploadGaleri'])->name('wisata.galeri.upload');
    Route::delete('wisata/galeri/{id}',    [Pengelola\WisataController::class, 'deleteGaleri'])->name('wisata.galeri.delete');

    // Paket Camping
    Route::get('paket-camping',            [Pengelola\PaketCampingController::class, 'index'])->name('camping');
    Route::post('paket-camping',           [Pengelola\PaketCampingController::class, 'store'])->name('camping.store');
    Route::put('paket-camping/{id}',       [Pengelola\PaketCampingController::class, 'update'])->name('camping.update');
    Route::delete('paket-camping/{id}',    [Pengelola\PaketCampingController::class, 'destroy'])->name('camping.destroy');

    // Penginapan
    Route::get('penginapan',               [Pengelola\PenginapanController::class, 'index'])->name('penginapan');
    Route::post('penginapan',              [Pengelola\PenginapanController::class, 'store'])->name('penginapan.store');
    Route::put('penginapan/{id}',          [Pengelola\PenginapanController::class, 'update'])->name('penginapan.update');

    // Peralatan
    Route::get('peralatan',                [Pengelola\PeralatanController::class, 'index'])->name('peralatan');
    Route::post('peralatan',               [Pengelola\PeralatanController::class, 'store'])->name('peralatan.store');
    Route::put('peralatan/{id}',           [Pengelola\PeralatanController::class, 'update'])->name('peralatan.update');
    Route::delete('peralatan/{id}',        [Pengelola\PeralatanController::class, 'destroy'])->name('peralatan.destroy');

    // Reservasi & Booking
    Route::get('reservasi',                [Pengelola\ReservasiController::class, 'index'])->name('reservasi');
    Route::put('reservasi/{id}',           [Pengelola\ReservasiController::class, 'update'])->name('reservasi.update');

    // Laporan
    Route::get('laporan',                  [Pengelola\LaporanController::class, 'index'])->name('laporan');
});