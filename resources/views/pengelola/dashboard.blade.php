@extends('layouts.app')
@section('title', 'Dashboard Pengelola - CitiisGo')
@section('topbar-title', '📊 Dashboard Pengelola')

@section('content')
<div class="mb-6 text-left">
    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Selamat Datang Kembali, Pengelola Kawasan 🌿</h1>
    <p class="text-sm text-slate-500 font-medium mt-1">Berikut adalah rangkuman performa operasional harian, status pesanan masuk, dan ketersediaan kuota Citiis hari ini.</p>
</div>

{{-- ── STATS COUNTER GRID ── --}}
<div class="grid grid-cols-1 sm:grid-cols-4 gap-5 mb-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm border-t-4 border-t-emerald-600 relative overflow-hidden">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Tiket Check-In</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">{{ $data['total_kunjungan'] ?? 0 }} Orang</div>
        <div class="text-xs text-slate-400 font-medium">Wisandari masuk kawasan</div>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm border-t-4 border-t-amber-500 relative overflow-hidden">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Reservasi Tiket Pending</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">{{ $data['reservasi_pending'] ?? 0 }} Antrean</div>
        <div class="text-xs text-amber-600 font-bold">Menunggu konfirmasi loket</div>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm border-t-4 border-t-blue-500 relative overflow-hidden">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Booking Camping Baru</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">{{ $data['booking_camping'] ?? 0 }} Pesanan</div>
        <div class="text-xs text-slate-400 font-medium">Perlu penyiapan lapak kemah</div>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm border-t-4 border-t-indigo-500 relative overflow-hidden">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Booking Penginapan</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">{{ $data['booking_penginapan'] ?? 0 }} Kamar</div>
        <div class="text-xs text-slate-400 font-medium">Menunggu kedatangan tamu</div>
    </div>
</div>

{{-- ── INFORMASI KAWASAN CARD ── --}}
<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm w-full text-left">
    <h3 class="text-base font-bold text-slate-900 mb-2">🌿 Profil Obyek Wisata Citiis</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-medium text-slate-600 mt-4">
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
            <span class="text-slate-400 block font-bold uppercase text-[9px] tracking-wider">Nama Destinasi</span>
            <span class="text-sm font-extrabold text-slate-800 mt-0.5 block">{{ $data['wisata']['nama'] ?? 'Kawasan Wisata Alam Citiis' }}</span>
        </div>
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
            <span class="text-slate-400 block font-bold uppercase text-[9px] tracking-wider">Alamat Lokasi</span>
            <span class="text-sm font-bold text-slate-700 mt-0.5 block truncate">{{ $data['wisata']['alamat'] ?? 'Kec. Padakembang, Tasikmalaya, Jawa Barat' }}</span>
        </div>
    </div>
</div>
@endsection