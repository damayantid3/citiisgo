<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index()
    {
        $res = $this->api->pengelolaGetWisata();
        
        // Proteksi jika server API down, kunci dengan array kosong agar view tidak crash
        $wisata = $res->successful() ? ($res->json('data') ?? []) : [];

        if (!$res->successful()) {
            session()->flash('error', 'Gagal memuat data informasi wisata dari server.');
        }

        return view('pengelola.wisata.index', compact('wisata'));
    }
 
    public function update(Request $request)
    {
        // 1. Validasi Input Informasi Wisata di Sisi Web
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi'    => 'required|string',
            // Tambahkan field lain yang diperlukan oleh form wisata Anda
        ]);

        // 2. Tembak ke API dengan data aman
        $res = $this->api->pengelolaUpdateWisata($validated);
 
        if (!$res->successful()) {
            return back()
                ->withInput()
                ->withErrors(['error' => $res->json('message') ?? 'Gagal memperbarui data wisata.']);
        }

        return redirect()->route('pengelola.wisata')->with('success', 'Data wisata berhasil diperbarui.');
    }
 
    public function uploadGaleri(Request $request)
    {
        // 1. Validasi File Gambar di Sisi Web (Maksimal 4MB)
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'keterangan' => 'nullable|string|max:255' // Mengantisipasi jika ada input teks judul/caption foto
        ]);

        // 2. Pilah data teks pendukung
        $dataTeks = $request->only(['keterangan', 'wisata_id']); 

        // 3. Tembak ke ApiService yang sudah kita perbaiki format multipart-nya kemarin
        $res = $this->api->pengelolaUploadGaleri($dataTeks, $request->file('foto'));
 
        // 4. Periksa apakah API sukses menyimpan gambarnya
        if (!$res->successful() || !$res->json('success')) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal mengunggah foto ke server.']);
        }

        return redirect()->route('pengelola.wisata')->with('success', 'Foto galeri berhasil diunggah.');
    }
 
    public function deleteGaleri($id)
    {
        $res = $this->api->pengelolaDeleteGaleri($id);

        if (!$res->successful()) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal menghapus foto dari galeri.']);
        }

        return redirect()->route('pengelola.wisata')->with('success', 'Foto galeri berhasil dihapus.');
    }
}