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
        $res     = $this->api->adminGetLaporan($request->only(['dari','sampai']));
        $laporan = $res->json('data');
        return view('admin.laporan.index', compact('laporan'));
    }
}