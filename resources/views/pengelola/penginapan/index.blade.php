@extends('layouts.app')
@section('title', 'Manajemen Penginapan - Pengelola Citiis')
@section('topbar-title', '🏡 Manajemen Properti Penginapan')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-[10px] text-slate-400 mb-5 font-semibold">
    <span class="text-[9px]">🏠</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Operasional Lapangan</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Daftar Penginapan</span>
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
        <h1 class="text-base font-extrabold tracking-tight text-slate-800">Manajemen Unit Penginapan</h1>
        <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Kelola data villa, homestay, atau area glamping eksklusif yang tersedia di Kawasan Wisata Citiis.</p>
    </div>
    <div>
        <button onclick="openModal('modalTambahPenginapan')" class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white font-black text-[11px] px-4 h-9 rounded-xl shadow-sm hover:bg-emerald-700 active:scale-95 transition-all cursor-pointer border-none outline-none">
            ➕ Daftarkan Properti Penginapan
        </button>
    </div>
</div>

{{-- ── TABLE CONTAINER CARD ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full mb-6">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-3xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[9px]">
                    <th class="px-6 py-3.5 w-1/12">ID Unit</th>
                    <th class="px-6 py-3.5 w-2/5">Nama Properti / Kamar</th>
                    <th class="px-6 py-3.5 text-center">Visual / Foto</th>
                    <th class="px-6 py-3.5 w-1/3">Lokasi / Alamat Properti</th>
                    <th class="px-6 py-3.5 text-center w-28">Status Keaktifan</th>
                    <th class="px-6 py-3.5 text-center w-28">Aksi (Kelola)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-2xs">
                @forelse($penginapan ?? [] as $item)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-6 py-3.5 font-mono text-slate-400 font-black align-middle">#{{ $item['id'] }}</td>
                    <td class="px-6 py-3.5 align-middle">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-200/60 overflow-hidden flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 stroke-current text-slate-500" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="font-black text-xs tracking-tight text-slate-800 truncate">{{ $item['nama'] }}</div>
                                <div class="text-slate-400 text-[9px] font-bold mt-0.5 truncate max-w-xs uppercase tracking-wider">Fasilitas: {{ $item['deskripsi'] ?? '—' }}</div>
                            </div>
                        </div>
                    </td>
                    {{-- ⚡ TAMPILAN ABSOLUT VISUAL FOTO DARI PORT 8000 --}}
                    <td class="px-6 py-3.5 text-center align-middle">
                        @if(!empty($item['foto_cover']))
                            <img src="http://127.0.0.1:8000/storage/{{ $item['foto_cover'] }}" alt="Foto {{ $item['nama'] }}" class="w-12 h-12 object-cover rounded-xl border border-slate-200 shadow-sm mx-auto">
                        @else
                            <span class="text-[9px] text-slate-400 font-bold bg-slate-50 px-2.5 py-1.5 rounded-lg border border-slate-100">Belum ada</span>
                        @endif
                    </td>
                    <td class="px-6 py-3.5 text-slate-700 font-black tracking-tight align-middle">{{ $item['alamat'] ?? 'Kawasan Utama Citiis Galunggung' }}</td>
                    <td class="px-6 py-3.5 text-center align-middle">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-xl font-black bg-emerald-50 text-emerald-700 border border-emerald-100 text-[9px] uppercase tracking-wider">
                            ● Siap Disewa
                        </span>
                    </td>
                    <td class="px-6 py-3.5 text-center align-middle">
                        <div class="flex items-center justify-center gap-1.5">
                            <button onclick="openEditModal({{ json_encode($item) }})" class="w-7 h-7 bg-white border border-slate-200 rounded-xl flex items-center justify-center hover:bg-slate-50 text-slate-600 text-xs shadow-sm active:scale-95 cursor-pointer border-none outline-none">
                                ✏️
                            </button>
                            <button onclick="confirmDelete({{ $item['id'] }}, '{{ $item['nama'] }}')" class="w-7 h-7 bg-white border border-rose-200 rounded-xl flex items-center justify-center hover:bg-rose-50 text-rose-600 text-xs shadow-sm active:scale-95 cursor-pointer border-none outline-none">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-2 14H7L5 6"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-bold text-2xs">
                        📭 Belum ada properti penginapan terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── MODAL TAMBAH PROPERTI ── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalTambahPenginapan">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 sticky top-0 bg-white z-10">
            <h3 class="font-black text-slate-800 text-xs tracking-tight">🏡 Daftarkan Penginapan Baru</h3>
            <button onclick="closeModal('modalTambahPenginapan')" class="w-7 h-7 rounded-xl border border-slate-200 hover:bg-rose-50 text-slate-400 font-black flex items-center justify-center text-xs cursor-pointer border-none outline-none">✕</button>
        </div>
        <form action="{{ route('pengelola.penginapan.store') }}" method="POST" enctype="multipart/form-data" class="m-0">
            @csrf
            <div class="p-6 space-y-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Nama Properti / Tipe Penginapan <span class="text-rose-600">*</span></label>
                    <input type="text" name="nama" placeholder="Contoh: Cottage Kayu Mini Alam #01" required class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Alamat Internal / Blok Area</label>
                    <input type="text" name="alamat" placeholder="Contoh: Zona Atas Dekat Kolam Air Hangat" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Detail Fasilitas Penginapan</label>
                    <textarea name="deskripsi" rows="3" placeholder="Contoh: Kapasitas 4 orang, include kasur bantal, toilet dalam..." class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700 resize-none"></textarea>
                </div>
                {{-- ⚡ INPUT FILE GAMBAR COVER --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Foto Cover Visual Penginapan <span class="text-emerald-600 font-normal">(Opsional)</span></label>
                    <input type="file" name="foto_cover" class="w-full h-10 rounded-xl border border-slate-200 px-3 py-1.5 text-2xs font-bold text-slate-600 focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-3xs file:font-black file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer shadow-sm" accept="image/png, image/jpeg, image/jpg">
                    <p class="text-[9px] text-slate-400 font-bold">Format: JPEG, PNG, JPG (Maksimal 2MB).</p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="closeModal('modalTambahPenginapan')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-black text-2xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 cursor-pointer outline-none">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-black text-2xs px-4 h-9 rounded-xl shadow-sm hover:bg-emerald-700 cursor-pointer border-none outline-none">💾 Simpan Kamar / Villa</button>
            </div>
        </form>
    </div>
</div>

{{-- ⚡ MODAL POPUP: EDIT PROPERTI PENGINAPAN --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalEditPenginapan">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 sticky top-0 bg-white z-10">
            <h3 class="font-black text-slate-800 text-xs tracking-tight">✏️ Edit Properti Penginapan</h3>
            <button onclick="closeModal('modalEditPenginapan')" class="w-7 h-7 rounded-xl border border-slate-200 hover:bg-rose-50 text-slate-400 font-black flex items-center justify-center text-xs cursor-pointer border-none outline-none">✕</button>
        </div>
        <form id="formEditPenginapan" method="POST" enctype="multipart/form-data" class="m-0">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Nama Properti / Tipe Penginapan <span class="text-rose-600">*</span></label>
                    <input type="text" id="edit_nama" name="nama" required class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Alamat Internal / Blok Area</label>
                    <input type="text" id="edit_alamat" name="alamat" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Detail Fasilitas Penginapan</label>
                    <textarea id="edit_deskripsi" name="deskripsi" rows="3" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-2xs font-bold outline-none focus:border-emerald-500 text-slate-700 resize-none"></textarea>
                </div>
                {{-- ⚡ PRATINJAU & GANTI FOTO --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Pratinjau Foto Cover</label>
                    <div id="wrapperPreviewFoto" class="mb-2 hidden">
                        <img id="previewFoto" src="" alt="Foto Cover" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shadow-sm">
                    </div>
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-500">Ganti Foto Cover Baru <span class="text-emerald-600 font-normal">(Opsional)</span></label>
                    <input type="file" name="foto_cover" class="w-full h-10 rounded-xl border border-slate-200 px-3 py-1.5 text-2xs font-bold text-slate-600 focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-3xs file:font-black file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer shadow-sm" accept="image/png, image/jpeg, image/jpg">
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="closeModal('modalEditPenginapan')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-black text-2xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 cursor-pointer outline-none">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-black text-2xs px-4 h-9 rounded-xl shadow-sm hover:bg-emerald-700 cursor-pointer border-none outline-none">💾 Perbarui Properti</button>
            </div>
        </form>
    </div>
</div>

<form id="deletePenginapanForm" method="POST" class="hidden">
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
        customClass: { popup: 'rounded-2xl font-sans text-xs font-black' }
    });
@endif

// ⚡ FUNGSI MEMBUKA MODAL EDIT & PENGISIAN RUTE DINAMISNYA
function openEditModal(item) {
    document.getElementById('edit_nama').value = item.nama || '';
    document.getElementById('edit_alamat').value = item.alamat || '';
    document.getElementById('edit_deskripsi').value = item.deskripsi || '';

    const wrapperPreview = document.getElementById('wrapperPreviewFoto');
    const previewImg = document.getElementById('previewFoto');

    if (item.foto_cover) {
        previewImg.src = 'http://127.0.0.1:8000/storage/' + item.foto_cover;
        wrapperPreview.classList.remove('hidden');
    } else {
        wrapperPreview.classList.add('hidden');
    }

    document.getElementById('formEditPenginapan').action = '/pengelola/penginapan/' + item.id;
    openModal('modalEditPenginapan');
}

function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Unit Penginapan?',
        text: `Apakah Anda yakin menghapus properti "${name}" dari sistem?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: { popup: 'rounded-2xl font-sans text-2xs font-black' }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deletePenginapanForm');
            form.action = '/pengelola/penginapan/' + id;
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