<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Redirect ke halaman jelajah wisata sebagai dashboard utama wisatawan
        return redirect()->route('user.wisata.index');
    }
}