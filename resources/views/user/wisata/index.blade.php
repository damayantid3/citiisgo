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
        <div class="mt-6 flex items-center bg-white border border-slate-200 rounded-2xl p-2 shadow-md max-w-md mx-auto">
            <span class="pl-2 text-sm">🔍</span>
            <input type="text" placeholder="Cari tiket masuk atau paket camping..." class="w-full border-none px-3 py-1.5 text-xs font-medium text-slate-700 outline-none">
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition-all shadow-sm cursor-pointer border-none outline-none">Cari</button>
        </div>
    </div>

    {{-- FILTER KATEGORI CHIPS --}}
    <div class="flex items-center justify-start sm:justify-center gap-2 overflow-x-auto pb-4 mb-8 scrollbar-none">
        <button class="bg-emerald-600 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-sm whitespace-nowrap cursor-pointer border-none outline-none">✨ Semua Destinasi</button>
        <button class="bg-white border border-slate-200 text-slate-600 font-bold text-xs px-4 py-2 rounded-xl hover:bg-slate-50 whitespace-nowrap cursor-pointer outline-none">♨️ Air Hangat Alami</button>
        <button class="bg-white border border-slate-200 text-slate-600 font-bold text-xs px-4 py-2 rounded-xl hover:bg-slate-50 whitespace-nowrap cursor-pointer outline-none">🏕️ Spot Camping</button>
        <button class="bg-white border border-slate-200 text-slate-600 font-bold text-xs px-4 py-2 rounded-xl hover:bg-slate-50 whitespace-nowrap cursor-pointer outline-none">🏞️ Curug / Air Terjun</button>
    </div>

    {{-- GRID DAFTAR WISATA DINAMIS DARI BACKEND API --}}
    <div id="layanan-pesanan" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="col-span-full text-center py-12 text-slate-400" id="loading-state-user">
            <i class="fas fa-spinner fa-spin text-3xl text-emerald-700 mb-3"></i>
            <p class="font-bold text-slate-600 animate-pulse text-xs">Menarik data destinasi wisata dan layanan Citiis...</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const BASE_API_URL = 'http://127.0.0.1:8000/api/v1';
        const gridContainer = document.getElementById('layanan-pesanan');
        const loadingState = document.getElementById('loading-state-user');

        fetch(`${BASE_API_URL}/wisata`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success && result.data && result.data.length > 0) {
                if (loadingState) loadingState.remove();
                gridContainer.innerHTML = '';

                result.data.forEach(item => {
                    // Panggil url foto dari direktori storage absolut backend port 8000
                    const fotoBanner = item.foto_url || 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=600&q=80';
                    const hargaTiket = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.harga_tiket || 0);
                    const ratingVal = item.rating ? parseFloat(item.rating).toFixed(1) : '5.0';
                    const kategoriNama = item.kategori ? (item.kategori.nama || 'Alam') : 'Fasilitas Utama';

                    const cardHTML = `
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col h-full">
                        <div class="aspect-[16/10] bg-slate-100 relative overflow-hidden group">
                            <img src="${fotoBanner}" alt="${item.nama}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-2 left-2 bg-white/90 backdrop-blur-xs border border-slate-100 text-slate-800 font-black text-[9px] uppercase px-2 py-0.5 rounded-md tracking-wider">
                                ⭐ ${ratingVal}
                            </div>
                        </div>
                        
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[9px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100/40 uppercase tracking-wider">${kategoriNama}</span>
                                <h3 class="font-extrabold text-slate-900 text-sm tracking-tight mt-1.5 leading-snug line-clamp-1">${item.nama}</h3>
                                <p class="text-[11px] text-slate-400 font-medium mt-1 truncate">📍 ${item.alamat || 'Kawasan Wisata Citiis Galunggung'}</p>
                            </div>
                            
                            <div class="flex items-center justify-between border-t border-slate-100 pt-3 mt-4">
                                <div>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Mulai Dari</span>
                                    <span class="text-xs font-black text-slate-800">${hargaTiket}</span>
                                </div>
                                <a href="/user/wisata/${item.id}" class="inline-flex items-center justify-center bg-slate-900 hover:bg-slate-800 text-white font-bold text-[11px] px-3.5 h-8 rounded-lg transition-transform active:scale-95 cursor-pointer border-none outline-none">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    `;
                    gridContainer.innerHTML += cardHTML;
                });
            } else {
                if (loadingState) {
                    loadingState.innerHTML = `
                        <i class="fa-solid fa-ban text-3xl text-slate-300 mb-2 block"></i>
                        <p class="font-black text-slate-600 text-xs">Belum ada data destinasi atau layanan wahana.</p>
                    `;
                }
            }
        })
        .catch(error => {
            console.error('Error fetching wisata:', error);
            if (loadingState) {
                loadingState.innerHTML = `
                    <i class="fa-solid fa-triangle-exclamation text-3xl text-rose-400 mb-2 block"></i>
                    <p class="text-rose-600 font-bold text-xs">Gagal Menarik Data Destinasi Pusat!</p>
                `;
            }
        });
    });
</script>
@endpush