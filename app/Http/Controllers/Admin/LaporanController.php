<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function __construct(private ApiService $api) {}

    public function index(Request $request)
    {
        $summary = [
            'total_pendapatan' => 0,
            'total_transaksi'  => 0,
            'periode_dari'     => now()->startOfMonth()->toDateString(),
            'periode_sampai'   => now()->endOfMonth()->toDateString(),
        ];
        $rincian = [];

        $res = $this->api->adminGetLaporan($request->only(['dari', 'sampai']));

        if ($res->successful()) {
            $result  = $res->json('data') ?? [];
            $summary = array_merge($summary, $result);
            $rincian = $result['rincian_laporan'] ?? [];
        } else {
            session()->flash('error', 'Gagal memuat laporan dari server API.');
        }

        return view('admin.laporan.index', compact('summary', 'rincian'));
    }
}