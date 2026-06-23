<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private ApiService $api) {}

    // ── CAMPING ──────────────────────────────────────────────────────────

    public function showCamping(Request $request)
    {
        $wisataId = $request->query('wisata', 1);
        $res = $this->api->getPaketCampingPublik((int) $wisataId);
        $paketCamping = $res->successful() ? ($res->json('data') ?? []) : [];

        return view('user.booking.camping', compact('paketCamping', 'wisataId'));
    }

    public function storeCamping(Request $request)
    {
        $request->validate([
            'paket_camping_id' => 'required|integer',
            'tanggal_mulai'    => 'required|date|after_or_equal:today',
            'durasi'           => 'required|integer|min:1|max:30',
            'jumlah_tenda'     => 'required|integer|min:1|max:5',
        ]);

        // Hitung tanggal checkout dari durasi
        $checkout = date('Y-m-d', strtotime($request->tanggal_mulai . ' +' . $request->durasi . ' days'));

        $res = $this->api->createBookingCamping([
            'paket_camping_id' => $request->paket_camping_id,
            'tanggal_checkin'  => $request->tanggal_mulai,
            'tanggal_checkout' => $checkout,
            'jumlah_tamu'      => $request->jumlah_tenda,
        ]);

        if (!$res->successful()) {
            $msg = $res->json('message') ?? 'Gagal membuat booking camping.';
            return back()->withInput()->with('error', $msg);
        }

        $data = $res->json('data');
        $bookingId = $data['id'] ?? $data['booking']['id'] ?? null;

        return redirect()->route('user.booking.history')->with('success', 'Booking camping berhasil!');
    }

    // ── PENGINAPAN ────────────────────────────────────────────────────────

    public function showPenginapan(Request $request)
    {
        $wisataId = $request->query('wisata', 1);
        $res = $this->api->getPenginapanPublik((int) $wisataId);
        $penginapan = $res->successful() ? ($res->json('data') ?? []) : [];

        return view('user.booking.penginapan', compact('penginapan', 'wisataId'));
    }

    public function storePenginapan(Request $request)
    {
        $request->validate([
            'kamar_id'         => 'required|integer',
            'tanggal_checkin'  => 'required|date|after_or_equal:today',
            'tanggal_checkout' => 'required|date|after:tanggal_checkin',
            'jumlah_tamu'      => 'required|integer|min:1',
        ]);

        $res = $this->api->createBookingPenginapan($request->only([
            'kamar_id', 'tanggal_checkin', 'tanggal_checkout', 'jumlah_tamu'
        ]));

        if (!$res->successful()) {
            $msg = $res->json('message') ?? 'Gagal membuat booking penginapan.';
            return back()->withInput()->with('error', $msg);
        }

        return redirect()->route('user.booking.history')->with('success', 'Booking penginapan berhasil!');
    }

    // ── RIWAYAT SEMUA BOOKING ────────────────────────────────────────────

    public function history()
    {
        // Ambil semua jenis riwayat sekaligus
        $resReservasi  = $this->api->getRiwayatReservasi();
        $resCamping    = $this->api->getRiwayatBookingCamping();
        $resPenginapan = $this->api->getRiwayatBookingPenginapan();
        $resSewa       = $this->api->getRiwayatSewaPeralatan();

        $reservasi  = $resReservasi->successful()  ? ($resReservasi->json('data')  ?? []) : [];
        $camping    = $resCamping->successful()    ? ($resCamping->json('data')    ?? []) : [];
        $penginapan = $resPenginapan->successful() ? ($resPenginapan->json('data') ?? []) : [];
        $sewa       = $resSewa->successful()       ? ($resSewa->json('data')       ?? []) : [];

        // Normalisasi paginate
        if (isset($reservasi['data']))  $reservasi  = $reservasi['data'];
        if (isset($camping['data']))    $camping    = $camping['data'];
        if (isset($penginapan['data'])) $penginapan = $penginapan['data'];
        if (isset($sewa['data']))       $sewa       = $sewa['data'];

        return view('user.booking.history', compact('reservasi', 'camping', 'penginapan', 'sewa'));
    }
}