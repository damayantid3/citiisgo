@extends('layouts.app')
@section('title', 'Kelola Wisata - Pengelola Citiis')
@section('topbar-title', '🏔️ Kelola Wisata Saya')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 font-medium">
    <span class="text-sm">🏠</span>
    <a href="{{ route('pengelola.dashboard') }}" class="hover:text-emerald-600 transition-colors">Dashboard</a>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Kelola Wisata</span>
</div>

{{-- ── PAGE HEADER ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 w-full text-left">
    <div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">🏔️ Kelola Data Wisata</h1>
        <p class="text-sm text-slate-500 font-medium mt-1">Perbarui informasi dasar, lokasi peta koordinat, galeri foto, serta fasilitas penunjang wisata.</p>
    </div>
    <div class="flex items-center gap-2.5">
        <button type="button" class="inline-flex items-center justify-center gap-2 border border-slate-200 bg-white text-slate-700 font-bold text-xs px-4 h-10 rounded-xl shadow-sm hover:bg-slate-50 active:scale-95 transition-transform cursor-pointer">
            👁️ Preview Publik
        </button>
        <button type="button" onclick="document.getElementById('formSave').submit()" class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white font-bold text-xs px-4 h-10 rounded-xl shadow-md hover:bg-emerald-700 active:scale-95 transition-transform cursor-pointer">
            💾 Simpan Perubahan
        </button>
    </div>
</div>

@php 
    // Membaca data kiriman dari controller, jika kosong gunakan fallback data default yang aman
    $w = $wisata['data'] ?? $wisata ?? [
        'nama' => 'Kawasan Wisata Alam Citiis',
        'deskripsi' => 'Air terjun indah tersembunyi di antara hijaunya hutan tropis Galunggung Tasikmalaya.',
        'alamat' => 'Kec. Padakembang, Tasikmalaya, Jawa Barat',
        'latitude' => '-7.3842',
        'longitude' => '108.1247',
        'harga_tiket' => 25000,
        'kuota_harian' => 150,
        'status' => 'active'
    ]; 
@endphp

{{-- ── MAIN TWO-COLUMN GRID ── --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full items-start text-left">
    
    {{-- ══════════ KOLI KIRI: FORM INFORMASI UTAMA (7 COLUMNS) ══════════ --}}
    <div class="lg:col-span-7 space-y-6">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">📋 Informasi Dasar</h3>
            </div>
            <div class="p-5">
                <form action="{{ route('pengelola.wisata.update') }}" method="POST" id="formSave" class="space-y-4 m-0">
                    @csrf 
                    @method('PUT')
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Nama Wisata <span class="text-rose-600">*</span></label>
                        <input type="text" name="nama" value="{{ $w['nama'] ?? '' }}" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-colors">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Kategori</label>
                        <select name="kategori_id" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 bg-white transition-colors">
                            <option value="1" selected>🌿 Alam & Tiket Utama</option>
                            <option value="2">🌊 Pantai</option>
                            <option value="3">⛰️ Gunung</option>
                            <option value="4">🏛️ Budaya</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Deskripsi Wisata</label>
                        <textarea name="deskripsi" rows="4" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-colors resize-none">{{ $w['deskripsi'] ?? '' }}</textarea>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Alamat Lengkap</label>
                        <input type="text" name="alamat" value="{{ $w['alamat'] ?? '' }}" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-colors">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-500">Latitude</label>
                            <input type="text" name="latitude" value="{{ $w['latitude'] ?? '' }}" placeholder="-7.3842" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-colors">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-500">Longitude</label>
                            <input type="text" name="longitude" value="{{ $w['longitude'] ?? '' }}" placeholder="108.1247" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-colors">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-500">Harga Tiket Masuk (Rp)</label>
                            <input type="number" name="harga_tiket" value="{{ intval($w['harga_tiket'] ?? 0) }}" min="0" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-colors">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-500">Kuota Harian (Orang)</label>
                            <input type="number" name="kuota_harian" value="{{ $w['kuota_harian'] ?? 100 }}" min="1" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-colors">
                        </div>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Status Operasional Wisata</label>
                        <select name="status" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 bg-white transition-colors">
                            <option value="active" {{ ($w['status'] ?? '') == 'active' ? 'selected' : '' }}>✅ Aktif — Tampil & dapat dipesan online</option>
                            <option value="inactive" {{ ($w['status'] ?? '') == 'inactive' ? 'selected' : '' }}>⏸️ Nonaktif — Tutup / Sembunyikan sementara</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Jam Operasional</label>
                        <div class="flex items-center gap-3">
                            <input type="time" name="jam_buka" value="07:00" class="flex-1 border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-colors">
                            <span class="text-xs font-bold text-slate-400 flex-shrink-0">s/d</span>
                            <input type="time" name="jam_tutup" value="17:00" class="flex-1 border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-colors">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- LOKASI PETA --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-sm">🗺️ Lokasi Peta Geografis</h3>
                <a href="https://www.google.com/maps?q={{ $w['latitude'] ?? 0 }},{{ $w['longitude'] ?? 0 }}" target="_blank" class="text-blue-600 font-bold text-[11px] hover:underline">Buka Google Maps ↗</a>
            </div>
            <div class="p-4">
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-100 rounded-xl h-36 flex flex-col items-center justify-center gap-2 text-center">
                    <span class="text-3xl">📍</span>
                    <span class="font-bold text-slate-800 text-xs">{{ $w['nama'] ?? 'Kawasan Wisata' }}</span>
                    <span class="text-[10px] font-mono text-slate-400 bg-white/80 px-2 py-0.5 rounded-md border border-emerald-100/40">{{ $w['latitude'] ?? '0' }}, {{ $w['longitude'] ?? '0' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════ KOLOM KANAN: GALERI, FASILITAS & ANALITIK (5 COLUMNS) ══════════ --}}
    <div class="lg:col-span-5 space-y-6">
        
        {{-- GALERI FOTO --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-sm">📸 Galeri Foto Kawasan</h3>
                <button type="button" onclick="openModal('modalFoto')" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/30 text-[10px] font-bold px-2.5 py-1 rounded-lg transition-colors cursor-pointer">
                    ➕ Upload Foto
                </button>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-3 gap-2.5">
                    @php 
                        $dummyGaleri = [['🏔️', true], ['💧', false], ['🌿', false], ['🌅', false], ['🏕️', false]];
                        $galeriAsli = $w['galeri'] ?? [];
                    @endphp

                    @foreach($dummyGaleri as [$ico, $cover])
                    <div class="aspect-square rounded-xl border {{ $cover ? 'border-emerald-500 bg-emerald-50/30' : 'border-slate-200 bg-slate-50/50' }} overflow-hidden relative flex items-center justify-center text-2xl group">
                        {{ $ico }}
                        @if($cover)
                            <div class="absolute bottom-1.5 left-1.5 bg-emerald-600 text-white font-black text-[8px] uppercase px-1.5 py-0.5 rounded-md tracking-wider shadow-sm">COVER</div>
                        @endif
                        <form action="{{ route('pengelola.wisata.galeri.delete', ['galeri' => $loop->index + 1]) }}" method="POST" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity m-0">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus foto ini?')" class="w-5 h-5 bg-rose-600 hover:bg-rose-700 text-white text-[10px] flex items-center justify-center rounded-md shadow-sm border-none cursor-pointer">✕</button>
                        </form>
                    </div>
                    @endforeach

                    <div onclick="openModal('modalFoto')" class="aspect-square border-2 border-dashed border-slate-200 rounded-xl flex flex-col items-center justify-center gap-1 text-slate-400 hover:border-emerald-500 hover:text-emerald-600 transition-colors cursor-pointer group">
                        <span class="text-lg group-hover:scale-110 transition-transform">➕</span>
                        <span class="text-[10px] font-bold">Tambah</span>
                    </div>
                </div>
                <div class="text-[10px] text-slate-400 font-medium mt-3 flex items-center gap-1 bg-slate-50 p-2 rounded-lg border border-slate-100">
                    💡 <span class="leading-normal">Foto berlabel <b>COVER</b> akan tampil sebagai gambar utama di aplikasi wisatawan. Maksimal file 4MB.</span>
                </div>
            </div>
        </div>

        {{-- FASILITAS WISATA --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-sm">🏕️ Fasilitas Utama</h3>
                <button type="button" onclick="openModal('modalFasilitas')" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/30 text-[10px] font-bold px-2.5 py-1 rounded-lg transition-colors cursor-pointer">
                    ➕ Atur Fasilitas
                </button>
            </div>
            <div class="p-5">
                <div class="flex flex-wrap gap-1.5" id="fasWrap">
                    @foreach(['🅿️ Parkir', '🚻 Toilet', '🍴 Warung', '📶 WiFi', '🏕️ Area Camp', '🏨 Vila', '🎒 Sewa Alat', '🕌 Mushola'] as $f)
                    <div class="inline-flex items-center gap-1.5 bg-slate-50 text-slate-700 font-bold text-[11px] px-2.5 py-1.5 rounded-xl border border-slate-200/60 shadow-sm">
                        {{ $f }}
                        <span onclick="this.parentElement.remove()" class="text-rose-500 text-xs font-black hover:text-rose-700 cursor-pointer pl-0.5 ml-0.5 border-l border-slate-200/80">×</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- STATISTIK BULANAN --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-sm">📊 Performa Destinasi</h3>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-slate-50 border border-slate-100 p-3 rounded-xl text-center">
                        <div class="text-xl">⭐</div>
                        <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Rating Wisata</div>
                        <div class="text-sm font-extrabold text-slate-800 mt-0.5">4.8 / 5.0</div>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 p-3 rounded-xl text-center">
                        <div class="text-xl">👁️</div>
                        <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Total Dilihat</div>
                        <div class="text-sm font-extrabold text-slate-800 mt-0.5">2,841 Kali</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ─── MODAL: UPLOAD FOTO GALERI ─── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4" id="modalFoto">
    <div class="bg-white rounded-2xl max-w-sm w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-sm">📷 Upload Foto Galeri</h3>
            <button onclick="closeModal('modalFoto')" class="w-6 h-6 rounded-md border border-slate-200 hover:bg-rose-50 text-slate-400 font-bold flex items-center justify-center text-xs cursor-pointer">✕</button>
        </div>
        <form action="{{ route('pengelola.wisata.galeri.upload') }}" method="POST" enctype="multipart/form-data" class="m-0">
            @csrf
            <div class="p-5 space-y-4 text-left">
                <div class="flex flex-col gap-1.5">
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center cursor-pointer bg-slate-50/50 hover:border-emerald-500 transition-colors" onclick="document.getElementById('fotoIn').click()">
                        <span class="text-3xl block mb-1">📁</span>
                        <span class="text-xs font-bold text-slate-600 block">Klik untuk memilih file</span>
                        <span class="text-[10px] text-slate-400 mt-0.5 block">Format JPG, PNG, WebP — Maks 4MB</span>
                    </div>
                    <input type="file" name="foto" id="fotoIn" accept="image/*" class="hidden" onchange="prvFoto(this)">
                    <img id="prvImg" class="hidden w-full h-28 object-cover rounded-xl mt-2 border border-slate-200">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Keterangan Singkat</label>
                    <input type="text" name="keterangan" placeholder="Contoh: Gazebo santai pinggir curug" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
                </div>
                <label class="flex items-center gap-2 bg-emerald-50/60 p-2.5 rounded-xl border border-emerald-100/30 cursor-pointer select-none">
                    <input type="checkbox" name="is_cover" value="1" class="w-4 h-4 accent-emerald-600 cursor-pointer">
                    <span class="text-xs font-bold text-emerald-800">⭐ Jadikan gambar utama (Cover)</span>
                </label>
            </div>
            <div class="flex items-center justify-end gap-2 px-5 py-3 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="closeModal('modalFoto')" class="border border-slate-200 bg-white text-slate-700 font-bold text-xs px-3.5 h-8 rounded-lg shadow-sm hover:bg-slate-50 cursor-pointer">Batal</button>
                <button type="submit" class="bg-emerald-600 text-white font-bold text-xs px-4 h-8 rounded-lg shadow-md hover:bg-emerald-700 cursor-pointer">📤 Mulai Upload</button>
            </div>
        </form>
    </div>
</div>

{{-- ─── MODAL: TAMBAH FASILITAS ─── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4" id="modalFasilitas">
    <div class="bg-white rounded-2xl max-w-xs w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-sm">🏕️ Tambah Fasilitas</h3>
            <button onclick="closeModal('modalFasilitas')" class="w-6 h-6 rounded-md border border-slate-200 hover:bg-rose-50 text-slate-400 font-bold flex items-center justify-center text-xs cursor-pointer">✕</button>
        </div>
        <div class="p-5 space-y-4 text-left">
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500">Pilih Ikon Emoji</label>
                <div class="grid grid-cols-5 gap-1.5 p-2 bg-slate-50 rounded-xl border border-slate-100" id="iconPicker">
                    @foreach(['🅿️','🚻','🍴','📶','🏕️','🏨','🎒','🚑','🕌','♿'] as $ico)
                    <span onclick="selectIcon('{{ $ico }}')" class="ico-pick text-lg w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 bg-white cursor-pointer hover:border-emerald-500 transition-colors">{{ $ico }}</span>
                    @endforeach
                </div>
                <input type="text" id="selIcon" placeholder="Ikon terpilih..." readonly class="w-full border border-slate-200 bg-slate-50/50 rounded-xl px-3 py-2 text-xs font-bold text-center outline-none">
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500">Nama Fasilitas</label>
                <input type="text" id="fasNama" placeholder="Contoh: Spot Foto Ayunan" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
            </div>
        </div>
        <div class="flex items-center justify-end gap-2 px-5 py-3 border-t border-slate-100 bg-slate-50">
            <button type="button" onclick="closeModal('modalFasilitas')" class="border border-slate-200 bg-white text-slate-700 font-bold text-xs px-3.5 h-8 rounded-lg shadow-sm hover:bg-slate-50 cursor-pointer">Batal</button>
            <button type="button" onclick="addFasilitas()" class="bg-emerald-600 text-white font-bold text-xs px-4 h-8 rounded-lg shadow-md hover:bg-emerald-700 cursor-pointer">➕ Tambahkan</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.getElementById(id).classList.add('flex'); }
function closeModal(id) { document.getElementById(id).classList.remove('flex'); document.getElementById(id).classList.add('hidden'); }

function prvFoto(i){
    if(i.files && i.files[0]){
        const r = new FileReader();
        r.onload = e => {
            const img = document.getElementById('prvImg');
            img.src = e.target.result;
            img.classList.remove('hidden');
        };
        r.readAsDataURL(i.files[0]);
    }
}

function selectIcon(ico){
    document.getElementById('selIcon').value = ico;
    document.querySelectorAll('.ico-pick').forEach(e => {
        e.classList.remove('border-emerald-500', 'bg-emerald-50');
    });
    event.target.classList.add('border-emerald-500', 'bg-emerald-50');
}

function addFasilitas(){
    const ico = document.getElementById('selIcon').value || '✅';
    const nama = document.getElementById('fasNama').value.trim();
    if(!nama) return alert('Nama fasilitas wajib diisi!');
    
    const chip = document.createElement('div');
    chip.className = 'inline-flex items-center gap-1.5 bg-slate-50 text-slate-700 font-bold text-[11px] px-2.5 py-1.5 rounded-xl border border-slate-200/60 shadow-sm';
    chip.innerHTML = `${ico} ${nama}<span onclick="this.parentElement.remove()" class="text-rose-500 text-xs font-black hover:text-rose-700 cursor-pointer pl-0.5 ml-0.5 border-l border-slate-200/80">×</span>`;
    
    document.getElementById('fasWrap').appendChild(chip);
    closeModal('modalFasilitas');
    document.getElementById('selIcon').value = '';
    document.getElementById('fasNama').value = '';
}
</script>
@endpush