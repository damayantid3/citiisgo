<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class PenginapanController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Menampilkan daftar penginapan Citiis dari API
     */
    public function index()
    {
        $res = $this->api->getPenginapan();
        $penginapan = $res->successful() ? $res->json('data') : [];

        return view('pengelola.penginapan.index', compact('penginapan'));
    }

    /**
     * Mengirim data pendaftaran penginapan baru ke API beserta file visual
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:255',
            'alamat'     => 'nullable|string|max:255',
            'deskripsi'  => 'nullable|string',
            'foto_cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file = $request->file('foto_cover');
        $res = $this->api->createPenginapan($request->except(['foto_cover']), $file);

        if (!$res->successful()) {
            return back()->withInput()->withErrors(['error' => $res->json('message') ?? 'Gagal mendaftarkan penginapan.']);
        }

        return redirect()->route('pengelola.penginapan')->with('success', 'Unit properti penginapan berhasil didaftarkan.');
    }

    /**
     * Memperbarui properti penginapan beserta visual cover
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'       => 'required|string|max:255',
            'alamat'     => 'nullable|string|max:255',
            'deskripsi'  => 'nullable|string',
            'foto_cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file = $request->file('foto_cover');
        $res = $this->api->updatePenginapan($id, $request->except(['foto_cover', '_method']), $file);

        if (!$res->successful()) {
            return back()->withInput()->withErrors(['error' => $res->json('message') ?? 'Gagal memperbarui penginapan.']);
        }

        return redirect()->route('pengelola.penginapan')->with('success', 'Unit properti penginapan berhasil diperbarui.');
    }

    /**
     * Menghapus properti penginapan
     */
    public function destroy($id)
    {
        $res = $this->api->deletePenginapan($id);

        if (!$res->successful()) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal menghapus unit penginapan.']);
        }

        return redirect()->route('pengelola.penginapan')->with('success', 'Unit penginapan berhasil dihapus dari sistem.');
    }
}