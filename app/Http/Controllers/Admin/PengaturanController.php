<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        // Simulasi penarikan data pengaturan dari API pusat (port 8000)
        // Anda dapat menyesuaikan endpoint sesuai kebutuhan backend Anda
        $pengaturan = [
            'nama_aplikasi' => 'CitiisGo',
            'kontak_layanan' => '081234567890',
            'alamat_kantor' => 'Padakembang, Tasikmalaya, Jawa Barat',
            'email_pusat' => 'admin@citiisgo.com'
        ];

        return view('admin.sistem.pengaturan', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_aplikasi' => 'required|string|max:255',
            'kontak_layanan' => 'required|string|max:20',
            'alamat_kantor' => 'required|string|max:255',
            'email_pusat' => 'required|email|max:255',
        ]);

        // Logika pengiriman data pembaruan ke API backend (port 8000) dapat disematkan di sini

        return redirect()->route('admin.sistem.pengaturan')->with('success', 'Pengaturan utama platform berhasil diperbarui.');
    }
}