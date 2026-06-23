<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function __construct(private ApiService $api) {}

    public function index(Request $request)
    {
        $res = $this->api->getPembayaran($request->only(['status', 'ref_type', 'dari', 'sampai', 'page']));

        $pembayarans = [];
        if ($res->successful()) {
            $result      = $res->json('data') ?? [];
            $pembayarans = $result['data'] ?? $result;
        } else {
            session()->flash('error', 'Gagal memuat data pembayaran dari server API.');
        }

        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    public function show($id)
    {
        $res = $this->api->getPembayaranDetail($id);

        if ($res->successful()) {
            return response()->json(['success' => true, 'data' => $res->json('data')]);
        }

        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 404);
    }
}