<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Pengelola;
use App\Http\Controllers\User\WisataController as UserWisataController;

// ── Landing Page ────────────────────
Route::get('/', function () {
    return view('index');
});

// ── Autentikasi ─────────────────────
Route::get('/login',   [LoginController::class, 'showForm'])->name('login');
Route::post('/login',  [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register',  [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');

Route::get('/destinasi', function() { return view('publik.destinasi'); })->name('destinasi');
Route::get('/camping',   function() { return view('publik.camping'); })->name('camping');
Route::get('/penginapan', function() { return view('publik.penginapan'); })->name('penginapan');

// ─── Endpoint API Asinkron Lokal Web ──
Route::prefix('api/v1')->name('api.v1.')->group(function () {
    Route::apiResource('wisata', Admin\WisataController::class);
    
    Route::get('kategori', function() {
        return response()->json([
            'success' => true,
            'data'    => \App\Models\Kategori::all()
        ]);
    });
});

// ─── User / Wisatawan ──
Route::prefix('user')->name('user.')->middleware('auth.web:user')->group(function () {
    Route::get('dashboard', function () {
        return redirect()->route('user.wisata.index');
    })->name('dashboard');

    Route::get('wisata', function() {
        return view('user.index');
    })->name('wisata.index');
    
    Route::get('wisata/{id}', [UserWisataController::class, 'show'])->name('wisata.show');
    Route::get('booking/tiket',     function() { return view('user.booking.tiket'); })->name('booking.tiket');
    Route::get('booking/camping',  function() { return view('user.booking.camping'); })->name('booking.camping');
    Route::get('booking/history',  function() { return view('user.booking.history'); })->name('booking.history');
    Route::get('booking/invoice/{id}', function() { return view('user.booking.invoice'); })->name('booking.invoice');
    
    Route::get('notifikasi', [App\Http\Controllers\User\NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::put('notifikasi/{id}/read', [App\Http\Controllers\User\NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('notifikasi/read-all', [App\Http\Controllers\User\NotifikasiController::class, 'markAllRead'])->name('notifikasi.read-all');
});

// ─── Admin Pusat (Verifikator Sentral & Auditor Finansial) ──
Route::prefix('admin')->name('admin.')->middleware('auth.web:admin')->group(function () {
    Route::get('dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('users',                  [Admin\UserController::class, 'index'])->name('users');
    Route::post('users',                 [Admin\UserController::class, 'store'])->name('users.store');
    Route::put('users/{user}',           [Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}',        [Admin\UserController::class, 'destroy'])->name('users.destroy');
    Route::put('users/{user}/role',      [Admin\UserController::class, 'changeRole'])->name('users.role');

    Route::get('wisata',                 [Admin\WisataController::class, 'index'])->name('wisata');
    Route::post('wisata',                [Admin\WisataController::class, 'store'])->name('wisata.store');
    Route::put('wisata/{wisata}',        [Admin\WisataController::class, 'update'])->name('wisata.update');
    Route::delete('wisata/{wisata}',     [Admin\WisataController::class, 'destroy'])->name('wisata.destroy'); 

    Route::get('kategori',               [Admin\KategoriController::class, 'index'])->name('kategori');
    Route::post('kategori',              [Admin\KategoriController::class, 'store'])->name('kategori.store');
    Route::put('kategori/{kategori}',    [Admin\KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('kategori/{kategori}', [Admin\KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::get('pembayaran',             [Admin\PembayaranController::class, 'index'])->name('pembayaran');
    Route::get('pembayaran/{id}',        [Admin\PembayaranController::class, 'show'])->name('pembayaran.show');
    
    Route::get('laporan',                [Admin\LaporanController::class, 'index'])->name('laporan');

    Route::get('sistem/pengaturan',      [Admin\PengaturanController::class, 'index'])->name('sistem.pengaturan');
    Route::put('sistem/pengaturan',      [Admin\PengaturanController::class, 'update'])->name('sistem.pengaturan.update');
    Route::get('sistem/log',             [Admin\LogAktivitasController::class, 'index'])->name('sistem.log');
});

// ─── ⚡ Pengelola Wisata (Eksekutor Aset Lapangan & Validator Tamu) ──
Route::prefix('pengelola')->name('pengelola.')->middleware('auth.web:pengelola')->group(function () {
    Route::get('dashboard', [Pengelola\DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('wisata',          [Pengelola\WisataController::class, 'index'])->name('wisata');
    Route::put('wisata',          [Pengelola\WisataController::class, 'update'])->name('wisata.update'); // ⚡ Diset ke PUT
    Route::post('wisata/galeri',  [Pengelola\WisataController::class, 'uploadGaleri'])->name('wisata.galeri.upload');
    Route::delete('wisata/galeri/{galeri}', [Pengelola\WisataController::class, 'deleteGaleri'])->name('wisata.galeri.delete');
    // Modul Unit Bisnis: Camping
    Route::get('paket-camping',             [Pengelola\PaketCampingController::class, 'index'])->name('camping');
    Route::post('paket-camping',            [Pengelola\PaketCampingController::class, 'store'])->name('camping.store');
    Route::put('paket-camping/{camping}',   [Pengelola\PaketCampingController::class, 'update'])->name('camping.update');
    Route::delete('paket-camping/{camping}', [Pengelola\PaketCampingController::class, 'destroy'])->name('camping.destroy');

    // Modul Unit Bisnis: Penginapan
    Route::get('penginapan',                [Pengelola\PenginapanController::class, 'index'])->name('penginapan');
    Route::post('penginapan',               [Pengelola\PenginapanController::class, 'store'])->name('penginapan.store');
    Route::put('penginapan/{penginapan}',   [Pengelola\PenginapanController::class, 'update'])->name('penginapan.update');

    // Modul Unit Bisnis: Peralatan (Fix Namespace Pengelola)
    Route::get('peralatan',                 [Pengelola\PeralatanController::class, 'index'])->name('peralatan');
    Route::post('peralatan',                [Pengelola\PeralatanController::class, 'store'])->name('peralatan.store');
    Route::put('peralatan/{peralatan}',     [Pengelola\PeralatanController::class, 'update'])->name('peralatan.update');
    Route::delete('peralatan/{peralatan}',  [Pengelola\PeralatanController::class, 'destroy'])->name('peralatan.destroy');

    // Modul Operasional Lapangan
    Route::get('reservasi',                 [Pengelola\ReservasiController::class, 'index'])->name('reservasi');
    Route::put('reservasi/{reservasi}',     [Pengelola\ReservasiController::class, 'update'])->name('reservasi.update');

    Route::get('laporan',                   [Pengelola\LaporanController::class, 'index'])->name('laporan');

    // Pastikan rute Anda memiliki nama ('pengelola.paket-camping.store') di ujung barisnya
Route::post('/pengelola/paket-camping', [App\Http\Controllers\Pengelola\PaketCampingController::class, 'store'])
    ->name('pengelola.paket-camping.store');
});