@extends('layouts.app')
@section('title', 'Pengaturan Utama - Admin CitiisGo')
@section('topbar-title', '⚙️ Konfigurasi Pengaturan Platform')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-[10px] text-slate-400 mb-5 font-semibold">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">🏠 Dashboard Audit</a>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Sistem Konfigurasi</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Pengaturan Utama</span>
</div>

{{-- ── NOTIFIKASI FLASHDATA ── --}}
@if(session('success'))
<div class="mb-5 bg-emerald-50 border border-emerald-200/80 px-5 py-4 rounded-xl text-[11px] font-bold text-emerald-800 shadow-sm flex items-center gap-3">
    <span>✅</span> <div>{{ session('success') }}</div>
</div>
@endif

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden max-w-2xl">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
        <h3 class="text-xs font-black text-slate-800 tracking-tight">Identitas & Konfigurasi Sistem</h3>
        <p class="text-[10px] text-slate-500 font-medium mt-0.5">Perbarui informasi, kontak, dan alamat layanan sentral platform CitiisGo.</p>
    </div>
    <form action="{{ route('admin.sistem.pengaturan.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="p-6 space-y-4 text-2xs font-semibold text-slate-600">
            <div class="flex flex-col gap-1.5">
                <label class="font-bold text-slate-500">Nama Platform / Aplikasi</label>
                <input type="text" name="nama_aplikasi" value="{{ old('nama_aplikasi', $pengaturan['nama_aplikasi'] ?? '') }}" required class="border border-slate-200 rounded-xl px-3 py-2 outline-none focus:border-emerald-600 text-xs text-slate-700 font-medium">
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="font-bold text-slate-500">Kontak Layanan Bantuan (WhatsApp / Telepon)</label>
                <input type="text" name="kontak_layanan" value="{{ old('kontak_layanan', $pengaturan['kontak_layanan'] ?? '') }}" required class="border border-slate-200 rounded-xl px-3 py-2 outline-none focus:border-emerald-600 text-xs text-slate-700 font-medium">
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="font-bold text-slate-500">Alamat Surel (Email) Pusat</label>
                <input type="email" name="email_pusat" value="{{ old('email_pusat', $pengaturan['email_pusat'] ?? '') }}" required class="border border-slate-200 rounded-xl px-3 py-2 outline-none focus:border-emerald-600 text-xs text-slate-700 font-medium">
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="font-bold text-slate-500">Alamat Kantor / Lokasi Sekretariat Pusat</label>
                <textarea name="alamat_kantor" rows="3" required class="border border-slate-200 rounded-xl px-3 py-2 outline-none focus:border-emerald-600 text-xs text-slate-700 font-medium resize-none">{{ old('alamat_kantor', $pengaturan['alamat_kantor'] ?? '') }}</textarea>
            </div>
        </div>
        <div class="px-6 py-3.5 border-t border-slate-100 bg-slate-50 flex justify-end">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs px-4 h-9 rounded-xl shadow-sm active:scale-95 transition-transform cursor-pointer border-none outline-none">💾 Simpan Perubahan Konfigurasi</button>
        </div>
    </form>
</div>
@endsection