<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Menampilkan semua Jenis Layanan Citiis
     */
    public function index()
    {
        $res = $this->api->getKategori();
        $kategori = $res->successful() ? $res->json('data') : [];

        return view('admin.kategori.index', compact('kategori'));
    }

    /**
     * Menyimpan Jenis Layanan Baru ke API
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // FIXED: Disesuaikan dengan nama fungsi asli di ApiService Anda
        $res = $this->api->createKategori($request->all());

        if (!$res->successful()) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal menambah jenis layanan.']);
        }

        return redirect()->route('admin.kategori')->with('success', 'Jenis layanan baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui Nama Jenis Layanan via API
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // FIXED: Disesuaikan dengan nama fungsi asli di ApiService Anda
        $res = $this->api->updateKategori($id, $request->all());

        if (!$res->successful()) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal memperbarui jenis layanan.']);
        }

        return redirect()->route('admin.kategori')->with('success', 'Jenis layanan berhasil diperbarui.');
    }

    /**
     * Menghapus Jenis Layanan dari API
     */
    public function destroy($id)
    {
        // FIXED: Disesuaikan dengan nama fungsi asli di ApiService Anda
        $res = $this->api->deleteKategori($id);

        if (!$res->successful()) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal menghapus jenis layanan.']);
        }

        return redirect()->route('admin.kategori')->with('success', 'Jenis layanan berhasil dihapus.');
    }
}