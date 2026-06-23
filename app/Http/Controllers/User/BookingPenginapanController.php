<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class BookingPenginapanController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Menampilkan form booking kamar penginapan untuk satu destinasi.
     * Daftar properti & kamar mengikuti data yang dibuat Pengelola.
     */
    public function create(Request $request)
    {
        $wisataId = $request->query('wisata');

        if (!$wisataId) {
            return redirect()->route('user.wisata.index')
                ->with('error', 'Silakan pilih destinasi wisata terlebih dahulu.');
        }

        $resWisata     = $this->api->getWisataDetail($wisataId);
        $resPenginapan = $this->api->getPenginapanByWisata($wisataId);

        if (!$resWisata->successful()) {
            return redirect()->route('user.wisata.index')
                ->with('error', 'Destinasi wisata tidak ditemukan.');
        }

        $wisata     = $resWisata->json('data');
        $penginapan = $resPenginapan->successful() ? ($resPenginapan->json('data') ?? []) : [];

        // Lengkapi setiap unit penginapan dengan daftar kamarnya
        foreach ($penginapan as &$unit) {
            $resKamar = $this->api->getKamarPenginapan($unit['id']);
            $unit['kamar'] = $resKamar->successful() ? ($resKamar->json('data') ?? []) : [];
        }
        unset($unit);

        if (empty($penginapan)) {
            return redirect()->route('user.wisata.show', $wisataId)
                ->with('error', 'Belum ada unit penginapan yang tersedia untuk destinasi ini.');
        }

        return view('user.booking.penginapan', compact('wisata', 'penginapan'));
    }

    /**
     * Menyimpan booking penginapan baru via citiisgo-api.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wisata_id'        => 'required|integer',
            'kamar_id'         => 'required|integer',
            'tanggal_checkin'  => 'required|date|after_or_equal:today',
            'tanggal_checkout' => 'required|date|after:tanggal_checkin',
            'jumlah_tamu'      => 'required|integer|min:1',
        ]);

        $payload = [
            'kamar_id'         => $validated['kamar_id'],
            'tanggal_checkin'  => $validated['tanggal_checkin'],
            'tanggal_checkout' => $validated['tanggal_checkout'],
            'jumlah_tamu'      => $validated['jumlah_tamu'],
        ];

        $res = $this->api->createBookingPenginapan($payload);

        if (!$res->successful() || $res->json('success') === false) {
            return back()->withInput()->withErrors([
                'error' => $res->json('message') ?? 'Gagal membuat booking penginapan. Silakan coba lagi.',
            ]);
        }

        $data       = $res->json('data');
        $paymentUrl = $res->json('payment_url');

        if ($paymentUrl) {
            return redirect()->away($paymentUrl);
        }

        return redirect()->route('user.booking.invoice', ['id' => $data['id'], 'tipe' => 'penginapan'])
            ->with('success', 'Booking penginapan berhasil dibuat!');
    }

    public function cancel($id)
    {
        $res = $this->api->cancelBookingPenginapan($id);

        if (!$res->successful()) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal membatalkan booking penginapan.']);
        }

        return redirect()->route('user.booking.history')->with('success', 'Booking penginapan berhasil dibatalkan.');
    }
}