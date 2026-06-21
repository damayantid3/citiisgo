@extends('layouts.app')
@section('title', 'Dashboard Pengelola - CitiisGo')
@section('topbar-title', '📊 Dashboard Pengelola')

@section('content')
@php
    $localData = $data ?? [];
    $totalReservasi = $localData['reservasi_pending'] ?? 0;
@endphp

{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 font-medium">
    <span class="text-sm">🏠</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Dashboard Mitra</span>
</div>

{{-- ── PAGE HEADER (HORIZONTALLY ALIGNED) ── --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6 w-full">
    <div class="text-left">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Selamat Datang, Mitra Pengelola! 🌿</h1>
        <p class="text-sm text-slate-500 font-medium mt-1">{{ now()->isoFormat('dddd, D MMMM YYYY') }} — Ringkasan performa operasional dan rekapitulasi unit bisnis Anda</p>
    </div>
    <div class="flex items-center gap-2.5 justify-start lg:justify-end">
        <button onclick="location.href='{{ route('pengelola.reservasi') }}'" class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white font-bold text-xs px-4 h-9 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-all duration-150 cursor-pointer border-none outline-none">
            ✅ Validasi Reservasi
        </button>
    </div>
</div>

{{-- ── PRIMARY STATS GRID (Satu Warna Monokromatik & Kontras Elegan) ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-200 border-t-4 border-t-emerald-600">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Pendapatan</div>
        <div class="text-xl font-extrabold text-slate-900 my-1.5 tracking-tight">
            Rp {{ number_format($localData['total_pendapatan'] ?? 0, 0, ',', '.') }}
        </div>
        <div class="text-xs text-slate-500 font-medium flex items-center gap-1">
            <span class="text-emerald-600 font-bold">Omset Bersih</span> unit bisnis
        </div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-4xl opacity-10 group-hover:scale-110 transition-transform duration-200">
            <svg class="w-8 h-8 stroke-current text-slate-600" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-200 border-t-4 border-t-blue-600">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Check-In</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">
            {{ number_format($localData['total_kunjungan'] ?? 0) }}
        </div>
        <div class="text-xs text-slate-500 font-medium flex items-center gap-1">
            <span class="text-blue-600 font-bold">Orang</span> masuk kawasan
        </div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-4xl opacity-10 group-hover:scale-110 transition-transform duration-200">
            <svg class="w-8 h-8 stroke-current text-slate-600" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-200 border-t-4 border-t-amber-500">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Reservasi Pending</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">
            {{ number_format($totalReservasi) }}
        </div>
        <div class="text-xs text-slate-500 font-medium flex items-center gap-1">
            <span class="text-amber-600 font-bold">Antrean</span> konfirmasi loket
        </div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-4xl opacity-10 group-hover:scale-110 transition-transform duration-200">
            <svg class="w-8 h-8 stroke-current text-slate-600" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-200 border-t-4 border-t-purple-600">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Sub-Bisnis</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">
            @php 
                $totalUnit = ($localData['paket_camping_count'] ?? 0) + ($localData['kamar_penginapan_count'] ?? 0) + ($localData['peralatan_count'] ?? 0);
            @endphp
            {{ $totalUnit }}
        </div>
        <div class="text-xs text-slate-500 font-medium flex items-center gap-1">
            <span class="text-purple-600 font-bold">Rumpun</span> aset terdaftar
        </div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-4xl opacity-10 group-hover:scale-110 transition-transform duration-200">
            <svg class="w-8 h-8 stroke-current text-slate-600" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
        </div>
    </div>

</div>

{{-- ── SECONDARY SUB-MODUL MINI STATS GRID ── --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    
    <div class="bg-white border border-slate-200 rounded-2xl p-4 flex items-center gap-3.5 shadow-sm">
        <div class="w-11 h-11 rounded-xl bg-slate-50 flex items-center justify-center text-xl shadow-inner border border-slate-100">
            <svg class="w-6 h-6 stroke-current text-slate-600" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4 0 5 1 8 0 4-1 4-1V3s-1 1-4 0-5-1-8 0-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
        </div>
        <div>
            <div class="text-xl font-extrabold text-slate-900 leading-none">{{ $localData['paket_camping_count'] ?? 0 }}</div>
            <div class="text-[11px] text-slate-400 font-semibold mt-1">Paket Camping Area</div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 flex items-center gap-3.5 shadow-sm">
        <div class="w-11 h-11 rounded-xl bg-slate-50 flex items-center justify-center text-xl shadow-inner border border-slate-100">
            <svg class="w-6 h-6 stroke-current text-slate-600" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        </div>
        <div>
            <div class="text-xl font-extrabold text-slate-900 leading-none">{{ $localData['kamar_penginapan_count'] ?? 0 }}</div>
            <div class="text-[11px] text-slate-400 font-semibold mt-1">Kamar / Resor Inap</div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 flex items-center gap-3.5 shadow-sm">
        <div class="w-11 h-11 rounded-xl bg-slate-50 flex items-center justify-center text-xl shadow-inner border border-slate-100">
            <svg class="w-6 h-6 stroke-current text-slate-600" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline></svg>
        </div>
        <div>
            <div class="text-xl font-extrabold text-slate-900 leading-none">{{ $localData['peralatan_count'] ?? 0 }}</div>
            <div class="text-[11px] text-slate-400 font-semibold mt-1">Sewa Alat Outdoor</div>
        </div>
    </div>

</div>

{{-- ── CHARTS & ANALYTICS ROW (Steril Satu Warna monokromatik palet Logo) ── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg> Grafik Ringkasan Kunjungan Bulanan
            </h3>
        </div>
        <div class="p-5 flex-1 flex flex-col justify-end">
            <div id="chartBars" class="flex items-end gap-3 h-36 px-2"></div>
            <div id="chartLabels" class="flex mt-2.5"></div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm w-full text-left flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-2.5 mb-3">
                <div class="w-7 h-7 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-xs text-slate-600">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                </div>
                <h3 class="text-xs font-black text-slate-800 tracking-tight">📍 Profil Wahana / Objek Kelola Mitra</h3>
            </div>
            
            <div class="grid grid-cols-1 gap-3.5 text-3xs font-medium text-slate-600 mt-2">
                <div class="bg-slate-50/70 p-4 rounded-xl border border-slate-100 flex flex-col">
                    <span class="text-slate-400 font-black uppercase text-[9px] tracking-wider">Nama Destinasi Wahana</span>
                    <span class="text-xs font-extrabold text-slate-800 mt-0.5 tracking-tight">{{ $localData['wisata']['nama'] ?? 'Menunggu Sinkronisasi Data Wisata...' }}</span>
                </div>
                <div class="bg-slate-50/70 p-4 rounded-xl border border-slate-100 flex flex-col">
                    <span class="text-slate-400 font-black uppercase text-[9px] tracking-wider">Alamat Lokasi Obyek</span>
                    <span class="text-xs font-bold text-slate-700 mt-0.5 truncate">{{ $localData['wisata']['alamat'] ?? '—' }}</span>
                </div>
            </div>
        </div>
        
        <div class="pt-4 border-t border-slate-100 text-[9px] text-slate-400 font-black tracking-wider uppercase flex items-center justify-between mt-4">
            <span>ID Mitra Pengelola: #{{ $localData['wisata']['id'] ?? '—' }}</span>
            <span>Status Sentral API: Terhubung</span>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agus','Sep','Okt','Nov','Des'];
// Mengambil data grafik dari response json API pusat atau set fallback array
const chartData = JSON.parse('{!! json_encode($localData['grafik_kunjungan'] ?? [12, 19, 3, 5, 2, 3, 30, 45, 25, 33, 18, 22]) !!}');
const max = Math.max(...chartData, 1);
const chart = document.getElementById('chartBars');
const labels = document.getElementById('chartLabels');

chart.innerHTML = '';
labels.innerHTML = '';

chartData.forEach((v, i) => {
    const col = document.createElement('div');
    col.className = 'flex-1 flex flex-col items-center gap-1 cursor-pointer h-full justify-end group';
    
    const bar = document.createElement('div');
    bar.className = 'w-full rounded-t-lg transition-all duration-200 relative bg-emerald-600 hover:opacity-80';
    bar.style.height = Math.round(v/max*100)+'%';
    bar.title = `${months[i] ?? 'Bulan'}: ${v} Kunjungan`;
    
    col.appendChild(bar); 
    chart.appendChild(col);

    const lbl = document.createElement('div');
    lbl.className = 'flex-1 text-center text-[9px] font-bold text-slate-400 uppercase tracking-wider';
    lbl.textContent = months[i] ?? 'M'; 
    labels.appendChild(lbl);
});
</script>
@endpush