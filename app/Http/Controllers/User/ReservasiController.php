<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Proses booking tiket masuk wisata
     */
    public function store(Request $request)
    {
        $request->validate([
            'wisata_id'         => 'required|integer',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jumlah_orang'      => 'required|integer|min:1|max:20',
        ]);

        $res = $this->api->createReservasi([
            'wisata_id'         => $request->wisata_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jumlah_orang'      => $request->jumlah_orang,
            'catatan'           => $request->catatan,
        ]);

        if (!$res->successful()) {
            $msg = $res->json('message') ?? 'Gagal membuat reservasi. Coba lagi.';
            return back()->withInput()->with('error', $msg);
        }

        $data = $res->json('data');
        $reservasiId = $data['id'] ?? $data['reservasi']['id'] ?? null;

        return redirect()->route('user.booking.invoice', ['id' => $reservasiId])
                         ->with('success', 'Reservasi tiket berhasil! Lanjutkan pembayaran.');
    }

    /**
     * Riwayat semua reservasi tiket user
     */
    public function index()
    {
        $res = $this->api->getRiwayatReservasi();
        $reservasi = $res->successful() ? ($res->json('data') ?? []) : [];

        return view('user.booking.history', compact('reservasi'));
    }

    /**
     * Invoice / detail reservasi
     */
    public function invoice($id)
    {
        $res = $this->api->getDetailReservasi((int) $id);

        if (!$res->successful()) {
            return redirect()->route('user.booking.history')->with('error', 'Invoice tidak ditemukan.');
        }

        $reservasi = $res->json('data');
        return view('user.booking.invoice', compact('reservasi'));
    }

    /**
     * Batalkan reservasi
     */
    public function cancel($id)
    {
        $res = $this->api->cancelReservasi((int) $id);

        if (!$res->successful()) {
            return back()->with('error', 'Gagal membatalkan reservasi.');
        }

        return redirect()->route('user.booking.history')->with('success', 'Reservasi berhasil dibatalkan.');
    }
}