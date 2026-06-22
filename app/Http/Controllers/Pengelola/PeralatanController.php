<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class PeralatanController extends Controller
{
    public function __construct(private ApiService $api) {}

    public function index()
    {
        $res = $this->api->getPeralatan();
        $peralatan = $res->successful() ? $res->json('data') : [];

        return view('pengelola.peralatan.index', compact('peralatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'                => 'required|string|max:255',
            'total_stok'          => 'required|numeric|min:1',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'deskripsi'           => 'nullable|string',
            'foto'                => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file = $request->file('foto');
        $payload = $request->except(['foto', '_method']);
        
        $res = $this->api->createPeralatan($payload, $file);

        if (!$res->successful()) {
            return back()->withInput()->withErrors(['error' => $res->json('message') ?? 'Gagal menyimpan peralatan.']);
        }

        return redirect()->route('pengelola.peralatan')->with('success', 'Aset peralatan berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'                => 'required|string|max:255',
            'total_stok'          => 'required|numeric|min:1',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'deskripsi'           => 'nullable|string',
            'foto'                => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file = $request->file('foto');
        $payload = $request->except(['foto', '_method']);

        $res = $this->api->updatePeralatan($id, $payload, $file);

        if (!$res->successful()) {
            return back()->withInput()->withErrors(['error' => $res->json('message') ?? 'Gagal memperbarui peralatan.']);
        }

        return redirect()->route('pengelola.peralatan')->with('success', 'Data aset peralatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $res = $this->api->deletePeralatan($id);
        
        if (!$res->successful()) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal menghapus peralatan.']);
        }

        return redirect()->route('pengelola.peralatan')->with('success', 'Peralatan berhasil dihapus.');
    }
}