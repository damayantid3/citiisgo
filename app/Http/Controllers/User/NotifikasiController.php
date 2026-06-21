<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotifikasiController extends Controller
{
    private $apiBaseUrl = 'http://127.0.0.1:8000/api/v1';

    public function index(Request $request)
    {
        $notifData = [];
        try {
            // Mengambil token sanctum user yang sedang login di web
            $token = $request->session()->get('user_token');
            if ($token) {
                $response = Http::withToken($token)->get("{$this->apiBaseUrl}/user/notifikasi");
                if ($response->successful()) {
                    $notifData = $response->json()['data']['data'] ?? [];
                }
            }
        } catch (\Exception $e) {
            $notifData = [];
        }

        return view('user.notifikasi.index', compact('notifData'));
    }

    public function markAsRead(Request $request, $id)
    {
        try {
            $token = $request->session()->get('user_token');
            if ($token) {
                Http::withToken($token)->put("{$this->apiBaseUrl}/user/notifikasi/{$id}/read");
            }
        } catch (\Exception $e) {
            // Gagal senyap
        }
        return redirect()->route('user.notifikasi.index');
    }

    public function markAllRead(Request $request)
    {
        try {
            $token = $request->session()->get('user_token');
            if ($token) {
                Http::withToken($token)->post("{$this->apiBaseUrl}/user/notifikasi/read-all");
            }
        } catch (\Exception $e) {
            // Gagal senyap
        }
        return redirect()->route('user.notifikasi.index');
    }
}