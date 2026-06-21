<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PembayaranController extends Controller
{
    private $apiBaseUrl = 'http://127.0.0.1:8000/api/v1/admin';

    public function index(Request $request)
    {
        $pembayarans = [];
        
        try {
            // Menarik data dengan parameter query paginasi jika ada
            $queryParams = $request->all();
            $response = Http::get("{$this->apiBaseUrl}/pembayaran", $queryParams);
            
            if ($response->successful()) {
                $result = $response->json();
                // Mengambil data dari struktur paginate() Laravel -> 'data' di dalam 'data'
                $pembayarans = $result['data']['data'] ?? ($result['data'] ?? []);
            }
        } catch (\Exception $e) {
            $pembayarans = [];
        }

        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    public function show($id)
    {
        try {
            $response = Http::get("{$this->apiBaseUrl}/pembayaran/{$id}");
            
            if ($response->successful()) {
                $result = $response->json();
                $data = $result['data'] ?? null;
                
                if ($data) {
                    return response()->json(['success' => true, 'data' => $data]);
                }
            }
            
            return response()->json(['success' => false, 'message' => 'Rincian pembayaran tidak ditemukan.'], 404);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan peladen.', 'error' => $e->getMessage()], 500);
        }
    }
}