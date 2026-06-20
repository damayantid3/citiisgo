<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiService;

class DashboardController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index()
    {
        $res = $this->api->adminDashboard();
        
        // Proteksi jika API gagal merespon atau token tidak valid
        if (!$res->successful()) {
            return view('admin.dashboard')->with('error', 'Gagal memuat data statistik dari server.');
        }

        $stats = $res->json('data') ?? [];
        return view('admin.dashboard', compact('stats'));
    }
}