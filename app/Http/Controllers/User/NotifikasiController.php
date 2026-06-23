<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function __construct(private ApiService $api) {}

    public function index()
    {
        $res = $this->api->getUserNotifikasi();
        $notifData = $res->successful() ? ($res->json('data.data') ?? $res->json('data') ?? []) : [];

        return view('user.notifikasi.index', compact('notifData'));
    }

    public function markAsRead($id)
    {
        $this->api->markNotifikasiRead((int) $id);
        return redirect()->route('user.notifikasi.index');
    }

    public function markAllRead()
    {
        $this->api->markAllNotifikasiRead();
        return redirect()->route('user.notifikasi.index');
    }
}