<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class PaketCampingController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index()
    {
        $res = $this->api->getPaketCamping();
        
        // Proteksi jika server API down atau token tidak valid
        $paket = $res->successful() ? ($res->json('data') ?? []) : [];

        if (!$res->successful()) {
            session()->flash('error', 'Gagal memuat data paket camping dari server.');
        }

        // FIX DIREKTORI: Diarahkan ke folder internal 'paket' sesuai struktur yang sah
        return view('pengelola.paket.index', compact('paket'));
    }
 
    public function store(Request $request)
    {
        // 1. Validasi Input di Sisi Web (UX & Data Integrity)
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga'      => 'required|numeric|min:0',
            'kapasitas'  => 'required|integer|min:1',
            'deskripsi'  => 'nullable|string',
        ]);

        // 2. Kirim hanya data yang sudah tervalidasi ke API
        $res = $this->api->createPaketCamping($validated);
 
        if (!$res->successful() || !$res->json('success')) {
            return back()
                ->withInput()
                ->withErrors(['error' => $res->json('message') ?? 'Gagal menambahkan paket camping.']);
        }

        return redirect()->route('pengelola.camping')->with('success', 'Paket camping berhasil ditambahkan.');
    }
 
    public function update(Request $request, $id)
    {
        // 1. Validasi data pembaruan
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga'      => 'required|numeric|min:0',
            'kapasitas'  => 'required|integer|min:1',
            'deskripsi'  => 'nullable|string',
        ]);

        // 2. Tembak ke API dengan data yang aman
        $res = $this->api->updatePaketCamping($id, $validated);
 
        if (!$res->successful()) {
            return back()
                ->withInput()
                ->withErrors(['error' => $res->json('message') ?? 'Gagal memperbarui paket camping.']);
        }

        return redirect()->route('pengelola.camping')->with('success', 'Paket camping berhasil diperbarui.');
    }
 
    public function destroy($id)
    {
        $res = $this->api->deletePaketCamping($id);

        if (!$res->successful()) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal menghapus paket camping.']);
        }

        return redirect()->route('pengelola.camping')->with('success', 'Paket camping berhasil dihapus.');
    }
}