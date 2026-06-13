<?php

namespace App\Http\Controllers\Pengelola;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index(Request $request)
    {
        $laporan = $this->api->pengelolaGetLaporan($request->only(['dari','sampai']))->json('data');
        return view('pengelola.laporan.index', compact('laporan'));
    }
}