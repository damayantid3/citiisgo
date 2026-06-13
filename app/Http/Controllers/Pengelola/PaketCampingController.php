<?php

namespace App\Http\Controllers\Pengelola;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class PaketCampingController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index()
    {
        $paket = $this->api->getPaketCamping()->json('data');
        return view('pengelola.camping.index', compact('paket'));
    }
 
    public function store(Request $request)
    {
        $this->api->createPaketCamping($request->except('_token'));
        return redirect()->route('pengelola.camping')->with('success', 'Paket camping ditambahkan.');
    }
 
    public function update(Request $request, $id)
    {
        $this->api->updatePaketCamping($id, $request->except(['_token','_method']));
        return redirect()->route('pengelola.camping')->with('success', 'Paket diperbarui.');
    }
 
    public function destroy($id)
    {
        $this->api->deletePaketCamping($id);
        return redirect()->route('pengelola.camping')->with('success', 'Paket dihapus.');
    }
}
 