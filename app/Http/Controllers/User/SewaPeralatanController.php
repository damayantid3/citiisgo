<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class SewaPeralatanController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Menampilkan form sewa peralatan camping untuk satu destinasi.
     * Katalog peralatan & stok mengikuti data yang dibuat Pengelola.
     */
    public function create(Request $request)
    {
        $wisataId = $request->query('wisata');

        if (!$wisataId) {
            return redirect()->route('user.wisata.index')
                ->with('error', 'Silakan pilih destinasi wisata terlebih dahulu.');
        }

        $resWisata    = $this->api->getWisataDetail($wisataId);
        $resPeralatan = $this->api->getPeralatanByWisata($wisataId);

        if (!$resWisata->successful()) {
            return redirect()->route('user.wisata.index')
                ->with('error', 'Destinasi wisata tidak ditemukan.');
        }

        $wisata    = $resWisata->json('data');
        $peralatan = $resPeralatan->successful() ? ($resPeralatan->json('data') ?? []) : [];

        if (empty($peralatan)) {
            return redirect()->route('user.wisata.show', $wisataId)
                ->with('error', 'Belum ada peralatan camping yang tersedia untuk disewa di destinasi ini.');
        }

        return view('user.booking.peralatan', compact('wisata', 'peralatan'));
    }

    /**
     * Menyimpan transaksi sewa peralatan (multi-item) via citiisgo-api.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wisata_id'                => 'required|integer',
            'tanggal_mulai'             => 'required|date|after_or_equal:today',
            'tanggal_selesai'           => 'required|date|after:tanggal_mulai',
            'items'                     => 'required|array|min:1',
            'items.*.peralatan_id'      => 'required|integer',
            'items.*.jumlah'            => 'required|integer|min:1',
        ]);

        $payload = [
            'wisata_id'       => $validated['wisata_id'],
            'tanggal_mulai'   => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'items'           => $validated['items'],
        ];

        $res = $this->api->createSewaPeralatan($payload);

        if (!$res->successful() || $res->json('success') === false) {
            return back()->withInput()->withErrors([
                'error' => $res->json('message') ?? 'Gagal menyewa peralatan. Silakan coba lagi.',
            ]);
        }

        $data       = $res->json('data');
        $paymentUrl = $res->json('payment_url');

        if ($paymentUrl) {
            return redirect()->away($paymentUrl);
        }

        return redirect()->route('user.booking.invoice', ['id' => $data['id'], 'tipe' => 'peralatan'])
            ->with('success', 'Sewa peralatan berhasil dibuat!');
    }

    public function cancel($id)
    {
        $res = $this->api->cancelSewaPeralatan($id);

        if (!$res->successful()) {
            return back()->withErrors(['error' => $res->json('message') ?? 'Gagal membatalkan sewa peralatan.']);
        }

        return redirect()->route('user.booking.history')->with('success', 'Sewa peralatan berhasil dibatalkan, stok dikembalikan.');
    }
}