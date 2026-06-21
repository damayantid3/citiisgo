<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WisataController extends Controller
{
    private $apiBaseUrl = 'http://127.0.0.1:8000/api/v1';

    public function index()
    {
        $wisatas = [];
        $kategori_options = [];

        try {
            $responseWisata = Http::get("{$this->apiBaseUrl}/admin/wisata");
            if ($responseWisata->successful()) {
                $result = $responseWisata->json();
                $wisatas = $result['data']['data'] ?? ($result['data'] ?? []);
            }
            
            $responseKategori = Http::get("{$this->apiBaseUrl}/kategori");
            if ($responseKategori->successful()) {
                $katResult = $responseKategori->json();
                $kategori_options = $katResult['data'] ?? [];
            }
        } catch (\Exception $e) {
            $wisatas = [];
            $kategori_options = [];
        }
        
        return view('admin.wisata.index', compact('wisatas', 'kategori_options'));
    }

    public function store(Request $request)
    {
        try {
            $formData = $request->except('foto');
            
            if (!isset($formData['alamat'])) {
                $formData['alamat'] = 'Area Kawasan Wisata Citiis Galunggung';
            }
            if (!isset($formData['status'])) {
                $formData['status'] = 'active';
            }

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $response = Http::asMultipart()
                    ->attach('foto', file_get_contents($file->getPathname()), $file->getClientOriginalName())
                    ->post("{$this->apiBaseUrl}/admin/wisata", $formData);
            } else {
                $response = Http::post("{$this->apiBaseUrl}/admin/wisata", $formData);
            }

            if ($response->successful()) {
                return redirect()->route('admin.wisata')->with('success', 'Data wisata berhasil disimpan ke server pusat.');
            }

            return redirect()->route('admin.wisata')->with('error', 'Gagal menyimpan ke API: ' . $response->body());

        } catch (\Exception $e) {
            return redirect()->route('admin.wisata')->with('error', 'Koneksi ke API pusat terputus: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $formData = $request->except('foto');

            if (isset($formData['harga_tiket'])) {
                $formData['harga_tiket'] = str_replace('.', '', $formData['harga_tiket']);
            }
            if (!isset($formData['alamat'])) {
                $formData['alamat'] = 'Kawasan Wisata Pemandian Air Panas Citiis Galunggung';
            }
            if (!isset($formData['status'])) {
                $formData['status'] = 'active';
            }

            // ⚡ Mengirim payload dengan parameter _method=PUT sebagai bypass untuk metode POST biner
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $response = Http::asMultipart()
                    ->attach('foto', file_get_contents($file->getPathname()), $file->getClientOriginalName())
                    ->post("{$this->apiBaseUrl}/admin/wisata/{$id}", array_merge($formData, ['_method' => 'PUT']));
            } else {
                // Menggunakan asForm agar API dapat membaca inputan teks biasa secara stabil
                $response = Http::asForm()
                    ->post("{$this->apiBaseUrl}/admin/wisata/{$id}", array_merge($formData, ['_method' => 'PUT']));
            }

            if ($response->successful()) {
                return redirect()->route('admin.wisata')->with('success', 'Data wisata berhasil diperbarui.');
            }

            return redirect()->route('admin.wisata')->with('error', 'Gagal update API: ' . $response->body());

        } catch (\Exception $e) {
            return redirect()->route('admin.wisata')->with('error', 'Kesalahan sistem saat update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $response = Http::delete("{$this->apiBaseUrl}/admin/wisata/{$id}");
            if ($response->successful()) {
                return redirect()->route('admin.wisata')->with('success', 'Data wisata berhasil dihapus dari pusat API.');
            }
            return redirect()->route('admin.wisata')->with('error', 'Gagal menghapus data.');
        } catch (\Exception $e) {
            return redirect()->route('admin.wisata')->with('error', 'Gagal menyambungkan peladen: ' . $e->getMessage());
        }
    }
}