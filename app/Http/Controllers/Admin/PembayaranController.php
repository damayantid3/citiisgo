<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index(Request $request)
    {
        $res       = $this->api->getPembayaran($request->only(['status','ref_type','dari','sampai','page']));
        $pembayaran = $res->json('data');
        return view('admin.pembayaran.index', compact('pembayaran'));
    }
 
    public function show($id)
    {
        $res  = $this->api->getPembayaranDetail($id);
        $data = $res->json('data');
        return view('admin.pembayaran.show', compact('data'));
    }
}
 