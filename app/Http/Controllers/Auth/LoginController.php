<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Arr;

class LoginController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function showForm()
    {
        if (session()->has('api_token') && session()->has('user_role')) {
            $role = session('user_role');
            $route = match($role) {
                'admin'     => 'admin.dashboard',
                'pengelola' => 'pengelola.dashboard',
                'user'      => 'user.dashboard',
                default     => 'login'
            };
            return redirect()->route($route);
        }
        return view('auth.login');
    }

    /**
     * Menampilkan Halaman Form Register Web Wisatawan
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Memproses Pendaftaran Akun Wisatawan baru via Web ke API
     */
    public function register(Request $request)
    {
        // Validasi input di sisi Web
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8'
        ]);

        try {
            // Gunakan ApiService agar baseUrl selalu konsisten dengan .env
            $response = $this->api->register([
                'nama'                  => $request->nama,
                'email'                 => $request->email,
                'password'              => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'role'                  => 'user'
            ]);

            if (!$response->successful() || !$response->json('success')) {
                $apiErrors = $response->json('errors') ?? [];
                $errorMessage = $response->json('message') ?? 'Gagal melakukan pendaftaran.';
                
                if (!empty($apiErrors)) {
                    $flattened = \Illuminate\Support\Arr::flatten($apiErrors);
                    $errorMessage = !empty($flattened) ? reset($flattened) : $errorMessage;
                }

                return back()
                    ->withInput($request->except('password'))
                    ->withErrors(['register_error' => $errorMessage]);
            }

            return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');

        } catch (Exception $e) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors(['register_error' => 'Gagal terhubung ke server Citiisgo-API.']);
        }
    }
 
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);
 
        try {
            $res = $this->api->login($request->email, $request->password);
    
            if (!$res->successful() || !$res->json('success')) {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => $res->json('message') ?? 'Email atau password salah.']);
            }
    
            $data = $res->json('data');
            $user = $data['user'];
            $role = $user['role'];
    
            if (!in_array($role, ['admin', 'pengelola', 'user'])) {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Hak akses role akun Anda tidak dikenali sistem.']);
            }
    
            $request->session()->regenerate();

            session([
                'api_token' => $data['token'],
                'user'      => $user,
                'user_role' => $role,
            ]);
    
            $route = match($role) {
                'admin'     => 'admin.dashboard',
                'pengelola' => 'pengelola.dashboard',
                'user'      => 'user.dashboard',
            };

            return redirect()->route($route)->with('success', 'Selamat datang kembali, ' . $user['name'] . ' 🌿');

        } catch (Exception $e) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Gagal terhubung ke server Citiisgo-API. Silakan coba lagi nanti.']);
        }
    }

    /**
     * Mengarahkan Wisatawan (User) yang sudah login ke halaman dasbor pemesanan wisata.
     */
    public function dashboard()
    {
        // Memastikan rute mengarah ke halaman utama user yang akan kita buat
        return redirect()->route('user.wisata.index');
    }
 
    public function logout(Request $request)
    {
        try {
            if (session()->has('api_token')) {
                $this->api->logout();
            }
        } catch (Exception $e) {}

        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}