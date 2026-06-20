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
            'nama'                 => 'required|string|max:255',
            'total_stok'           => 'required|numeric|min:1',
            'harga_sewa_per_hari'  => 'required|numeric|min:0',
            'deskripsi'            => 'nullable|string',
        ]);

        $payload = $request->all();
        $payload['stok_tersedia'] = $request->total_stok;

        $res = $this->api->createPeralatan($payload);

        if (!$res->successful()) {
            return back()->withInput()->withErrors(['error' => $res->json('message') ?? 'Gagal menyimpan peralatan.']);
        }

        return redirect()->route('pengelola.peralatan')->with('success', 'Aset peralatan berhasil disimpan.');
    }

    public function destroy($id)
    {
        $res = $this->api->deletePeralatan($id);
        return redirect()->route('pengelola.peralatan')->with('success', 'Peralatan berhasil dihapus.');
    }
}