<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private ApiService $api) {}

    public function index()
    {
        $res = $this->api->pengelolaDashboard();
        
        // Mengambil isi data statistik dari JSON API Anda
        $data = $res->successful() ? ($res->json('data') ?? []) : [];

        if (!$res->successful()) {
            session()->flash('error', 'Gagal terhubung ke server Citiisgo-API. Data statistik tidak dapat dimuat.');
        }

        // FIX TOTAL: Diarahkan langsung ke file dashboard.blade.php Anda (tanpa index)
        return view('pengelola.dashboard', compact('data'));
    }
}