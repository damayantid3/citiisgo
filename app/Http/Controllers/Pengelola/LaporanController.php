<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Menampilkan riwayat laporan kunjungan periodik pengelola
     */
    public function index()
    {
        $res = $this->api->pengelolaGetLaporan();
        $laporan = $res->successful() ? $res->json('data') : [];

        return view('pengelola.laporan.index', compact('laporan'));
    }
}