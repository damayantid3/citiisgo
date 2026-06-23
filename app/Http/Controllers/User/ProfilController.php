<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function __construct(private ApiService $api) {}

    /**
     * Menampilkan halaman profil akun wisatawan yang sedang login.
     */
    public function index()
    {
        $res  = $this->api->me();
        $user = $res->successful() ? $res->json('data') : session('user');

        return view('user.profil.index', compact('user'));
    }

    /**
     * Memperbarui data profil wisatawan (nama, no hp, foto, password).
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama'                  => 'sometimes|string|max:255',
            'no_hp'                 => 'sometimes|string|max:20',
            'password'              => 'nullable|string|min:8|confirmed',
            'foto_profil'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = collect($validated)->except(['foto_profil', 'password_confirmation'])->filter()->all();

        if (!empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $foto = $request->file('foto_profil');

        $res = $this->api->updateProfile($data, $foto);

        if (!$res->successful() || $res->json('success') === false) {
            return back()->withErrors([
                'error' => $res->json('message') ?? 'Gagal memperbarui profil. Silakan coba lagi.',
            ]);
        }

        // Sinkronkan ulang sesi nama/email tampilan setelah update berhasil
        $updatedUser = $res->json('data');
        if ($updatedUser) {
            session(['user' => $updatedUser]);
        }

        return redirect()->route('user.profil')->with('success', 'Profil berhasil diperbarui.');
    }
}