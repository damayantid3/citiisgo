<?php

namespace App\Http\Controllers\Pengelola;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class PeralatanController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index()
    {
        $peralatan = $this->api->getPeralatan()->json('data');
        return view('pengelola.peralatan.index', compact('peralatan'));
    }
 
    public function store(Request $request)
    {
        $this->api->createPeralatan($request->except('_token'));
        return redirect()->route('pengelola.peralatan')->with('success', 'Peralatan ditambahkan.');
    }
 
    public function update(Request $request, $id)
    {
        $this->api->updatePeralatan($id, $request->except(['_token','_method']));
        return redirect()->route('pengelola.peralatan')->with('success', 'Peralatan diperbarui.');
    }
 
    public function destroy($id)
    {
        $this->api->deletePeralatan($id);
        return redirect()->route('pengelola.peralatan')->with('success', 'Peralatan dihapus.');
    }
}
 