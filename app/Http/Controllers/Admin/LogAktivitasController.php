<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        // Simulasi penarikan data log aktivitas dari API backend (port 8000)
        // Jika belum ada endpoint log di API, array di bawah bertindak sebagai fallback data steril
        $logs = [
            [
                'id' => 1,
                'keterangan' => 'Mitra Pengelola Kawasan Citiis memperbarui profil wisata.',
                'user' => ['nama' => 'Pengelola Citiis'],
                'created_at' => now()->subHours(2)
            ],
            [
                'id' => 2,
                'keterangan' => 'Admin Pusat memvalidasi pembayaran tiket masuk a.n Wisatawan.',
                'user' => ['nama' => 'Admin Induk'],
                'created_at' => now()->subHours(5)
            ]
        ];

        return view('admin.sistem.log', compact('logs'));
    }
}