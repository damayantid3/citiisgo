<?php
namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\{Http, Session};

/**
 * CitiisGo API Service
 * Semua request dari Web ke citiisgo-api melewati class ini.
 */
class ApiService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('citiisgo.api_url', env('CITIISGO_API_URL', 'http://localhost:8000/api/v1'));
    }

    // ── HTTP Client ──────────────────────────────────────────
    private function client(): \Illuminate\Http\Client\PendingRequest
    {
        $request = Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->timeout(30);

        $token = Session::get('api_token');
        if ($token) {
            $request = $request->withToken($token);
        }

        return $request;
    }

    // ── Auth ─────────────────────────────────────────────────
    public function login(string $email, string $password): Response
    {
        return $this->client()->post('/auth/login', compact('email', 'password'));
    }

    public function logout(): Response
    {
        return $this->client()->post('/auth/logout');
    }

    public function me(): Response
    {
        return $this->client()->get('/auth/me');
    }

    // ── Admin: Users ─────────────────────────────────────────
    public function getUsers(array $params = []): Response
    {
        return $this->client()->get('/admin/users', $params);
    }

    public function createUser(array $data): Response
    {
        return $this->client()->post('/admin/users', $data);
    }

    public function updateUser(int $id, array $data): Response
    {
        return $this->client()->put("/admin/users/$id", $data);
    }

    public function deleteUser(int $id): Response
    {
        return $this->client()->delete("/admin/users/$id");
    }

    public function changeUserRole(int $id, string $role): Response
    {
        return $this->client()->put("/admin/users/$id/role", compact('role'));
    }

    // ── Admin: Wisata ────────────────────────────────────────
    public function adminGetWisata(array $params = []): Response
    {
        return $this->client()->get('/admin/wisata', $params);
    }

    public function adminCreateWisata(array $data): Response
    {
        return $this->client()->post('/admin/wisata', $data);
    }

    public function adminUpdateWisata(int $id, array $data): Response
    {
        return $this->client()->put("/admin/wisata/$id", $data);
    }

    public function adminDeleteWisata(int $id): Response
    {
        return $this->client()->delete("/admin/wisata/$id");
    }

    // ── Admin: Kategori ──────────────────────────────────────
    public function getKategori(): Response
    {
        return $this->client()->get('/kategori-wisata');
    }

    public function createKategori(array $data): Response
    {
        return $this->client()->post('/admin/kategori', $data);
    }

    public function updateKategori(int $id, array $data): Response
    {
        return $this->client()->put("/admin/kategori/$id", $data);
    }

    public function deleteKategori(int $id): Response
    {
        return $this->client()->delete("/admin/kategori/$id");
    }

    // ── Admin: Pembayaran ────────────────────────────────────
    public function getPembayaran(array $params = []): Response
    {
        return $this->client()->get('/admin/pembayaran', $params);
    }

    public function getPembayaranDetail(int $id): Response
    {
        return $this->client()->get("/admin/pembayaran/$id");
    }

    // ── Admin: Laporan ───────────────────────────────────────
    public function adminGetLaporan(array $params = []): Response
    {
        return $this->client()->get('/admin/laporan', $params);
    }

    public function adminDashboard(): Response
    {
        return $this->client()->get('/admin/dashboard');
    }

    // ── Pengelola: Dashboard ─────────────────────────────────
    public function pengelolaDashboard(): Response
    {
        return $this->client()->get('/pengelola/dashboard');
    }

    // ── Pengelola: Wisata ────────────────────────────────────
    public function pengelolaGetWisata(): Response
    {
        return $this->client()->get('/pengelola/wisata');
    }

    public function pengelolaUpdateWisata(array $data): Response
    {
        return $this->client()->put('/pengelola/wisata', $data);
    }

    public function pengelolaUploadGaleri(array $data, $foto): Response
    {
        return $this->client()->attach('foto', $foto->getContent(), $foto->getClientOriginalName())
            ->post('/pengelola/wisata/galeri', $data);
    }

    public function pengelolaDeleteGaleri(int $id): Response
    {
        return $this->client()->delete("/pengelola/wisata/galeri/$id");
    }

    // ── Pengelola: Paket Camping ─────────────────────────────
    public function getPaketCamping(): Response
    {
        return $this->client()->get('/pengelola/paket-camping');
    }

    public function createPaketCamping(array $data): Response
    {
        return $this->client()->post('/pengelola/paket-camping', $data);
    }

    public function updatePaketCamping(int $id, array $data): Response
    {
        return $this->client()->put("/pengelola/paket-camping/$id", $data);
    }

    public function deletePaketCamping(int $id): Response
    {
        return $this->client()->delete("/pengelola/paket-camping/$id");
    }

    // ── Pengelola: Penginapan ────────────────────────────────
    public function getPenginapan(): Response
    {
        return $this->client()->get('/pengelola/penginapan');
    }

    public function createPenginapan(array $data): Response
    {
        return $this->client()->post('/pengelola/penginapan', $data);
    }

    public function updatePenginapan(int $id, array $data): Response
    {
        return $this->client()->put("/pengelola/penginapan/$id", $data);
    }

    // ── Pengelola: Peralatan ─────────────────────────────────
    public function getPeralatan(): Response
    {
        return $this->client()->get('/pengelola/peralatan');
    }

    public function createPeralatan(array $data): Response
    {
        return $this->client()->post('/pengelola/peralatan', $data);
    }

    public function updatePeralatan(int $id, array $data): Response
    {
        return $this->client()->put("/pengelola/peralatan/$id", $data);
    }

    public function deletePeralatan(int $id): Response
    {
        return $this->client()->delete("/pengelola/peralatan/$id");
    }

    // ── Pengelola: Reservasi & Booking ───────────────────────
    public function pengelolaGetReservasi(array $params = []): Response
    {
        return $this->client()->get('/pengelola/reservasi', $params);
    }

    public function pengelolaUpdateReservasi(int $id, string $status): Response
    {
        return $this->client()->put("/pengelola/reservasi/$id", compact('status'));
    }

    public function pengelolaGetBookingCamping(array $params = []): Response
    {
        return $this->client()->get('/pengelola/booking-camping', $params);
    }

    public function pengelolaGetBookingPenginapan(array $params = []): Response
    {
        return $this->client()->get('/pengelola/booking-penginapan', $params);
    }

    public function pengelolaGetSewaPeralatan(array $params = []): Response
    {
        return $this->client()->get('/pengelola/sewa-peralatan', $params);
    }

    // ── Pengelola: Laporan ───────────────────────────────────
    public function pengelolaGetLaporan(array $params = []): Response
    {
        return $this->client()->get('/pengelola/laporan', $params);
    }
}