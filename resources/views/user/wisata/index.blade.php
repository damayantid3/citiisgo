@extends('layouts.user')
@section('title', 'Jelajah Destinasi Wisata - CitiisGo')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 text-left font-sans">
    
    {{-- BARIS PENCARIAN & SLOGAN --}}
    <div class="text-center max-w-2xl mx-auto mb-10">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Temukan Petualangan Seru Anda 🌿</h1>
        <p class="text-xs text-slate-500 font-medium mt-1">Jelajahi keindahan wisata alam, kolam air hangat, dan spot camping terbaik di kawasan Galunggung.</p>
        
        {{-- Form Cari --}}
        <div class="mt-6 flex items-center bg-white border border-slate-200 rounded-2xl p-2 shadow-md max-w-md mx-auto">
            <span class="pl-2 text-sm">🔍</span>
            <input type="text" placeholder="Cari tiket masuk atau paket camping..." class="w-full border-none px-3 py-1.5 text-xs font-medium text-slate-700 outline-none">
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition-all shadow-sm">Cari</button>
        </div>
    </div>

    {{-- FILTER KATEGORI CHIPS --}}
    <div class="flex items-center justify-start sm:justify-center gap-2 overflow-x-auto pb-4 mb-8 scrollbar-none">
        <button class="bg-emerald-600 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-sm whitespace-nowrap">✨ Semua Destinasi</button>
        <button class="bg-white border border-slate-200 text-slate-600 font-bold text-xs px-4 py-2 rounded-xl hover:bg-slate-50 whitespace-nowrap">♨️ Air Hangat Alami</button>
        <button class="bg-white border border-slate-200 text-slate-600 font-bold text-xs px-4 py-2 rounded-xl hover:bg-slate-50 whitespace-nowrap">🏕️ Spot Camping</button>
        <button class="bg-white border border-slate-200 text-slate-600 font-bold text-xs px-4 py-2 rounded-xl hover:bg-slate-50 whitespace-nowrap">🏞️ Curug / Air Terjun</button>
    </div>

    {{-- GRID DAFTAR WISATA ASLI --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            // Membaca array koleksi dari API, jika kosong berikan array fallback aman
            $items = $daftarWisata['data'] ?? $daftarWisata ?? [
                [
                    'id' => 1,
                    'nama' => 'Tiket Masuk Utama + Kolam Air Hangat',
                    'alamat' => 'Kawasan Wisata Citiis Galunggung, Tasikmalaya',
                    'harga_tiket' => 15000,
                    'rating' => 4.8,
                    'kategori' => ['nama' => 'Tiket Masuk & Fasilitas Utama']
                ]
            ];
        @endphp

        @foreach($items as $item)
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col">
            {{-- Foto Wisata Thumbnail --}}
            <div class="aspect-[16/10] bg-slate-100 relative overflow-hidden group">
                <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute top-2 left-2 bg-white/90 backdrop-blur-xs border border-slate-100 text-slate-800 font-black text-[9px] uppercase px-2 py-0.5 rounded-md tracking-wider">
                    ⭐ {{ number_format($item['rating'] ?? 5.0, 1) }}
                </div>
            </div>
            
            {{-- Konten Teks --}}
            <div class="p-4 flex-1 flex flex-col justify-between">
                <div>
                    <span class="text-[9px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100/40 uppercase tracking-wider">{{ $item['kategori']['nama'] ?? 'Alam' }}</span>
                    <h3 class="font-extrabold text-slate-900 text-sm tracking-tight mt-1.5 leading-snug line-clamp-1">{{ $item['nama'] }}</h3>
                    <p class="text-[11px] text-slate-400 font-medium mt-1 truncate">📍 {{ $item['alamat'] }}</p>
                </div>
                
                {{-- Harga & Tombol Detail --}}
                <div class="flex items-center justify-between border-t border-slate-100 pt-3 mt-4">
                    <div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Mulai Dari</span>
                        <span class="text-xs font-black text-slate-800">Rp{{ number_format($item['harga_tiket'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <a href="/user/wisata/{{ $item['id'] }}" class="inline-flex items-center justify-center bg-slate-900 hover:bg-slate-800 text-white font-bold text-[11px] px-3.5 h-8 rounded-lg transition-transform active:scale-95">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection