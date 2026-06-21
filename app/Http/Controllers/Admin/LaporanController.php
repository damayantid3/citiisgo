<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LaporanController extends Controller
{
    private $apiBaseUrl = 'http://127.0.0.1:8000/api/v1/admin';

    public function index(Request $request)
    {
        $summary = [
            'total_pendapatan' => 0,
            'total_transaksi' => 0,
            'periode_dari' => now()->startOfMonth()->toDateString(),
            'periode_sampai' => now()->endOfMonth()->toDateString(),
        ];
        $rincian = [];

        try {
            $response = Http::get("{$this->apiBaseUrl}/laporan", $request->all());
            if ($response->successful()) {
                $result = $response->json();
                $summary = $result['data'] ?? $summary;
                $rincian = $result['data']['rincian_laporan'] ?? [];
            }
        } catch (\Exception $e) {
            $summary['error'] = 'Gagal menyambungkan ke peladen pusat.';
        }

        return view('admin.laporan.index', compact('summary', 'rincian'));
    }
}