@extends('layouts.app')
@section('title', 'Manajemen Layanan & Paket - CitiisGo')
@section('topbar-title', '⚙️ Layanan & Paket Citiis')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 font-medium">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">🏠 Dashboard</a>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Layanan & Paket</span>
</div>

{{-- ── PAGE HEADER ── --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">📦 Layanan & Paket Wisata Citiis</h1>
        <p class="text-sm text-slate-500 font-medium mt-1">Kelola tiket masuk, wahana permainan, akomodasi, sewa alat, hingga paket bundling hemat.</p>
    </div>
    <div class="flex items-center gap-2.5 self-end lg:self-auto">
        <button onclick="openAddModal()" class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white font-bold text-xs px-4 h-10 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-all duration-150 cursor-pointer border-none outline-none">
            ➕ Tambah Layanan / Paket
        </button>
    </div>
</div>

{{-- ── DYNAMIC STATS GRID ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden group border-t-4 border-t-emerald-600">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Layanan</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">{{ count($wisatas ?? []) }}</div>
        <div class="text-xs text-slate-500 font-medium">Aktif terdaftar di server pusat</div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-4xl opacity-10">📦</div>
    </div>
</div>

{{-- ── DATA CONTAINER CARD (BLADE ARRAY) ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-6">
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 bg-slate-50/50">
        <h3 class="text-sm font-bold text-slate-800">Daftar Katalog Produk & Layanan Citiis</h3>
        <div class="inline-flex border border-slate-200 bg-slate-100 rounded-xl p-0.5 shadow-inner">
            <button id="btnGrid" onclick="setView('grid')" class="px-3 py-1 text-xs font-bold rounded-lg transition-all duration-150 text-slate-500 hover:text-slate-700 cursor-pointer">⊞ Grid</button>
            <button id="btnList" onclick="setView('list')" class="px-3 py-1 text-xs font-bold rounded-lg transition-all duration-150 bg-white text-emerald-700 shadow-sm border border-slate-200/50 cursor-pointer">☰ List</button>
        </div>
    </div>
    
    <div class="p-4 border-b border-slate-100 bg-white">
        <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 h-9 flex-1 sm:max-w-xs focus-within:border-emerald-500 focus-within:bg-white transition-all duration-150">
                <span class="text-slate-400 text-sm">🔍</span>
                <input id="search-bar-array" type="text" placeholder="Pencarian katalog asinkron..." class="bg-transparent border-none outline-none text-xs text-slate-700 w-full font-medium">
            </div>
            <div class="text-[10px] font-bold text-slate-400">Penyelarasan integrasi database dari server peladen API.</div>
        </div>
    </div>

    {{-- 📋 VIEW TYPE A: DATA TABLE (LIST VIEW) --}}
    <div id="viewList" class="block">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs font-medium">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                        <th class="px-5 py-3">Nama Layanan / Paket Produk</th>
                        <th class="px-5 py-3">Jenis Kategori</th>
                        <th class="px-5 py-3">Tarif / Harga</th>
                        <th class="px-5 py-3">Batas Kuota</th>
                        <th class="px-5 py-3 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($wisatas ?? [] as $item)
                    <tr class="hover:bg-slate-50/60 transition-colors group/row">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                @php
                                    $fotoPath = $item['foto'] ?? null;
                                    $foto = $item['foto_url'] ?? ($fotoPath ? (str_starts_with($fotoPath, 'http') ? $fotoPath : 'http://127.0.0.1:8000/storage/' . $fotoPath) : 'https://images.unsplash.com/photo-1544161515-4ab6ce6bab34?w=800&q=80');
                                    $itemArr = array_merge($item, ['foto_url' => $foto]);
                                @endphp
                                <img src="{{ $foto }}" class="w-10 h-10 object-cover rounded-xl border border-slate-100 shadow-sm bg-slate-50 flex-shrink-0" alt="{{ $item['nama'] }}">
                                <div class="min-w-0">
                                    <div class="font-extrabold text-slate-900 text-sm tracking-tight truncate">{{ $item['nama'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-slate-100 text-slate-600 border border-slate-200/50">
                                {{ is_array($item['kategori']) ? ($item['kategori']['nama'] ?? 'Umum') : ($item['kategori'] ?? 'Umum') }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 font-black text-emerald-700 text-sm">Rp {{ number_format($item['harga_tiket'], 0, ',', '.') }}</td>
                        <td class="px-5 py-3.5 font-extrabold text-slate-600 text-xs">{{ $item['kuota_harian'] ?? '-' }} Slot/Hari</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-center gap-1.5">
                                <button onclick="viewDetailModal({{ json_encode($itemArr) }})" class="w-7 h-7 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-[10px] flex items-center justify-center shadow-sm active:scale-95 transition-transform cursor-pointer" title="Lihat Spesifikasi">👁️</button>
                                <button onclick="viewEditModal({{ json_encode($itemArr) }})" class="w-7 h-7 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-[10px] flex items-center justify-center shadow-sm active:scale-95 transition-transform cursor-pointer" title="Ubah Spesifikasi">✏️</button>
                                <form action="{{ route('admin.wisata.destroy', $item['id']) }}" method="POST" class="inline-block m-0 p-0" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-7 h-7 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-[10px] flex items-center justify-center shadow-sm active:scale-95 transition-transform cursor-pointer" title="Hapus Produk">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-slate-400 font-medium">
                            <i class="fa-solid fa-ban text-2xl text-slate-300 mb-2 block"></i> Belum ada data layanan terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 🗂️ VIEW TYPE B: RESPONSIVE GRID VIEW --}}
    <div id="viewGrid" class="hidden p-5 bg-slate-50/50">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($wisatas ?? [] as $item)
             @php
                $fotoPathG = $item['foto'] ?? null;
                $fotoG = $item['foto_url'] ?? ($fotoPathG ? (str_starts_with($fotoPathG, 'http') ? $fotoPathG : 'http://127.0.0.1:8000/storage/' . $fotoPathG) : 'https://images.unsplash.com/photo-1544161515-4ab6ce6bab34?w=800&q=80');
                $itemArrG = array_merge($item, ['foto_url' => $fotoG]);
            @endphp
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-200 group flex flex-col">
                <div class="h-32 bg-emerald-50 relative overflow-hidden">
                    <img src="{{ $fotoG }}" alt="{{ $item['nama'] }}" class="w-full h-full object-cover">
                </div>
                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-xs tracking-tight truncate group-hover:text-emerald-700 transition-colors">{{ $item['nama'] }}</h4>
                        <p class="text-[10px] text-slate-400 font-extrabold uppercase mt-0.5 tracking-wider">🏷️ {{ is_array($item['kategori']) ? ($item['kategori']['nama'] ?? 'Umum') : ($item['kategori'] ?? 'Umum') }}</p>
                        <div class="flex items-center justify-between border-y border-slate-100 py-1.5 my-3">
                            <span class="font-black text-emerald-700 text-xs">Rp {{ number_format($item['harga_tiket'], 0, ',', '.') }}</span>
                            <span class="font-bold text-[10px] text-slate-500">{{ $item['kuota_harian'] ?? '-' }} Kuota</span>
                        </div>
                    </div>
                    <div class="flex gap-2 w-full mt-1">
                        <button onclick="viewDetailModal({{ json_encode($itemArrG) }})" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-700 font-extrabold text-[10px] h-8 rounded-xl border border-slate-200 active:scale-95 transition-transform cursor-pointer">👁️ Detail</button>
                        <button onclick="viewEditModal({{ json_encode($itemArrG) }})" class="w-8 h-8 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl flex items-center justify-center text-[10px] active:scale-95 transition-transform cursor-pointer">✏️</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ── MODAL: TAMBAH LAYANAN BARU ── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalTambahWisata">
    <div class="bg-white rounded-2xl max-w-2xl w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">📦 Tambah Layanan / Paket Baru</h3>
            <button onclick="toggleModal('modalTambahWisata')" class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-rose-50 hover:text-rose-600 font-bold transition-all flex items-center justify-center text-xs cursor-pointer">✕</button>
        </div>
        <form action="{{ route('admin.wisata.store') }}" method="POST" enctype="multipart/form-data" class="m-0">
            @csrf
            <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Nama Layanan / Paket <span class="text-rose-600">*</span></label>
                        <input name="nama" type="text" placeholder="Contoh: Tiket Wahana / Paket Camping" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-all">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Jenis Layanan (Kategori) <span class="text-rose-600">*</span></label>
                        {{-- 💡 Langsung menembak port Backend API 8000 secara mutlak --}}
                        <select name="kategori_id" id="tambah_kategori_id" required class="w-full border border-slate-200 bg-white rounded-xl px-3 py-2 text-xs font-semibold outline-none focus:border-emerald-500 transition-all cursor-pointer">
                            <option value="">Memuat Kategori...</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Harga Jual / Tarif (Rp) <span class="text-rose-600">*</span></label>
                        <input name="harga_tiket" type="number" placeholder="Contoh: 15000" min="0" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Batas Kuota Harian (Orang/Unit) <span class="text-rose-600">*</span></label>
                        <input name="kuota_harian" type="number" placeholder="Batas kapasitas tampung order" min="1" step="1" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Unggah Foto / Gambar Utama <span class="text-[10px] text-slate-400 font-normal">(Opsional)</span></label>
                        <input class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-extrabold file:bg-emerald-50 file:text-brand-green file:cursor-pointer hover:file:bg-emerald-100" 
                               type="file" name="foto" accept="image/*">
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Detail Fasilitas & Deskripsi Paket <span class="text-[10px] text-slate-400 font-normal">(Opsional)</span></label>
                    <textarea name="deskripsi" rows="3" placeholder="Sebutkan fasilitas yang didapat pengunjung secara detail..." class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 resize-none"></textarea>
                </div>
                
                <input type="hidden" name="status" value="active">
                <input type="hidden" name="alamat" value="Area Kawasan Wisata Citiis Galunggung">
            </div>
            <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="toggleModal('modalTambahWisata')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-bold text-xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 active:scale-95 transition-transform cursor-pointer">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-bold text-xs px-4 h-9 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-transform cursor-pointer">💾 Simpan Item</button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL: DETAIL LAYANAN ── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalDetailWisata">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">👁️ Detail Spesifikasi Layanan</h3>
            <button onclick="toggleModal('modalDetailWisata')" class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-rose-50 hover:text-rose-600 font-bold flex items-center justify-center text-xs cursor-pointer">✕</button>
        </div>
        <div class="p-6 space-y-4">
            <div class="bg-gradient-to-r from-emerald-700 to-teal-800 rounded-2xl p-4 flex items-center gap-3.5 text-white shadow-md">
                <img id="detail_foto" src="" class="w-16 h-16 object-cover rounded-xl border border-white/20 shadow-sm bg-emerald-900/40" alt="Foto Wisata">
                <div>
                    <h4 id="detail_nama" class="font-extrabold text-base tracking-tight">—</h4>
                    <p id="detail_kategori" class="text-xs text-white/70 font-medium mt-0.5">—</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Tarif / Harga Jual</div>
                    <div id="detail_harga" class="font-bold text-emerald-700 text-xs mt-1">—</div>
                </div>
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Batas Kuota Order</div>
                    <div id="detail_kuota" class="font-bold text-slate-800 text-xs mt-1">—</div>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Fasilitas & Deskripsi</label>
                <div id="detail_deskripsi" class="bg-slate-50 border border-slate-100 rounded-xl p-3 text-xs font-medium text-slate-600 leading-relaxed max-h-36 overflow-y-auto custom-scrollbar">-</div>
            </div>
        </div>
        <div class="flex items-center justify-end px-6 py-3.5 border-t border-slate-100 bg-slate-50">
            <button type="button" onclick="toggleModal('modalDetailWisata')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-bold text-xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 active:scale-95 transition-transform cursor-pointer">Tutup</button>
        </div>
    </div>
</div>

{{-- ── MODAL: EDIT LAYANAN ── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalEditWisata">
    <div class="bg-white rounded-2xl max-w-xl w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">✏️ Edit Informasi Katalog</h3>
            <button onclick="toggleModal('modalEditWisata')" class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-rose-50 hover:text-rose-600 font-bold flex items-center justify-center text-xs cursor-pointer">✕</button>
        </div>
        <form action="" method="POST" id="formEditWisataAdmin" enctype="multipart/form-data" class="m-0">
            @csrf @method('PUT')
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <input type="hidden" id="edit_id" name="id">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Nama Layanan / Paket</label>
                        <input name="nama" id="edit_nama" type="text" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-all">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Jenis Kategori</label>
                        <select name="kategori_id" id="edit_kategori" class="w-full border border-slate-200 bg-white rounded-xl px-3 py-2 text-xs font-semibold outline-none focus:border-emerald-500 cursor-pointer">
                            <option value="">-- Pilih Jenis Kategori --</option>
                            @foreach($kategori_options ?? [] as $kat)
                                <option value="{{ is_array($kat) ? ($kat['id'] ?? '') : ($kat->id ?? '') }}">
                                    {{ is_array($kat) ? ($kat['nama'] ?? '') : ($kat->nama ?? '') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Harga / Tarif Jual (Rp)</label>
                        <input name="harga_tiket" id="edit_harga" type="number" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Batas Kuota Harian (Orang/Unit)</label>
                        <input name="kuota_harian" id="edit_kuota" type="number" min="1" step="1" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Ganti Foto Gambar <span class="text-[10px] text-slate-400 font-normal">(Opsional)</span></label>
                        <input class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-extrabold file:bg-emerald-50 file:text-brand-green file:cursor-pointer hover:file:bg-emerald-100" 
                               type="file" name="foto" accept="image/*">
                    </div>
                </div>
                
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Detail Cakupan Fasilitas <span class="text-[10px] text-slate-400 font-normal">(Opsional)</span></label>
                    <textarea name="deskripsi" id="edit_deskripsi" rows="3" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 resize-none"></textarea>
                </div>
                
                <input type="hidden" name="alamat" value="Kawasan Wisata Pemandian Air Panas Citiis Galunggung">
                <input type="hidden" name="status" value="active">
            </div>
            <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="toggleModal('modalEditWisata')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-bold text-xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 active:scale-95 transition-transform cursor-pointer">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-bold text-xs px-4 h-9 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-transform cursor-pointer">💾 Update Item</button>
            </div>
        </form>
    </div>
</div>

<form id="deleteWisataForm" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}",
            showConfirmButton: false, timer: 2500, customClass: { popup: 'rounded-2xl font-sans text-xs' }
        });
    @endif
    @if(session('error'))
        Swal.fire({
            icon: 'error', title: 'Gagal!', text: "{{ session('error') }}",
            customClass: { popup: 'rounded-2xl font-sans text-xs' }
        });
    @endif

    function setView(v) {
        const listWrap = document.getElementById('viewList');
        const gridWrap = document.getElementById('viewGrid');
        const bGrid = document.getElementById('btnGrid');
        const bList = document.getElementById('btnList');

        if (v === 'list') {
            listWrap.classList.remove('hidden'); listWrap.classList.add('block');
            gridWrap.classList.remove('block'); gridWrap.classList.add('hidden');
            bList.className = "px-3 py-1 text-xs font-bold rounded-lg bg-white text-emerald-700 shadow-sm border border-slate-200/50 cursor-pointer";
            bGrid.className = "px-3 py-1 text-xs font-bold rounded-lg text-slate-500 hover:text-slate-700 cursor-pointer";
        } else {
            gridWrap.classList.remove('hidden'); gridWrap.classList.add('block');
            listWrap.classList.remove('block'); listWrap.classList.add('hidden');
            bGrid.className = "px-3 py-1 text-xs font-bold rounded-lg bg-white text-emerald-700 shadow-sm border border-slate-200/50 cursor-pointer";
            bList.className = "px-3 py-1 text-xs font-bold rounded-lg text-slate-500 hover:text-slate-700 cursor-pointer";
        }
    }

    function viewDetailModal(item) {
        document.getElementById('detail_foto').src = item.foto_url || 'https://images.unsplash.com/photo-1544161515-4ab6ce6bab34?w=800&q=80';
        document.getElementById('detail_nama').textContent = item.nama;
        document.getElementById('detail_kategori').textContent = `🏷️ Kategori: ${item.kategori?.nama ?? (item.kategori ?? 'Umum')}`;
        document.getElementById('detail_harga').textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.harga_tiket);
        document.getElementById('detail_kuota').textContent = `${item.kuota_harian ?? 'Tidak terbatas'} slot / hari`;
        document.getElementById('detail_deskripsi').textContent = item.deskripsi ?? 'Fasilitas tidak dispesifikasikan.';
        
        toggleModal('modalDetailWisata');
    }

    // 💡 Diperbaiki: Menembak peladen pusat (port 8000) secara absolut agar tidak 404/gagal
    async function openAddModal() {
        try {
            const response = await fetch('http://127.0.0.1:8000/api/v1/kategori'); 
            const result = await response.json();
            
            const selectEl = document.getElementById('tambah_kategori_id');
            if (selectEl) {
                selectEl.innerHTML = '<option value="">-- Pilih Jenis Layanan --</option>';
                
                const dataKategori = Array.isArray(result) ? result : (result.data || []);
                
                if (dataKategori.length > 0) {
                    dataKategori.forEach(kat => {
                        selectEl.innerHTML += `<option value="${kat.id}">${kat.nama}</option>`;
                    });
                } else {
                    selectEl.innerHTML = '<option value="">Kategori belum tersedia</option>';
                }
            }
        } catch(err) {
            console.error("Gagal menarik opsi kategori:", err);
            const selectEl = document.getElementById('tambah_kategori_id');
            if(selectEl) selectEl.innerHTML = '<option value="">Gagal memuat kategori</option>';
        }
        
        toggleModal('modalTambahWisata');
    }

    function viewEditModal(item) {
        document.getElementById('edit_id').value = item.id;
        document.getElementById('edit_nama').value = item.nama;
        document.getElementById('edit_harga').value = item.harga_tiket;
        document.getElementById('edit_kuota').value = item.kuota_harian;
        document.getElementById('edit_deskripsi').value = item.deskripsi ?? '';

        const editKategoriSelect = document.getElementById('edit_kategori');
        const katId = item.kategori_id || item['kategori_id'] || (item.kategori ? (item.kategori.id || item.kategori['id']) : '');
        
        if(editKategoriSelect && katId) {
            editKategoriSelect.value = katId;
        }

        const form = document.getElementById('formEditWisataAdmin');
        form.action = "{{ route('admin.wisata.update', ':id') }}".replace(':id', item.id);

        toggleModal('modalEditWisata');
    }

    function hapusWisata(id, nama) {
        Swal.fire({
            title: 'Hapus Item Katalog?', text: `Apakah Anda yakin ingin menghapus permanen destinasi wisata "${nama}"?`,
            icon: 'warning', showCancelButton: true, confirmButtonColor: '#e11d48', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal', customClass: { popup: 'rounded-2xl font-sans text-xs' }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteWisataForm');
                form.action = "{{ route('admin.wisata.destroy', ':id') }}".replace(':id', id);
                form.submit();
            }
        })
    }

    function toggleModal(id) {
        const modal = document.getElementById(id);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden'); modal.classList.add('flex');
        } else {
            modal.classList.remove('flex'); modal.classList.add('hidden');
        }
    }
</script>
@endpush