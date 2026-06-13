<?php

namespace App\Http\Controllers\Pengelola;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index()
    {
        $wisata = $this->api->pengelolaGetWisata()->json('data');
        return view('pengelola.wisata.index', compact('wisata'));
    }
 
    public function update(Request $request)
    {
        $this->api->pengelolaUpdateWisata($request->except(['_token','_method']));
        return redirect()->route('pengelola.wisata')->with('success', 'Data wisata diperbarui.');
    }
 
    public function uploadGaleri(Request $request)
    {
        $request->validate(['foto'=>'required|image|max:4096']);
        $this->api->pengelolaUploadGaleri(
            $request->except(['_token','foto']),
            $request->file('foto')
        );
        return redirect()->route('pengelola.wisata')->with('success', 'Foto berhasil diupload.');
    }
 
    public function deleteGaleri($id)
    {
        $this->api->pengelolaDeleteGaleri($id);
        return redirect()->route('pengelola.wisata')->with('success', 'Foto dihapus.');
    }
}