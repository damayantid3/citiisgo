@extends('layouts.app')
@section('title', 'Kelola Wahana Wisata - CitiisGo')
@section('topbar-title', '🏞️ Pengelolaan Profil Wahana / Objek Wisata')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-[10px] text-slate-400 mb-5 font-semibold">
    <a href="{{ route('pengelola.dashboard') }}" class="hover:text-emerald-600 transition-colors">🏠 Dashboard Mitra</a>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Kelola Wahana</span>
</div>

{{-- ── NOTIFIKASI FLASHDATA ── --}}
@if(session('success'))
<div class="mb-5 bg-emerald-50 border border-emerald-200/80 px-5 py-4 rounded-xl text-[11px] font-bold text-emerald-800 shadow-sm flex items-center gap-3">
    <span>✅</span> <div>{{ session('success') }}</div>
</div>
@endif

@if($errors->any())
<div class="mb-5 bg-rose-50 border border-rose-200/80 px-5 py-4 rounded-xl text-[11px] font-bold text-rose-800 shadow-sm flex items-center gap-3">
    <span>❌</span> 
    <div>
        <ul class="list-disc pl-4 space-y-0.5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    {{-- ── FORM EDIT PROFIL WISATA ── --}}
    <div class="xl:col-span-2 bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden h-fit flex flex-col">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
    <h3 class="text-xs font-black text-slate-800 tracking-tight">Galeri Foto Wahana</h3>
    <p class="text-[10px] text-slate-500 font-medium mt-0.5">Lampirkan foto pendukung untuk daya tarik visual pengunjung.</p>
</div>
        {{-- Form wajib menggunakan method POST dan overriding @method('PUT') --}}
        <form action="{{ route('pengelola.wisata.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="p-6 space-y-4 text-2xs font-semibold text-slate-600 flex-1">
                <div class="flex flex-col gap-1.5">
                    <label class="font-bold text-[11px] text-slate-500">Nama Wahana / Objek Wisata</label>
                    <input type="text" name="nama" value="{{ old('nama', $wisata['nama'] ?? '') }}" required class="border border-slate-200 rounded-xl px-3 py-2 outline-none focus:border-emerald-600 text-xs text-slate-700 font-medium">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-[11px] text-slate-500">Tarif / Harga Tiket Masuk (Rp)</label>
                        <input type="number" name="harga_tiket" value="{{ old('harga_tiket', $wisata['harga_tiket'] ?? '') }}" required class="border border-slate-200 rounded-xl px-3 py-2 outline-none focus:border-emerald-600 text-xs text-slate-700 font-medium">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-[11px] text-slate-500">Kapasitas Pengunjung / Kuota Harian</label>
                        <input type="number" name="kapasitas" value="{{ old('kapasitas', $wisata['kapasitas'] ?? '') }}" required class="border border-slate-200 rounded-xl px-3 py-2 outline-none focus:border-emerald-600 text-xs text-slate-700 font-medium">
                    </div>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="font-bold text-[11px] text-slate-500">Deskripsi Lengkap Objek</label>
                    <textarea name="deskripsi" rows="4" required class="border border-slate-200 rounded-xl px-3 py-2 outline-none focus:border-emerald-600 text-xs text-slate-700 font-medium resize-none leading-relaxed">{{ old('deskripsi', $wisata['deskripsi'] ?? '') }}</textarea>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="font-bold text-[11px] text-slate-500">Ubah Foto Utama / Banner</label>
                    <input type="file" name="foto" class="border border-slate-200 rounded-xl px-3 py-1.5 outline-none text-[11px] file:border-0 file:bg-slate-100 file:text-slate-700 file:text-[10px] file:font-black file:px-3 file:py-1.5 file:rounded-lg file:mr-3 cursor-pointer">
                    @if(!empty($wisata['foto']))
                        <div class="mt-2">
                            <span class="text-[9px] text-slate-400 font-bold block mb-1">Foto Saat Ini:</span>
                            <img src="{{ $wisata['foto'] }}" class="w-32 h-20 object-cover rounded-xl border border-slate-200 shadow-sm" alt="Foto Wisata">
                        </div>
                    @endif
                </div>
            </div>
            <div class="px-6 py-3.5 border-t border-slate-100 bg-slate-50 flex justify-end">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[11px] px-4 h-9 rounded-xl shadow-sm active:scale-95 transition-transform cursor-pointer border-none outline-none">💾 Simpan Perubahan Properti</button>
            </div>
        </form>
    </div>

    {{-- ── KELOLA GALERI FOTO TAMBAHAN ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden h-fit flex flex-col">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
        <h3 class="text-xs font-black text-slate-800 tracking-tight">Galeri Foto Wahana</h3>
        <p class="text-[10px] text-slate-500 font-medium mt-0.5">Lampirkan foto pendukung untuk daya tarik visual pengunjung.</p>
    </div>
    
    <div class="p-6 space-y-5 flex-1 flex flex-col justify-between">
        {{-- Form Upload Galeri Terisolasi secara mutlak dari form utama --}}
        <form action="{{ route('pengelola.wisata.galeri.upload') }}" method="POST" enctype="multipart/form-data" class="bg-slate-50 border border-dashed border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center gap-2.5 text-center w-full">
            @csrf
            <svg class="w-7 h-7 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <path d="M21 15l-5-5L5 21"></path>
            </svg>
            <span class="text-[10px] font-black text-slate-500 tracking-wide text-center">Tambahkan foto baru ke galeri wahana</span>
            <input type="file" name="image" required class="text-[9px] file:border-0 file:bg-white file:text-slate-600 file:font-black file:px-3 file:py-1.5 file:rounded-lg cursor-pointer max-w-[200px] mt-1">
            <button type="submit" class="bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-[10px] font-black px-4 h-8 rounded-xl shadow-sm active:scale-95 transition-transform cursor-pointer mt-1.5">➕ Unggah Foto</button>
        </form>

        {{-- Grid Tampilan Galeri --}}
        <div>
            <span class="text-2xs font-black text-slate-700 block mb-3">Daftar Foto Terlampir</span>
            <div class="grid grid-cols-2 gap-3">
                @forelse($wisata['galeri'] ?? [] as $gl)
                <div class="group relative aspect-video rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                    {{-- ⚡ Tautan Base URL API Base (port 8000) disematkan secara mutlak merespons URL/Path aktual --}}
                    @php
                        $imgUrl = !empty($gl['url_foto']) 
                            ? (Str::startsWith($gl['url_foto'], 'http') ? $gl['url_foto'] : 'http://127.0.0.1:8000/storage/' . ltrim($gl['url_foto'], '/'))
                            : 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=300';
                    @endphp
                    <img src="{{ $imgUrl }}" class="w-full h-full object-cover" alt="Galeri Wahana">
                    
                    <form action="{{ route('pengelola.wisata.galeri.delete', $gl['id']) }}" method="POST" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus foto galeri ini?')" class="w-6 h-6 bg-rose-600 text-white rounded-lg text-3xs flex items-center justify-center cursor-pointer border-none outline-none shadow-sm" title="Hapus Gambar">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </form>
                </div>
                @empty
                <div class="col-span-2 py-6 text-center border border-dashed border-slate-100 rounded-xl text-3xs font-semibold text-slate-400">Belum ada foto galeri wahana.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2300,
        customClass: { popup: 'rounded-2xl font-sans text-xs' }
    });
@endif

@if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Terjadi Kesalahan',
        text: "Pastikan semua isian data tervalidasi dengan benar.",
        customClass: { popup: 'rounded-2xl font-sans text-xs' }
    });
@endif
</script>
@endpush