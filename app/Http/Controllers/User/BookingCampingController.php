<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class BookingCampingController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Menampilkan form booking paket camping untuk satu destinasi.
     * Paket yang ditampilkan murni hasil input Pengelola lewat citiisgo-api.
     */
    public function create(Request $request)
    {
        $wisataId = $request->query('wisata');

        if (!$wisataId) {
            return redirect()->route('user.wisata.index')
                ->with('error', 'Silakan pilih destinasi wisata terlebih dahulu.');
        }

        $resWisata = $this->api->getWisataDetail($wisataId);
        $resPaket  = $this->api->getPaketCampingByWisata($wisataId);

        if (!$resWisata->successful()) {
            return redirect()->route('user.wisata.index')
                ->with('error', 'Destinasi wisata tidak ditemukan.');
        }

        $wisata = $resWisata->json('data');
        $paket  = $resPaket->successful() ? ($resPaket->json('data') ?? []) : [];

        if (empty($paket)) {
            return redirect()->route('user.wisata.show', $wisataId)
                ->with('error', 'Belum ada paket camping yang tersedia untuk destinasi ini.');
        }

        return view('user.booking.camping', compact('wisata', 'paket'));
    }

    /**
     * Menyimpan booking camping baru via citiisgo-api.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wisata_id'         => 'required|integer',
            'paket_camping_id'  => 'required|integer',
            'tanggal_checkin'   => 'required|date|after_or_equal:today',
            'tanggal_checkout'  => 'required|date|after:tanggal_checkin',
            'jumlah_tamu'       => 'required|integer|min:1',
        ]);

        $payload = [
            'paket_camping_id' => $validated['paket_camping_id'],
            'tanggal_checkin'  => $validated['tanggal_checkin'],
            'tanggal_checkout' => $validated['tanggal_checkout'],
            'jumlah_tamu'      => $validated['jumlah_tamu'],
        ];

        $res = $this->api->createBookingCamping($payload);

        if (!$res->successful() || $res->json('success') === false) {
            return back()->withInput()->withErrors([
                'error' => $res->json('message') ?? 'Gagal membuat booking camping. Silakan coba lagi.',
            ]);
        }

        $data       = $res->json('data');
        $paymentUrl = $res->json('payment_url');

        if ($paymentUrl) {
            return redirect()->away($paymentUrl);
        }

        return redirect()->route('user.booking.invoice', ['id' => $data['id'], 'tipe' => 'camping'])
            ->with('success', 'Booking camping berhasil dibuat! Kode booking: ' . ($data['kode_booking'] ?? '-'));
    }

    public function cancel($id)
    {
        $res = $this->api->cancelBookingCamping($id);

        if (!$res->successful()) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal membatalkan booking camping.']);
        }

        return redirect()->route('user.booking.history')->with('success', 'Booking camping berhasil dibatalkan.');
    }
}