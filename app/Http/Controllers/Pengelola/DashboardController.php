<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $api;

    public function __construct(ApiService $api) 
    {
        $this->api = $api;
    }

    public function index()
    {
        $res = $this->api->pengelolaDashboard();
        
        // Memastikan respons sukses dan mengambil data statistik
        if ($res && $res->successful()) {
            $data = $res->json('data') ?? [];
        } else {
            $data = [];
            session()->flash('error', 'Gagal terhubung ke server pusat CitiisGo. Data statistik unit bisnis tidak dapat dimuat secara penuh.');
        }

        // Diarahkan langsung ke file resources/views/pengelola/dashboard.blade.php
        return view('pengelola.dashboard', compact('data'));
    }
}