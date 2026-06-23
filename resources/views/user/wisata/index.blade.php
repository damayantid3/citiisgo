@extends('layouts.user')
@section('title', 'Jelajah Destinasi Wisata - CitiisGo')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-left font-sans">

    {{-- ── BREADCRUMB ── --}}
    <div class="flex items-center gap-2 text-[10px] text-slate-400 mb-5 font-semibold">
        <a href="{{ route('user.dashboard') }}" class="hover:text-emerald-600 transition-colors">🏠 Beranda</a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-500">Jelajah Wahana Wisata</span>
    </div>
    
    {{-- BARIS PENCARIAN & SLOGAN --}}
    <div class="text-center max-w-2xl mx-auto mb-10">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Temukan Petualangan Seru Anda 🌿</h1>
        <p class="text-xs text-slate-500 font-medium mt-1">Jelajahi keindahan wisata alam, kolam air hangat, dan spot camping terbaik di kawasan Galunggung.</p>
        
        {{-- Form Cari --}}
        <form method="GET" action="{{ route('user.wisata.index') }}" class="mt-6 flex items-center bg-white border border-slate-200 rounded-2xl p-2 shadow-md max-w-md mx-auto">
            <span class="pl-2 text-sm">🔍</span>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari tiket masuk atau paket camping..."
                   class="w-full border-none px-3 py-1.5 text-xs font-medium text-slate-700 outline-none">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition-all shadow-sm cursor-pointer border-none outline-none">Cari</button>
        </form>
    </div>

    {{-- FILTER KATEGORI --}}
    <div class="flex items-center justify-start sm:justify-center gap-2 overflow-x-auto pb-4 mb-8 scrollbar-none">
        <a href="{{ route('user.wisata.index') }}"
           class="font-bold text-xs px-4 py-2 rounded-xl shadow-sm whitespace-nowrap border
                  {{ !request('kategori_id') ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            ✨ Semua Destinasi
        </a>
        @foreach($kategori as $kat)
        <a href="{{ route('user.wisata.index', ['kategori_id' => $kat['id']]) }}"
           class="font-bold text-xs px-4 py-2 rounded-xl shadow-sm whitespace-nowrap border
                  {{ request('kategori_id') == $kat['id'] ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            {{ $kat['nama'] }}
        </a>
        @endforeach
    </div>

    {{-- GRID DAFTAR WISATA DARI CONTROLLER (SERVER-SIDE) --}}
    <div id="layanan-pesanan" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($daftarWisata as $item)
        @php
            $foto     = $item['foto_url'] ?? asset('assets/img/wisata/CitiisFoto.jpg');
            $harga    = 'Rp ' . number_format($item['harga_tiket'] ?? 0, 0, ',', '.');
            $rating   = number_format($item['rating'] ?? 5, 1);
            $kategoriNama = $item['kategori']['nama'] ?? 'Fasilitas Umum';
        @endphp
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col h-full">
            <div class="aspect-[16/10] bg-slate-100 relative overflow-hidden group">
                <img src="{{ $foto }}" alt="{{ $item['nama'] }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute top-2 left-2 bg-white/90 border border-slate-100 text-slate-800 font-black text-[9px] uppercase px-2 py-0.5 rounded-md tracking-wider">
                    ⭐ {{ $rating }}
                </div>
            </div>
            <div class="p-4 flex-1 flex flex-col justify-between">
                <div>
                    <span class="text-[9px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100/40 uppercase tracking-wider">
                        {{ $kategoriNama }}
                    </span>
                    <h3 class="font-extrabold text-slate-900 text-sm tracking-tight mt-1.5 leading-snug line-clamp-1">{{ $item['nama'] }}</h3>
                    <p class="text-[11px] text-slate-400 font-medium mt-1 truncate">📍 {{ $item['alamat'] ?? 'Kawasan Wisata Citiis Galunggung' }}</p>
                </div>
                <div class="flex items-center justify-between border-t border-slate-100 pt-3 mt-4">
                    <div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Mulai Dari</span>
                        <span class="text-xs font-black text-slate-800">{{ $harga }}</span>
                    </div>
                    <a href="{{ route('user.wisata.show', $item['id']) }}"
                       class="inline-flex items-center justify-center bg-slate-900 hover:bg-slate-800 text-white font-bold text-[11px] px-3.5 h-8 rounded-lg transition cursor-pointer border-none outline-none">
                        Pesan Tiket
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-slate-400">
            <i class="fa-solid fa-ban text-3xl text-slate-300 mb-2 block"></i>
            <p class="font-black text-slate-600 text-xs">Belum ada data destinasi atau layanan wahana.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection