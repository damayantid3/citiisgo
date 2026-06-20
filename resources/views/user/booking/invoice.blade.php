@extends('layouts.user')
@section('title', 'E-Tiket Resmi CitiisGo')

@section('content')
<div class="max-w-md mx-auto px-4 py-8 text-center font-sans">
    
    {{-- AREA SURAT TIKET DIGITAL --}}
    <div class="bg-white border-2 border-slate-200 rounded-3xl shadow-xl overflow-hidden relative">
        {{-- Header Warna Hijau --}}
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-5 text-white text-left">
            <h2 class="text-base font-black tracking-tight">🌿 E-TIKET RESMI CITIISGO</h2>
            <p class="text-[10px] text-emerald-100 font-medium mt-0.5">Tunjukkan halaman QR-Code ini kepada petugas loket pintu masuk.</p>
        </div>

        {{-- AREA QR CODE UTAMA --}}
        <div class="p-6 bg-white flex flex-col items-center justify-center border-b border-dashed border-slate-200">
            <div class="w-40 h-40 bg-slate-50 border-2 border-emerald-600 p-2.5 rounded-2xl shadow-inner flex items-center justify-center text-6xl select-none">
                🔳 {{-- Bisa dirender dengan {!! QrCode::size(140)->generate($invoice['kode_reservasi']) !!} jika pakai library qr --}}
            </div>
            <span class="text-xs font-mono font-black text-slate-800 mt-3 tracking-widest bg-slate-50 px-3 py-1 rounded-md border border-slate-100">
                {{ $invoice['kode_reservasi'] ?? 'CITIIS-8923180' }}
            </span>
        </div>

        {{-- DETAIL DATA TRANSAKSI --}}
        <div class="p-5 text-left space-y-3.5 text-xs font-medium text-slate-500">
            <div class="flex justify-between">
                <span>Nama Wisatawan</span>
                <span class="text-slate-800 font-extrabold">Wisandari Citiis</span>
            </div>
            <div class="flex justify-between">
                <span>Destinasi Objek</span>
                <span class="text-slate-800 font-extrabold truncate">Kawasan Wisata Citiis</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal Berlaku</span>
                <span class="text-slate-800 font-extrabold">{{ $invoice['tanggal_kunjungan'] ?? '2026-06-20' }}</span>
            </div>
            <div class="flex justify-between">
                <span>Jumlah Tiket</span>
                <span class="text-slate-800 font-extrabold">{{ $invoice['jumlah_orang'] ?? 1 }} Orang</span>
            </div>
            
            <hr class="border-slate-100 my-2">
            
            <div class="flex justify-between items-baseline">
                <span class="font-bold text-slate-800">Status Pembayaran</span>
                <span class="text-[10px] font-black uppercase text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">LUNAS / PAID</span>
            </div>
        </div>

        {{-- Efek Sobekan Tiket Klasik di Samping Bawah --}}
        <div class="absolute bottom-24 -left-3 w-6 h-6 bg-slate-50 border-r-2 border-slate-200 rounded-full"></div>
        <div class="absolute bottom-24 -right-3 w-6 h-6 bg-slate-50 border-l-2 border-slate-200 rounded-full"></div>
    </div>

    {{-- ACTION BUTTONS --}}
    <div class="mt-6 flex gap-2.5">
        <a href="/user/booking/history" class="flex-1 inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-bold text-xs h-10 rounded-xl shadow-xs hover:bg-slate-50">
            ⬅️ Kembali ke Riwayat
        </a>
        <button onclick="window.print()" class="flex-1 inline-flex items-center justify-center bg-slate-900 text-white font-bold text-xs h-10 rounded-xl shadow-md hover:bg-slate-800">
            🖨️ Cetak / Simpan PDF
        </button>
    </div>
</div>
@endsection