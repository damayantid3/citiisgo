<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index()
    {
        $kategori = $this->api->getKategori()->json('data');
        return view('admin.kategori.index', compact('kategori'));
    }
 
    public function store(Request $request)
    {
        $this->api->createKategori($request->only(['nama','ikon','deskripsi']));
        return redirect()->route('admin.kategori')->with('success', 'Kategori ditambahkan.');
    }
 
    public function update(Request $request, $id)
    {
        $this->api->updateKategori($id, $request->only(['nama','ikon','deskripsi']));
        return redirect()->route('admin.kategori')->with('success', 'Kategori diperbarui.');
    }
 
    public function destroy($id)
    {
        $this->api->deleteKategori($id);
        return redirect()->route('admin.kategori')->with('success', 'Kategori dihapus.');
    }
}