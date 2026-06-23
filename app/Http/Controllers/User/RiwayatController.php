<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Menggabungkan riwayat dari 4 jenis layanan (tiket masuk, camping,
     * penginapan, sewa alat) menjadi satu daftar riwayat terurut terbaru.
     * Mengikuti pola yang sama seperti BookingRepositoryApi di citiisgo-mobile,
     * supaya tampilan wisatawan konsisten antara web & mobile.
     */
    public function index(Request $request)
    {
        $riwayat = [];

        // 1. Tiket Masuk (Reservasi)
        $resTiket = $this->api->getMyReservasi();
        if ($resTiket->successful() && $resTiket->json('success') !== false) {
            $list = $resTiket->json('data.data') ?? $resTiket->json('data') ?? [];
            foreach ((array) $list as $item) {
                $riwayat[] = [
                    'id'          => $item['id'],
                    'tipe'        => 'Tiket Masuk',
                    'icon'        => 'fa-ticket',
                    'layanan'     => $item['wisata']['nama'] ?? 'Tiket Masuk Wisata',
                    'tanggal'     => $item['tanggal_kunjungan'] ?? '-',
                    'detail'      => ($item['jumlah_tiket'] ?? 1) . ' Orang',
                    'total_harga' => $item['total_harga'] ?? 0,
                    'status'      => $item['status'] ?? 'pending',
                    'kode'        => $item['kode_booking'] ?? null,
                ];
            }
        }

        // 2. Booking Camping
        $resCamping = $this->api->getMyBookingCamping();
        if ($resCamping->successful() && $resCamping->json('success') !== false) {
            $list = $resCamping->json('data.data') ?? $resCamping->json('data') ?? [];
            foreach ((array) $list as $item) {
                $riwayat[] = [
                    'id'          => $item['id'],
                    'tipe'        => 'Camping',
                    'icon'        => 'fa-campground',
                    'layanan'     => $item['paket']['nama_paket'] ?? 'Paket Camping',
                    'tanggal'     => ($item['tanggal_checkin'] ?? '-') . ' s/d ' . ($item['tanggal_checkout'] ?? '-'),
                    'detail'      => ($item['jumlah_tamu'] ?? 1) . ' Tamu',
                    'total_harga' => $item['total_harga'] ?? 0,
                    'status'      => $item['status'] ?? 'pending',
                    'kode'        => $item['kode_booking'] ?? null,
                ];
            }
        }

        // 3. Booking Penginapan
        $resPenginapan = $this->api->getMyBookingPenginapan();
        if ($resPenginapan->successful() && $resPenginapan->json('success') !== false) {
            $list = $resPenginapan->json('data.data') ?? $resPenginapan->json('data') ?? [];
            foreach ((array) $list as $item) {
                $riwayat[] = [
                    'id'          => $item['id'],
                    'tipe'        => 'Penginapan',
                    'icon'        => 'fa-house-chimney-window',
                    'layanan'     => $item['kamar']['tipe_kamar'] ?? 'Kamar Penginapan',
                    'tanggal'     => ($item['tanggal_checkin'] ?? '-') . ' s/d ' . ($item['tanggal_checkout'] ?? '-'),
                    'detail'      => ($item['jumlah_tamu'] ?? 1) . ' Tamu',
                    'total_harga' => $item['total_harga'] ?? 0,
                    'status'      => $item['status'] ?? 'pending',
                    'kode'        => $item['kode_booking'] ?? null,
                ];
            }
        }

        // 4. Sewa Peralatan
        $resPeralatan = $this->api->getMySewaPeralatan();
        if ($resPeralatan->successful() && $resPeralatan->json('success') !== false) {
            $list = $resPeralatan->json('data.data') ?? $resPeralatan->json('data') ?? [];
            foreach ((array) $list as $item) {
                $jumlahBarang = is_countable($item['detail'] ?? null) ? count($item['detail']) : 0;
                $riwayat[] = [
                    'id'          => $item['id'],
                    'tipe'        => 'Sewa Alat',
                    'icon'        => 'fa-person-hiking',
                    'layanan'     => 'Sewa Peralatan Camping',
                    'tanggal'     => ($item['tanggal_mulai'] ?? '-') . ' s/d ' . ($item['tanggal_selesai'] ?? '-'),
                    'detail'      => $jumlahBarang . ' Jenis Barang',
                    'total_harga' => $item['total_harga'] ?? 0,
                    'status'      => $item['status'] ?? 'pending',
                    'kode'        => $item['kode_sewa'] ?? null,
                ];
            }
        }

        // Filter status jika ada query
        if ($request->filled('status')) {
            $riwayat = array_filter($riwayat, fn($r) => $r['status'] === $request->status);
        }

        // Urutkan terbaru di atas (berdasarkan id sebagai proxy waktu pembuatan)
        usort($riwayat, fn($a, $b) => $b['id'] <=> $a['id']);

        return view('user.booking.history', compact('riwayat'));
    }
}