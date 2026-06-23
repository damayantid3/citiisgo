<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function __construct(private ApiService $api) {}

    public function index()
    {
        $resWisata   = $this->api->adminGetWisata();
        $resKategori = $this->api->getKategori();

        $wisatas          = $resWisata->successful()   ? ($resWisata->json('data.data')   ?? $resWisata->json('data')   ?? []) : [];
        $kategori_options = $resKategori->successful() ? ($resKategori->json('data')       ?? [])                              : [];

        return view('admin.wisata.index', compact('wisatas', 'kategori_options'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'kategori_id' => 'required|integer',
            'deskripsi'   => 'required|string',
            'harga_tiket' => 'required|numeric|min:0',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('foto');
        if (!isset($data['alamat']))  $data['alamat']  = 'Kawasan Wisata Citiis Galunggung';
        if (!isset($data['status']))  $data['status']  = 'active';

        // Kirim via ApiService agar token Bearer ikut terbawa
        if ($request->hasFile('foto')) {
            $res = $this->api->adminStoreWisataMultipart($data, $request->file('foto'));
        } else {
            $res = $this->api->adminCreateWisata($data);
        }

        if (!$res->successful()) {
            return back()->withInput()->with('error', 'Gagal menyimpan ke API: ' . ($res->json('message') ?? $res->body()));
        }

        return redirect()->route('admin.wisata')->with('success', 'Data wisata berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'harga_tiket' => 'required|numeric|min:0',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['foto', '_method']);
        if (!isset($data['alamat'])) $data['alamat'] = 'Kawasan Wisata Citiis Galunggung';
        if (!isset($data['status'])) $data['status'] = 'active';

        if ($request->hasFile('foto')) {
            $res = $this->api->adminUpdateWisataMultipart($id, $data, $request->file('foto'));
        } else {
            $res = $this->api->adminUpdateWisata($id, $data);
        }

        if (!$res->successful()) {
            return back()->withInput()->with('error', 'Gagal update: ' . ($res->json('message') ?? $res->body()));
        }

        return redirect()->route('admin.wisata')->with('success', 'Data wisata berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $res = $this->api->adminDeleteWisata($id);

        if (!$res->successful()) {
            return back()->with('error', 'Gagal menghapus data wisata.');
        }

        return redirect()->route('admin.wisata')->with('success', 'Data wisata berhasil dihapus.');
    }
}