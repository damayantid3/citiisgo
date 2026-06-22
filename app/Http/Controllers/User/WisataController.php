<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WisataController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Menampilkan daftar jelajah wisata untuk sisi wisatawan
     */
    public function index()
    {
        // Mengambil data kategori untuk filter jika dibutuhkan
        $res = $this->api->getKategori(); 
        
        // Mengambil data rute publik wisata dari backend API (Port 8000 secara absolut)
        $responseWisata = Http::baseUrl('http://127.0.0.1:8000/api/v1')
            ->acceptJson()
            ->get('/wisata');

        $daftarWisata = $responseWisata->successful() ? ($responseWisata->json('data') ?? []) : [];

        return view('user.wisata.index', compact('daftarWisata'));
    }

    /**
     * Menampilkan detail destinasi wisata tertentu pilihan wisatawan
     */
    public function show($id)
    {
        // Melempar id ke view agar dapat diakses oleh JavaScript fetchDetailWisata()
        return view('user.wisata.show', compact('id'));
    }
}