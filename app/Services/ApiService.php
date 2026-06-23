<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\{Http, Session, Log};
use Illuminate\Http\UploadedFile;

/**
 * CitiisGo API Service - FULL INTEGRATED CHANNELS
 * Semua request dari Web ke citiisgo-api melewati class ini.
 */
class ApiService
{
    private string $baseUrl;

    public function __construct()
    {
        // Ambil dari env CITIISGO_API_URL, fallback ke 127.0.0.1:8001 (port standar API)
        $this->baseUrl = rtrim(env('CITIISGO_API_URL', 'http://127.0.0.1:8001'), '/') . '/api/v1';
    }

    /**
     * Base HTTP Client builder dengan token otomatis jika tersedia
     */
    private function client(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->timeout(30)
            ->when(Session::get('api_token') ?? Session::get('token'), function ($request, $token) {
                return $request->withToken($token);
            });
    }

    /**
     * Base HTTP Client khusus upload file multipart/form-data
     */
    private function multipartClient(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->timeout(60)
            ->when(Session::get('api_token') ?? Session::get('token'), function ($request, $token) {
                return $request->withToken($token);
            });
    }

    // ── Auth ─────────────────────────────────────────────────
    public function register(array $data): Response
    {
        return $this->client()->post('/auth/register', $data);
    }

    public function login(string $email, string $password): Response
    {
        return $this->client()->post('/auth/login', compact('email', 'password'));
    }

    public function logout(): Response
    {
        try {
            return $this->client()->post('/auth/logout');
        } catch (\Exception $e) {
            Log::warning('API Logout failed or token already expired: ' . $e->getMessage());
            return Http::response(['success' => false, 'message' => 'Token expired'], 401);
        }
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

    public function adminStoreWisataMultipart(array $data, UploadedFile $file): Response
    {
        return $this->multipartClient()
                    ->attach('foto', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
                    ->post('/admin/wisata', $data);
    }

    public function adminUpdateWisataMultipart(int $id, array $data, UploadedFile $file): Response
    {
        $data['_method'] = 'PUT';
        return $this->multipartClient()
                    ->attach('foto', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
                    ->post("/admin/wisata/$id", $data);
    }

    // ── Admin: Kategori ──────────────────────────────────────
    // Pastikan method getKategori sudah ada di dalam class ApiService.php Anda
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

    // ── ⚡ Pengelola: Wisata (Tersinkronisasi & Steril) ─────
    public function pengelolaWisataDetail(): Response
    {
        return $this->client()->get('/pengelola/wisata');
    }

    public function pengelolaGetWisata(): Response
    {
        return $this->client()->get('/pengelola/wisata');
    }

    public function updateWisata(array $data): Response
    {
        return $this->client()->put('/pengelola/wisata', $data);
    }

    public function updateWisataMultipart(array $data, $file = null): Response
    {
        $req = $this->client(); 
        if ($file && $file instanceof \Illuminate\Http\UploadedFile) {
            $req->attach('foto', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName());
        }
        return $req->put('/pengelola/wisata', $data);
    }

    public function pengelolaWisataUpdate(array $data): Response
    {
        return $this->client()->put('/pengelola/wisata', $data);
    }

    public function pengelolaUploadGaleri(\Illuminate\Http\UploadedFile $file): Response
    {
        return $this->multipartClient()
                    ->attach('image', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
                    ->post('/pengelola/wisata/galeri');
    }

    public function pengelolaDeleteGaleri(int $id): Response
    {
        return $this->client()->delete("/pengelola/wisata/galeri/$id");
    }

    // ── ⚡ Pengelola: Paket Camping ─────────────────────────────
    public function getPaketCamping(): Response
    {
        return $this->client()->get('/pengelola/paket-camping');
    }

    /**
     * ⚡ DITAMBAHKAN: Mengakomodasi upload file biner multipart saat pembuatan data paket baru
     */
    public function createPaketCamping(array $data, UploadedFile $file = null): Response
    {
        if ($file) {
            return $this->multipartClient()
                        ->attach('foto', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
                        ->post('/pengelola/paket-camping', $data);
        }
        
        return $this->client()->post('/pengelola/paket-camping', $data);
    }

    public function updatePaketCamping(int $id, array $data, UploadedFile $file = null): Response
    {
        // ⚡ Jika ada file gambar yang dikirimkan saat pembaruan (edit)
        if ($file) {
            $data['_method'] = 'PUT'; // <- Menambahkan spoofing method agar backend port 8000 membaca PUT
            return $this->multipartClient()
                        ->attach('foto', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
                        ->post("/pengelola/paket-camping/{$id}", $data);
        }

        // Jika tidak ada file gambar yang diunggah, gunakan method PUT standar
        return $this->client()->put("/pengelola/paket-camping/{$id}", $data);
    }

    public function deletePaketCamping(int $id): Response
    {
        return $this->client()->delete("/pengelola/paket-camping/{$id}");
    }

    // ── Pengelola: Penginapan (Diperbarui untuk mendukung upload multipart)
public function getPenginapan(): Response
{
    return $this->client()->get('/pengelola/penginapan');
}

public function createPenginapan(array $data, UploadedFile $file = null): Response
{
    if ($file) {
        return $this->multipartClient()
                    ->attach('foto_cover', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
                    ->post('/pengelola/penginapan', $data);
    }
    return $this->client()->post('/pengelola/penginapan', $data);
}

public function updatePenginapan(int $id, array $data, UploadedFile $file = null): Response
{
    if ($file) {
        $data['_method'] = 'PUT'; // Spoofing method PUT via POST multipart
        return $this->multipartClient()
                    ->attach('foto_cover', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
                    ->post("/pengelola/penginapan/$id", $data);
    }
    return $this->client()->put("/pengelola/penginapan/$id", $data);
}

public function deletePenginapan(int $id): Response
{
    return $this->client()->delete("/pengelola/penginapan/$id");
}

    // ── Pengelola: Peralatan Camping ─────────────────────────
// ── Pengelola: Peralatan Camping (Diperbarui mendukung attachment file biner)
public function getPeralatan(): Response
{
    return $this->client()->get('/pengelola/peralatan');
}

public function createPeralatan(array $data, UploadedFile $file = null): Response
{
    if ($file) {
        return $this->multipartClient()
                    ->attach('foto', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
                    ->post('/pengelola/peralatan', $data);
    }
    return $this->client()->post('/pengelola/peralatan', $data);
}

public function updatePeralatan(int $id, array $data, UploadedFile $file = null): Response
{
    if ($file) {
        // Langsung kirim sebagai POST biner ke endpoint update yang telah diubah di port 8000
        return $this->multipartClient()
                    ->attach('foto', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
                    ->post("/pengelola/peralatan/$id", $data);
    }
    
    // Jika tidak ada file gambar yang diunggah, tetap gunakan method PUT standar (atau POST jika endpoint disamakan)
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