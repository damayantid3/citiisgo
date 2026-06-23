<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Menyimpan ulasan & rating baru dari wisatawan untuk sebuah destinasi.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wisata_id'    => 'required|integer',
            'reservasi_id' => 'nullable|integer',
            'rating'       => 'required|integer|min:1|max:5',
            'komentar'     => 'nullable|string|max:1000',
            'foto.*'       => 'nullable|image|max:2048',
        ]);

        $fotos = $request->file('foto') ?? [];

        $res = $this->api->createUlasan($validated, is_array($fotos) ? $fotos : [$fotos]);

        if (!$res->successful() || $res->json('success') === false) {
            return back()->withErrors([
                'error' => $res->json('message') ?? 'Gagal mengirim ulasan. Silakan coba lagi.',
            ]);
        }

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }

    public function destroy($id)
    {
        $res = $this->api->deleteUlasan($id);

        if (!$res->successful()) {
            return back()->withErrors(['error' => 'Gagal menghapus ulasan.']);
        }

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}