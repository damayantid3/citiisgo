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
     * Mengirim data pendaftaran penginapan baru ke API
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'alamat'    => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $res = $this->api->createPenginapan($request->all());

        if (!$res->successful()) {
            return back()->withInput()->withErrors(['error' => $res->json('message') ?? 'Gagal mendaftarkan penginapan.']);
        }

        return redirect()->route('pengelola.penginapan')->with('success', 'Unit properti penginapan berhasil didaftarkan.');
    }
}