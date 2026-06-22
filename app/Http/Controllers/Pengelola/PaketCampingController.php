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

        return view('pengelola.paket.index', compact('paket'));
    }
 
    public function store(Request $request)
    {
        // 1. Validasi Input di Sisi Web
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'kapasitas'  => 'required|integer|min:1',
            'harga'      => 'required|numeric|min:0',
            'deskripsi'  => 'nullable|string',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $payload = [
            'nama_paket'      => $validated['nama_paket'],
            'kapasitas_tamu'  => $validated['kapasitas'],
            'harga_per_malam' => $validated['harga'],
            'deskripsi'       => $validated['deskripsi'],
            'total_slot'      => 99,
            'tersedia'        => true
        ];

        // 2. Ambil file foto dari request jika ada
        $fotoFile = $request->file('foto');

        // 3. Kirim ke API beserta file gambarnya
        $res = $this->api->createPaketCamping($payload, $fotoFile);
 
        if (!$res->successful() || !$res->json('success')) {
            return back()
                ->withInput()
                ->withErrors(['error' => $res->json('message') ?? 'Gagal menambahkan paket camping.']);
        }

        return redirect()->route('pengelola.camping')->with('success', 'Paket camping berhasil ditambahkan.');
    }
 
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'kapasitas'  => 'required|integer|min:1',
            'harga'      => 'required|numeric|min:0',
            'deskripsi'  => 'nullable|string',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $payload = [
            'nama_paket'      => $validated['nama_paket'],
            'kapasitas_tamu'  => $validated['kapasitas'],
            'harga_per_malam' => $validated['harga'],
            'deskripsi'       => $validated['deskripsi'],
            'total_slot'      => 99,
            'tersedia'        => true
        ];

        $fotoFile = $request->file('foto');

        // 2. Tembak ke API dengan menyertakan file foto jika diunggah
        $res = $this->api->updatePaketCamping($id, $payload, $fotoFile);
 
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