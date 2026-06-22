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
        $res = $this->api->pengelolaWisataDetail();
        $wisata = $res->successful() ? $res->json('data') : [];

        return view('pengelola.wisata.index', compact('wisata'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'harga_tiket' => 'required|numeric|min:0',
            'kapasitas'   => 'required|integer|min:1',
            'deskripsi'   => 'required|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['nama', 'harga_tiket', 'kapasitas', 'deskripsi']);
        $file = $request->file('foto');

        // Mengirimkan data teks dan file ke method multipart API
        $res = $this->api->updateWisataMultipart($data, $file);

        if (!$res->successful()) {
            return back()->withInput()->withErrors(['error' => $res->json('message') ?? 'Gagal memperbarui data profil wahana wisata.']);
        }

        return redirect()->route('pengelola.wisata')->with('success', 'Profil wahana / objek wisata berhasil diperbarui.');
    }

    public function uploadGaleri(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // Sesuai dengan form terisolasi blade, tangkap input 'image'
        $res = $this->api->pengelolaUploadGaleri($request->file('image'));

        if (!$res->successful()) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal mengunggah foto galeri.']);
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