<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    protected $api;

    public function __construct(ApiService $api) 
    {
        $this->api = $api;
    }

    /**
     * Menampilkan semua log data reservasi tiket masuk wahana/objek wisata
     */
    public function index()
    {
        $res = $this->api->pengelolaGetReservasi();
        
        $reservasi = ($res && $res->successful()) ? ($res->json('data') ?? []) : [];

        if ($res && !$res->successful()) {
            session()->flash('error', 'Gagal memuat data reservasi dari peladen pusat.');
        }

        return view('pengelola.reservasi.index', compact('reservasi'));
    }

    /**
     * Mengubah status tiket (Misal dari confirmed menjadi completed / check-in)
     */
    public function update(Request $request, $id)
    {
        // Validasi input status agar aman dari injeksi nilai tak terduga
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $status = $request->input('status', 'completed');

        // Menembak fungsi update status reservasi di ApiService (Port 8000)
        $res = $this->api->pengelolaUpdateReservasi($id, $status);

        if (!$res || !$res->successful()) {
            $errorMessage = $res ? ($res->json('message') ?? 'Terjadi kesalahan pada server.') : 'Tidak dapat terhubung ke API pusat.';
            return back()->withErrors(['error' => $errorMessage]);
        }

        return redirect()->route('pengelola.reservasi.index')
                         ->with('success', 'Validasi Check-In sukses! Wisatawan diperbolehkan masuk ke kawasan objek wisata.');
    }
}