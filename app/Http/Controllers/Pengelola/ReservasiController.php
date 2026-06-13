<?php

namespace App\Http\Controllers\Pengelola;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index(Request $request)
    {
        $reservasi = $this->api->pengelolaGetReservasi($request->only(['status','page']))->json('data');
        $camping   = $this->api->pengelolaGetBookingCamping($request->only(['status','page']))->json('data');
        $penginapan= $this->api->pengelolaGetBookingPenginapan($request->only(['status','page']))->json('data');
        $sewa      = $this->api->pengelolaGetSewaPeralatan($request->only(['status','page']))->json('data');
        return view('pengelola.reservasi.index', compact('reservasi','camping','penginapan','sewa'));
    }
 
    public function update(Request $request, $id)
    {
        $this->api->pengelolaUpdateReservasi($id, $request->status);
        return redirect()->back()->with('success', 'Status diperbarui.');
    }
}
 