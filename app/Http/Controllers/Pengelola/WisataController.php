<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    protected $api;

    public function __construct(ApiService $api) 
    {
        $this->api = $api;
    }

    public function index()
    {
        // Menarik data dari API server pusat
        $res = $this->api->pengelolaWisataDetail(); // Sesuaikan dengan method ApiService Anda
        $wisata = $res->successful() ? $res->json('data') : [];

        return view('pengelola.wisata.index', compact('wisata'));
    }

    public function update(Request $request)
    {
        $res = $this->api->pengelolaWisataUpdate($request->all());

        if (!$res->successful()) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal memperbarui data profil wahana wisata.']);
        }

        return redirect()->route('pengelola.wisata')->with('success', 'Profil wahana / objek wisata berhasil diperbarui.');
    }

    public function uploadGaleri(Request $request)
    {
        // Fungsi upload galeri ke server port 8000 via API
        $res = $this->api->pengelolaUploadGaleri($request->file('image'));

        if (!$res->successful()) {
            return back()->withErrors(['error' => 'Gagal mengunggah foto galeri.']);
        }

        return redirect()->route('pengelola.wisata')->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function deleteGaleri($id)
    {
        $res = $this->api->pengelolaDeleteGaleri($id);

        if (!$res->successful()) {
            return back()->withErrors(['error' => 'Gagal menghapus foto galeri.']);
        }

        return redirect()->route('pengelola.wisata')->with('success', 'Foto galeri berhasil dihapus.');
    }
} 