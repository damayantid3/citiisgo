<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    /**
     * Menampilkan daftar user dari API
     */
    public function index(Request $request)
    {
        $res = $this->api->getUsers($request->only(['search','role','status','page']));
        $apiData = $res->successful() ? $res->json('data') : null;
        $users = $apiData['data'] ?? []; 
        $pagination = $apiData ? collect($apiData)->except('data')->toArray() : [];

        return view('admin.users.index', compact('users', 'pagination'));
    }
 
    /**
     * Menyimpan user baru secara resmi via ApiService (Membawa Token Login)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,pengelola,wisatawan,user',
            'no_hp'    => 'nullable|string',
        ]);

        $payloadForApi = [
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => $request->role === 'wisatawan' ? 'user' : $request->role,
            'no_hp'    => $request->no_hp ?? '',
        ];

        // Tembak menggunakan ApiService agar token Authorization Bearer ikut terbawa
        $res = $this->api->createUser($payloadForApi);
 
        if ($res->successful() || $res->json('success') == true) {
            return redirect()->route('admin.users')->with('success', 'User baru berhasil disimpan ke database API.');
        }

        // Tangkap pesan gagal validasi unik jika email sudah ada di DB API
        $apiErrorMessage = $res->json('message') ?? $res->json('error') ?? 'Gagal menambahkan user ke server API.';
        if (is_array($apiErrorMessage)) {
            $apiErrorMessage = implode(', ', \Illuminate\Support\Arr::flatten($apiErrorMessage));
        }

        return back()->withInput()->withErrors(['email' => $apiErrorMessage]);
    }
 
    /**
     * Memperbarui data profil user di server API
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email',
            'role'  => 'required|in:admin,pengelola,wisatawan,user',
        ]);

        $payloadForApi = [
            'nama'  => $request->nama,
            'email' => $request->email,
            'role'  => $request->role === 'wisatawan' ? 'user' : $request->role,
        ];

        $res = $this->api->updateUser($id, $payloadForApi);

        if ($res->successful() || $res->json('success') == true) {
            return redirect()->route('admin.users')->with('success', 'Data user berhasil diperbarui.');
        }

        $apiErrorMessage = $res->json('message') ?? $res->json('error') ?? 'Gagal memperbarui data user.';
        return back()->withErrors(['error' => $apiErrorMessage]);
    }
 
    /**
     * Menghapus user secara permanen dari server API
     */
    public function destroy($id)
    {
        $res = $this->api->deleteUser($id);

        if ($res->successful() || $res->json('success') == true) {
            return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
        }

        return back()->withErrors(['error' => $res->json('message') ?? 'Gagal menghapus user dari server API.']);
    }

    /**
     * Mengubah role user via API
     */
    public function changeRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,pengelola,user',
        ]);

        $res = $this->api->changeUserRole($id, $request->role);

        if ($res->successful() || $res->json('success') == true) {
            return redirect()->route('admin.users')->with('success', 'Role user berhasil diubah.');
        }

        return back()->withErrors(['error' => $res->json('message') ?? 'Gagal mengubah role user.']);
    }}