<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Menampilkan daftar jelajah wisata untuk sisi wisatawan
     */
    public function index()
    {
        // Mengambil data dari HTTP Client ApiService
        $res = $this->api->getKategori(); // Mengambil kategori jika dibutuhkan filter
        
        // Mengambil data rute publik wisata dari backend API
        $responseWisata = \Illuminate\Support\Facades\Http::baseUrl('http://127.0.0.1:8000/api/v1')
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
        $responseDetail = \Illuminate\Support\Facades\Http::baseUrl('http://127.0.0.1:8000/api/v1')
            ->acceptJson()
            ->get("/wisata/{$id}");

        $wisata = $responseDetail->successful() ? ($responseDetail->json('data') ?? $responseDetail->json()) : null;

        if (!$wisata) {
            abort(404, 'Destinasi wisata alam Citiis tidak ditemukan.');
        }

        return view('user.wisata.show', compact('wisata'));
    }
}