@extends('layouts.app')
@section('title', 'Manajemen Peralatan Camping - Pengelola Citiis')
@section('topbar-title', '⛺ Inventaris Peralatan Camping')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-[10px] text-slate-400 mb-5 font-semibold">
    <span class="text-[9px]">🏠</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Operasional Lapangan</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Peralatan Camping</span>
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

{{-- ── PAGE HEADER ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 w-full">
    <div>
        <h1 class="text-base font-extrabold tracking-tight text-slate-800">Gudang Peralatan Camping Citiis</h1>
        <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Kelola stok fisik peralatan camping, harga sewa satuan, ketersediaan unit real-time, serta visual barang.</p>
    </div>
    <div>
        <button onclick="openModal('modalTambahPeralatan')" class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white font-black text-[11px] px-4 h-9 rounded-xl shadow-sm hover:bg-emerald-700 active:scale-95 transition-all cursor-pointer border-none outline-none">
            ➕ Tambah Aset Peralatan
        </button>
    </div>
</div>

{{-- ── STATS GRID ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden border-l-4 border-l-emerald-600 flex flex-col justify-between h-20">
        <div>
            <div class="text-[9px] font-black uppercase tracking-widest text-slate-400">Total Varian Alat</div>
            <div class="text-base font-extrabold text-slate-800 mt-1 tracking-tight">{{ count($peralatan ?? []) }} Jenis</div>
        </div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 opacity-10">
            <svg class="w-8 h-8 stroke-current text-slate-600" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline></svg>
        </div>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden border-l-4 border-l-blue-600 flex flex-col justify-between h-20">
        <div>
            <div class="text-[9px] font-black uppercase tracking-widest text-slate-400">Total Unit di Gudang</div>
            <div class="text-base font-extrabold text-slate-800 mt-1 tracking-tight">{{ collect($peralatan ?? [])->sum('total_stok') }} Unit</div>
        </div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 opacity-10">
            <svg class="w-8 h-8 stroke-current text-slate-600" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><line x1="12" y1="6" x2="12" y2="18"></line><line x1="6" y1="12" x2="18" y2="12"></line></svg>
        </div>
    </div>
</div>

{{-- ── TABLE CONTAINER CARD ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full mb-6">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-3xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[9px]">
                    <th class="px-6 py-3.5 w-1/3">Nama Peralatan Camping</th>
                    <th class="px-6 py-3.5 text-center">Visual / Foto</th>
                    <th class="px-6 py-3.5 text-center">Stok Total</th>
                    <th class="px-6 py-3.5 text-center">Tersedia (Ready)</th>
                    <th class="px-6 py-3.5">Harga Sewa / Hari</th>
                    <th class="px-6 py-3.5 text-center w-36">Aksi (Kelola)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-2xs">
                @forelse($peralatan ?? [] as $alat)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-6 py-3.5 align-middle">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-slate-50 border border-slate-200/60 overflow-hidden flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 stroke-current text-slate-500" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4 0 5 1 8 0 4-1 4-1V3s-1 1-4 0-5-1-8 0-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="font-black text-xs tracking-tight text-slate-800 truncate">{{ $alat['nama'] ?? 'Peralatan' }}</div>
                                <div class="text-slate-400 text-[9px] font-bold mt-0.5 truncate max-w-xs uppercase tracking-wider">Detil Spesifikasi: {{ $alat['deskripsi'] ?? '—' }}</div>
                            </div>
                        </div>
                    </td>
                    {{-- ⚡ TAMPILAN VISUAL FOTO ABSOLUT PORT 8000 --}}
                    <td class="px-6 py-3.5 text-center align-middle">
                        @if(!empty($alat['foto']))
                            <img src="http://127.0.0.1:8000/storage/{{ $alat['foto'] }}" alt="Foto {{ $alat['nama'] }}" class="w-12 h-12 object-cover rounded-xl border border-slate-200 shadow-sm mx-auto">
                        @else
                            <span class="text-[9px] text-slate-400 font-bold bg-slate-50 px-2.5 py-1.5 rounded-lg border border-slate-100">Belum ada</span>
                        @endif
                    </td>
                    <td class="px-6 py-3.5 text-center font-extrabold text-slate-700 align-middle">{{ $alat['total_stok'] ?? 0 }} Pcs</td>
                    <td class="px-6 py-3.5 text-center align-middle">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg font-black text-[9px] uppercase tracking-wider border {{ ($alat['stok_tersedia'] ?? 0) > 0 ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-rose-50 text-rose-700 border-rose-100' }}">
                            {{ $alat['stok_tersedia'] ?? 0 }} Unit Ready
                        </span>
                    </td>
                    <td class="px-6 py-3.5 font-extrabold text-emerald-700 text-2xs tracking-tight align-middle">Rp {{ number_format($alat['harga_sewa_per_hari'] ?? 0) }}</td>
                    <td class="px-6 py-3.5 text-center align-middle">
                        <div class="flex items-center justify-center gap-1.5">
                            {{-- ⚡ Tombol Edit --}}
                            <button onclick="openEditModal({{ json_encode($alat) }})" class="w-7 h-7 bg-white border border-slate-200 rounded-xl flex items-center justify-center hover:bg-slate-50 text-slate-600 text-xs shadow-sm active:scale-95 cursor-pointer border-none outline-none">
                                ✏️
                            </button>
                            {{-- ⚡ Tombol Hapus --}}
                            <button onclick="confirmDelete({{ $alat['id'] }}, '{{ $alat['nama'] }}')" class="w-7 h-7 bg-white border border-rose-200 rounded-xl flex items-center justify-center hover:bg-rose-50 text-rose-600 text-xs shadow-sm active:scale-95 cursor-pointer outline-none border-none">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-2 14H7L5 6"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-bold text-2xs">
                        📭 Gudang kosong. Belum ada aset peralatan camping terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── MODAL POPUP: TAMBAH PERALATAN ── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalTambahPeralatan">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 sticky top-0 bg-white z-10">
            <h3 class="font-black text-slate-800 text-xs tracking-tight">➕ Daftarkan Peralatan Baru</h3>
            <button onclick="closeModal('modalTambahPeralatan')" class="w-7 h-7 rounded-xl border border-slate-200 hover:bg-rose-50 text-slate-400 font-black flex items-center justify-center text-xs cursor-pointer border-none outline-none">✕</button>
        </div>
        <form action="{{ route('pengelola.peralatan.store') }}" method="POST" enctype="multipart/form-data" class="m-0">
            @csrf
            <div class="p-6 space-y-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Nama Barang / Peralatan <span class="text-rose-600">*</span></label>
                    <input type="text" name="nama" placeholder="Contoh: Tenda Borneo 4 Orang" required class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Jumlah Stok Total <span class="text-rose-600">*</span></label>
                        <input type="number" name="total_stok" min="1" placeholder="Contoh: 30" required class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Harga Sewa / Hari (Rp) <span class="text-rose-600">*</span></label>
                        <input type="number" name="harga_sewa_per_hari" min="0" placeholder="Contoh: 25000" required class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700">
                    </div>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Informasi Singkat Spesifikasi Alat</label>
                    <textarea name="deskripsi" rows="3" placeholder="Sebutkan detail spesifikasi barang..." class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700 resize-none"></textarea>
                </div>
                {{-- ⚡ INPUT FOTO ALAT --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Foto / Visual Banner Alat <span class="text-emerald-600 font-normal">(Opsional)</span></label>
                    <input type="file" name="foto" class="w-full h-10 rounded-xl border border-slate-200 px-3 py-1.5 text-2xs font-bold text-slate-600 focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-3xs file:font-black file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer shadow-sm" accept="image/png, image/jpeg, image/jpg">
                    <p class="text-[9px] text-slate-400 font-bold mt-1">Format: JPEG, PNG, JPG (Maksimal 2MB).</p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="closeModal('modalTambahPeralatan')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-black text-2xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 cursor-pointer outline-none">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-black text-2xs px-4 h-9 rounded-xl shadow-sm hover:bg-emerald-700 cursor-pointer border-none outline-none">💾 Simpan Aset</button>
            </div>
        </form>
    </div>
</div>

{{-- ⚡ MODAL POPUP: EDIT PERALATAN --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalEditPeralatan">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 sticky top-0 bg-white z-10">
            <h3 class="font-black text-slate-800 text-xs tracking-tight">✏️ Edit Data Peralatan</h3>
            <button onclick="closeModal('modalEditPeralatan')" class="w-7 h-7 rounded-xl border border-slate-200 hover:bg-rose-50 text-slate-400 font-black flex items-center justify-center text-xs cursor-pointer border-none outline-none">✕</button>
        </div>
        <form id="formEditPeralatan" method="POST" enctype="multipart/form-data" class="m-0">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Nama Barang / Peralatan <span class="text-rose-600">*</span></label>
                    <input type="text" id="edit_nama" name="nama" required class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Jumlah Stok Total <span class="text-rose-600">*</span></label>
                        <input type="number" id="edit_total_stok" name="total_stok" min="1" required class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Harga Sewa / Hari (Rp) <span class="text-rose-600">*</span></label>
                        <input type="number" id="edit_harga_sewa" name="harga_sewa_per_hari" min="0" required class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700">
                    </div>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Informasi Singkat Spesifikasi Alat</label>
                    <textarea id="edit_deskripsi" name="deskripsi" rows="3" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700 resize-none"></textarea>
                </div>
                {{-- ⚡ PRATINJAU FOTO & GANTI FOTO --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Pratinjau Foto Saat Ini</label>
                    <div id="wrapperPreviewFoto" class="mb-2 hidden">
                        <img id="previewFoto" src="" alt="Foto Alat" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shadow-sm">
                    </div>
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Ganti Foto Baru <span class="text-emerald-600 font-normal">(Opsional)</span></label>
                    <input type="file" name="foto" class="w-full h-10 rounded-xl border border-slate-200 px-3 py-1.5 text-2xs font-bold text-slate-600 focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-3xs file:font-black file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer shadow-sm" accept="image/png, image/jpeg, image/jpg">
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="closeModal('modalEditPeralatan')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-black text-2xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 cursor-pointer outline-none">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-black text-2xs px-4 h-9 rounded-xl shadow-sm hover:bg-emerald-700 cursor-pointer border-none outline-none">💾 Perbarui Aset</button>
            </div>
        </form>
    </div>
</div>

<form id="deletePeralatanForm" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>
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

// ⚡ FUNGSI MEMBUKA MODAL EDIT
function openEditModal(item) {
    document.getElementById('edit_nama').value = item.nama || '';
    document.getElementById('edit_total_stok').value = item.total_stok || '';
    document.getElementById('edit_harga_sewa').value = item.harga_sewa_per_hari || '';
    document.getElementById('edit_deskripsi').value = item.deskripsi || '';

    const wrapperPreview = document.getElementById('wrapperPreviewFoto');
    const previewImg = document.getElementById('previewFoto');

    // PENGECIAKAN ABSOLUT KE ALAMAT PORT 8000
    if (item.foto) {
        previewImg.src = 'http://127.0.0.1:8000/storage/' + item.foto;
        wrapperPreview.classList.remove('hidden');
    } else {
        wrapperPreview.classList.add('hidden');
    }

    document.getElementById('formEditPeralatan').action = '{{ route("pengelola.peralatan.update", ":id") }}'.replace(':id', item.id);
    openModal('modalEditPeralatan');
}

function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Peralatan?',
        text: `Apakah Anda yakin ingin menghapus "${name}" dari gudang?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: { popup: 'rounded-2xl font-sans text-2xs font-bold' }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deletePeralatanForm');
            form.action = '{{ route("pengelola.peralatan.destroy", ":id") }}'.replace(':id', id);
            form.submit();
        }
    });
}

function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.getElementById(id).classList.add('flex');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('flex');
    document.getElementById(id).classList.add('hidden');
}
</script>
@endpush