<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
 
class DashboardController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index()
    {
        $stats = $this->api->adminDashboard()->json('data');
        return view('admin.dashboard', compact('stats'));
    }
}