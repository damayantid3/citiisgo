<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WisataController extends Controller
{
    public function index()
    {
        // Simulasi data statis (mockup) agar halaman langsung tampil dan bisa dikelola
        $wisatas = Session::get('mock_wisatas', [
            [
                'id' => 1,
                'nama' => 'Tiket Masuk Pemandian Air Hangat Citiis',
                'kategori' => ['id' => 1, 'nama' => 'Tiket Masuk & Fasilitas Utama'],
                'harga_tiket' => 15000,
                'kuota_harian' => 100,
                'deskripsi' => 'Akses masuk kawasan wisata pemandian air panas alami Citiis Galunggung.',
                'foto_url' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6bab34?w=800&q=80',
                'status' => 'active'
            ],
            [
                'id' => 2,
                'nama' => 'Paket Camping Ground Citiis',
                'kategori' => ['id' => 2, 'nama' => 'Akomodasi & Camping'],
                'harga_tiket' => 35000,
                'kuota_harian' => 50,
                'deskripsi' => 'Sewa lahan camping ground di area kawasan wisata.',
                'foto_url' => 'https://images.unsplash.com/photo-1504280390367-361c6d9d37f4?w=800&q=80',
                'status' => 'active'
            ]
        ]);

        // Mockup data kategori untuk dropdown select
        $kategori_options = [
            ['id' => 1, 'nama' => 'Tiket Masuk & Fasilitas Utama'],
            ['id' => 2, 'nama' => 'Akomodasi & Camping'],
            ['id' => 3, 'nama' => 'Wahana Permainan']
        ];
        
        return view('admin.wisata.index', compact('wisatas', 'kategori_options'));
    }

    public function store(Request $request)
    {
        $wisatas = Session::get('mock_wisatas', []);
        
        $newId = count($wisatas) > 0 ? max(array_column($wisatas, 'id')) + 1 : 1;

        $newItem = [
            'id' => $newId,
            'nama' => $request->nama,
            'kategori' => [
                'id' => $request->kategori_id, 
                'nama' => $request->kategori_id == 1 ? 'Tiket Masuk & Fasilitas Utama' : 'Pilihan Lainnya'
            ],
            'harga_tiket' => (int)str_replace('.', '', $request->harga_tiket),
            'kuota_harian' => $request->kuota_harian,
            'deskripsi' => $request->deskripsi ?? '-',
            'foto_url' => 'https://images.unsplash.com/photo-1566336439368-0115324db633?w=800&q=80',
            'status' => 'active'
        ];

        $wisatas[] = $newItem;
        Session::put('mock_wisatas', $wisatas);

        return redirect()->route('admin.wisata')->with('success', 'Data layanan berhasil disimpan (Demo Mode).');
    }

    public function update(Request $request, $id)
    {
        $wisatas = Session::get('mock_wisatas', []);
        
        foreach ($wisatas as $key => $item) {
            if ($item['id'] == $id) {
                $wisatas[$key]['nama'] = $request->nama;
                $wisatas[$key]['kategori_id'] = $request->kategori_id;
                $wisatas[$key]['kategori'] = [
                    'id' => $request->kategori_id,
                    'nama' => $request->kategori_id == 1 ? 'Tiket Masuk & Fasilitas Utama' : 'Akomodasi & Camping'
                ];
                $wisatas[$key]['harga_tiket'] = (int)str_replace('.', '', $request->harga_tiket);
                $wisatas[$key]['kuota_harian'] = $request->kuota_harian;
                $wisatas[$key]['deskripsi'] = $request->deskripsi ?? '-';
                break;
            }
        }

        Session::put('mock_wisatas', $wisatas);
        return redirect()->route('admin.wisata')->with('success', 'Data layanan berhasil diperbarui (Demo Mode).');
    }

    public function destroy($id)
    {
        $wisatas = Session::get('mock_wisatas', []);
        
        $wisatas = array_filter($wisatas, function($item) use ($id) {
            return $item['id'] != $id;
        });

        Session::put('mock_wisatas', array_values($wisatas));
        return redirect()->route('admin.wisata')->with('success', 'Data layanan berhasil dihapus (Demo Mode).');
    }
}