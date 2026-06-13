<?php

namespace App\Http\Controllers\Pengelola;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class PenginapanController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index()
    {
        $penginapan = $this->api->getPenginapan()->json('data');
        return view('pengelola.penginapan.index', compact('penginapan'));
    }
 
    public function store(Request $request)
    {
        $this->api->createPenginapan($request->except('_token'));
        return redirect()->route('pengelola.penginapan')->with('success', 'Penginapan ditambahkan.');
    }
 
    public function update(Request $request, $id)
    {
        $this->api->updatePenginapan($id, $request->except(['_token','_method']));
        return redirect()->route('pengelola.penginapan')->with('success', 'Penginapan diperbarui.');
    }
}
 