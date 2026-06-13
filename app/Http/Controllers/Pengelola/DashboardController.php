<?php

namespace App\Http\Controllers\Pengelola;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index()
    {
        $stats = $this->api->pengelolaDashboard()->json('data');
        return view('pengelola.dashboard', compact('stats'));
    }
}