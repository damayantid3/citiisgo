<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Menampilkan semua log data reservasi tiket masuk
     */
    public function index()
    {
        $res = $this->api->pengelolaGetReservasi();
        $reservasi = $res->successful() ? $res->json('data') : [];

        return view('pengelola.reservasi.index', compact('reservasi'));
    }

    /**
     * Mengubah status tiket (Misal dari confirmed menjadi completed / check-in)
     */
    public function update(Request $request, $id)
    {
        $status = $request->input('status', 'completed');

        // Menembak fungsi update status reservasi di ApiService
        $res = $this->api->pengelolaUpdateReservasi($id, $status);

        if (!$res->successful()) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal mengubah status validasi tiket.']);
        }

        return redirect()->route('pengelola.reservasi')->with('success', 'Validasi Check-In sukses! Wisatawan diperbolehkan masuk.');
    }
}