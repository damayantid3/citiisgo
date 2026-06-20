<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\ApiService;
use Exception;

class AuthWeb
{
    // Inject ApiService ke dalam middleware
    public function __construct(private ApiService $api) {}

    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        // 1. Cek apakah session token dasar ada di web lokal
        if (!session()->has('api_token')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Validasi Token ke Citiisgo-API secara Real-time
        try {
            $response = $this->api->me();

            // Jika API merespon 401 (Unauthorized) atau token sudah tidak valid
            if ($response->status() === 401 || !$response->json('success')) {
                return $this->forceLogout($request, 'Sesi Anda telah berakhir. Silakan login kembali.');
            }
        } catch (Exception $e) {
            // Jika API down/offline, web tetap mengizinkan akses halaman statis 
            // atau Anda bisa memilih untuk memblokirnya di sini.
            // Log::error('Middleware API Check failed: ' . $e->getMessage());
        }

        // 3. Validasi Hak Akses (Role)
        $userRole = session('user_role');
        if (!empty($roles) && !in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki wewenang membuka halaman ini.');
        }

        return $next($request);
    }

    /**
     * Fungsi pembantu untuk membersihkan session jika token hangus
     */
    private function forceLogout(Request $request, string $message)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('error', $message);
    }
}