<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Daftar semua wisata untuk halaman Jelajah
     */
    public function index(Request $request)
    {
        $params = $request->only(['search', 'kategori_id', 'sort']);
        $resWisata   = $this->api->getWisataPublik($params);
        $resKategori = $this->api->getKategori();

        $daftarWisata = $resWisata->successful()   ? ($resWisata->json('data') ?? []) : [];
        $kategori     = $resKategori->successful() ? ($resKategori->json('data') ?? []) : [];

        // Normalisasi: jika API mengembalikan paginate (ada key 'data' di dalam 'data')
        if (isset($daftarWisata['data'])) {
            $daftarWisata = $daftarWisata['data'];
        }

        return view('user.wisata.index', compact('daftarWisata', 'kategori'));
    }

    /**
     * Detail wisata + form reservasi tiket
     */
    public function show($id)
    {
        $res = $this->api->getWisataDetail((int) $id);

        if (!$res->successful()) {
            abort(404, 'Destinasi wisata tidak ditemukan.');
        }

        $wisata = $res->json('data');

        // Ambil paket camping, penginapan, peralatan milik wisata ini
        $resCamping    = $this->api->getPaketCampingPublik((int) $id);
        $resPenginapan = $this->api->getPenginapanPublik((int) $id);
        $resPeralatan  = $this->api->getPeralatanPublik((int) $id);

        $paketCamping = $resCamping->successful()    ? ($resCamping->json('data')    ?? []) : [];
        $penginapan   = $resPenginapan->successful() ? ($resPenginapan->json('data') ?? []) : [];
        $peralatan    = $resPeralatan->successful()  ? ($resPeralatan->json('data')  ?? []) : [];

        return view('user.wisata.show', compact('wisata', 'paketCamping', 'penginapan', 'peralatan'));
    }
}