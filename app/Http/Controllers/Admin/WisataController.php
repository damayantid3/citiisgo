<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index(Request $request)
    {
        $res    = $this->api->adminGetWisata($request->only(['search','status','kategori_id','page']));
        $wisata = $res->json('data');
        $kat    = $this->api->getKategori()->json('data');
        return view('admin.wisata.index', compact('wisata','kat'));
    }
 
    public function store(Request $request)
    {
        $this->api->adminCreateWisata($request->all());
        return redirect()->route('admin.wisata')->with('success', 'Wisata ditambahkan.');
    }
 
    public function update(Request $request, $id)
    {
        $this->api->adminUpdateWisata($id, $request->all());
        return redirect()->route('admin.wisata')->with('success', 'Wisata diperbarui.');
    }
 
    public function destroy($id)
    {
        $this->api->adminDeleteWisata($id);
        return redirect()->route('admin.wisata')->with('success', 'Wisata dihapus.');
    }
}