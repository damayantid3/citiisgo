@extends('layouts.app')
@section('title', 'Paket Camping - Pengelola Citiis')
@section('topbar-title', '🏕️ Varian Paket Camping Area')

@section('content')
<div class="flex items-center gap-2 text-[10px] text-slate-400 mb-5 font-semibold">
    <span class="text-[9px]">🏠</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Operasional Lapangan</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Varian Paket Camping</span>
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

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 w-full">
    <div>
        <h1 class="text-base font-extrabold tracking-tight text-slate-800">Pilihan Paket Camping Area</h1>
        <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Kelola varian paket kemah, kapasitas tenda, fasilitas include, tarif sewa, serta visual produk secara akurat.</p>
    </div>
    <div>
        <button onclick="openModal('modalTambahPaket')" class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white font-black text-[11px] px-4 h-9 rounded-xl shadow-sm hover:bg-emerald-700 active:scale-95 transition-all cursor-pointer border-none outline-none">
            ➕ Tambah Paket Baru
        </button>
    </div>
</div>

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full mb-6">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-3xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[9px]">
                    <th class="px-6 py-3.5 w-1/3">Nama Paket Camping</th>
                    <th class="px-6 py-3.5 text-center">Visual / Foto</th>
                    <th class="px-6 py-3.5 text-center">Kapasitas Tenda</th>
                    <th class="px-6 py-3.5">Harga Paket</th>
                    <th class="px-6 py-3.5 text-center w-36">Aksi (Kelola)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-2xs">
                @forelse($paket ?? [] as $p)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 stroke-current" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4 0 5 1 8 0 4-1 4-1V3s-1 1-4 0-5-1-8 0-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="font-black text-xs tracking-tight text-slate-800 truncate">{{ $p['nama_paket'] ?? 'Paket Kamping' }}</div>
                                <div class="text-slate-400 text-[9px] font-bold mt-0.5 truncate max-w-xs uppercase tracking-wider">Fasilitas: {{ $p['deskripsi'] ?? '—' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3.5 text-center align-middle">
                        {{-- ⚡ TAMPILAN ABSOLUT KE PORT 8000 (Menyelesaikan Error Foto Tidak Muncul) --}}
                        @if(!empty($p['foto']))
                            <img src="http://127.0.0.1:8000/storage/{{ $p['foto'] }}" 
                                 alt="Foto {{ $p['nama_paket'] }}" 
                                 class="w-16 h-16 object-cover rounded-xl border border-slate-200 shadow-sm mx-auto mb-2">
                        @else
                            <span class="text-[10px] text-slate-400 font-bold bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100 block mb-3 uppercase tracking-wider">
                                Belum ada
                            </span>
                        @endif
                        
                        {{-- ⚡ FITUR UNGGAH ULANG / GANTI FOTO LEWAT TABEL --}}
                        <button onclick="openEditModal({{ json_encode($p) }})" class="inline-flex items-center justify-center gap-1.5 text-[10px] font-bold text-slate-700 bg-white border border-slate-200 px-3 py-2 rounded-xl hover:bg-slate-50 active:scale-95 transition-all shadow-sm cursor-pointer outline-none">
                            🔄 Ganti Foto
                        </button>
                    </td>
                    <td class="px-6 py-3.5 text-center font-extrabold text-slate-700 tracking-tight">{{ $p['kapasitas_tamu'] ?? 0 }} Orang</td>
                    <td class="px-6 py-3.5 font-black text-emerald-700 tracking-tight text-2xs">Rp {{ number_format($p['harga_per_malam'] ?? 0) }}</td>
                    <td class="px-6 py-3.5 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                            {{-- ⚡ Tombol Edit (Memicu Modal Edit) --}}
                            <button onclick="openEditModal({{ json_encode($p) }})" class="w-7 h-7 bg-white border border-slate-200 rounded-xl flex items-center justify-center hover:bg-slate-50 text-slate-600 text-xs shadow-sm active:scale-95 cursor-pointer border-none outline-none">
                                ✏️
                            </button>
                            {{-- ⚡ Tombol Hapus --}}
                            <button onclick="confirmDelete({{ $p['id'] }}, '{{ $p['nama_paket'] ?? 'Paket' }}')" class="w-7 h-7 bg-white border border-rose-200 rounded-xl flex items-center justify-center hover:bg-rose-50 text-rose-600 text-xs shadow-sm active:scale-95 cursor-pointer border-none outline-none">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-2 14H7L5 6"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-bold text-2xs">
                        📭 Belum ada varian paket camping terdaftar untuk wahana ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalTambahPaket">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 sticky top-0 bg-white z-10">
            <h3 class="font-black text-slate-800 text-xs tracking-tight">➕ Tambah Paket Camping Baru</h3>
            <button onclick="closeModal('modalTambahPaket')" class="w-7 h-7 rounded-xl border border-slate-200 hover:bg-rose-50 text-slate-400 font-black flex items-center justify-center text-xs cursor-pointer border-none outline-none">✕</button>
        </div>
        
        <form action="{{ route('pengelola.camping.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-2xs font-semibold text-slate-600">
            @csrf
            
            <div>
                <label class="block mb-1 text-3xs font-bold text-slate-700 tracking-wider uppercase">Nama Paket Camping <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_paket" class="w-full h-9 rounded-xl border border-slate-200 px-3 text-2xs font-bold text-slate-700 focus:outline-none focus:border-emerald-500 shadow-sm" placeholder="Contoh: Paket Keluarga Cemara" required>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block mb-1 text-3xs font-bold text-slate-700 tracking-wider uppercase">Kapasitas (Tamu) <span class="text-rose-500">*</span></label>
                    <input type="number" name="kapasitas" class="w-full h-9 rounded-xl border border-slate-200 px-3 text-2xs font-bold text-slate-700 focus:outline-none focus:border-emerald-500 shadow-sm" min="1" placeholder="Misal: 4" required>
                </div>
                <div>
                    <label class="block mb-1 text-3xs font-bold text-slate-700 tracking-wider uppercase">Total Slot / Unit Tenda <span class="text-rose-500">*</span></label>
                    <input type="number" name="total_slot" class="w-full h-9 rounded-xl border border-slate-200 px-3 text-2xs font-bold text-slate-700 focus:outline-none focus:border-emerald-500 shadow-sm" min="1" placeholder="Misal: 15" required>
                </div>
            </div>

            <div>
                <label class="block mb-1 text-3xs font-bold text-slate-700 tracking-wider uppercase">Tarif Sewa per Malam <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 font-bold">Rp</span>
                    <input type="number" name="harga" class="w-full h-9 rounded-xl border border-slate-200 pl-10 pr-3 text-2xs font-bold text-slate-700 focus:outline-none focus:border-emerald-500 shadow-sm" min="0" placeholder="0" required>
                </div>
            </div>

            <div>
                <label class="block mb-1 text-3xs font-bold text-slate-700 tracking-wider uppercase">Fasilitas Termasuk / Deskripsi</label>
                <textarea name="deskripsi" class="w-full rounded-xl border border-slate-200 p-3 text-2xs font-bold text-slate-700 focus:outline-none focus:border-emerald-500 shadow-sm" rows="3" placeholder="Sebutkan perlengkapan yang didapat, matras, sleeping bag, dll.."></textarea>
            </div>

            <div>
                <label class="block mb-1 text-3xs font-bold text-slate-700 tracking-wider uppercase">Foto / Visual Banner Paket <span class="text-emerald-600 font-normal">(Opsional)</span></label>
                <input type="file" name="foto" class="w-full h-10 rounded-xl border border-slate-200 px-3 py-1.5 text-2xs font-bold text-slate-600 focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-3xs file:font-black file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer shadow-sm" accept="image/png, image/jpeg, image/jpg">
                <p class="text-[9px] text-slate-400 font-bold mt-1">Format: JPEG, PNG, JPG (Maksimal 2MB).</p>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalTambahPaket')" class="h-9 px-4 rounded-xl border border-slate-200 text-slate-600 font-black text-3xs hover:bg-slate-50 active:scale-95 transition-all cursor-pointer">Batal</button>
                <button type="submit" class="h-9 px-5 rounded-xl bg-emerald-600 text-white font-black text-3xs shadow-sm hover:bg-emerald-700 active:scale-95 transition-all cursor-pointer border-none outline-none">Simpan Paket</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT (PEMBARUAN DATA) --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalEditPaket">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 sticky top-0 bg-white z-10">
            <h3 class="font-black text-slate-800 text-xs tracking-tight">✏️ Edit Paket Camping</h3>
            <button onclick="closeModal('modalEditPaket')" class="w-7 h-7 rounded-xl border border-slate-200 hover:bg-rose-50 text-slate-400 font-black flex items-center justify-center text-xs cursor-pointer border-none outline-none">✕</button>
        </div>
        
        <form id="formEditPaket" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-2xs font-semibold text-slate-600">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block mb-1 text-3xs font-bold text-slate-700 tracking-wider uppercase">Nama Paket Camping <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_nama_paket" name="nama_paket" class="w-full h-9 rounded-xl border border-slate-200 px-3 text-2xs font-bold text-slate-700 focus:outline-none focus:border-emerald-500 shadow-sm" required>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block mb-1 text-3xs font-bold text-slate-700 tracking-wider uppercase">Kapasitas (Tamu) <span class="text-rose-500">*</span></label>
                    <input type="number" id="edit_kapasitas" name="kapasitas" class="w-full h-9 rounded-xl border border-slate-200 px-3 text-2xs font-bold text-slate-700 focus:outline-none focus:border-emerald-500 shadow-sm" min="1" required>
                </div>
                <div>
                    <label class="block mb-1 text-3xs font-bold text-slate-700 tracking-wider uppercase">Total Slot / Unit <span class="text-rose-500">*</span></label>
                    <input type="number" id="edit_total_slot" name="total_slot" class="w-full h-9 rounded-xl border border-slate-200 px-3 text-2xs font-bold text-slate-700 focus:outline-none focus:border-emerald-500 shadow-sm" min="1" required>
                </div>
            </div>

            <div>
                <label class="block mb-1 text-3xs font-bold text-slate-700 tracking-wider uppercase">Tarif Sewa per Malam <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 font-bold">Rp</span>
                    <input type="number" id="edit_harga" name="harga" class="w-full h-9 rounded-xl border border-slate-200 pl-10 pr-3 text-2xs font-bold text-slate-700 focus:outline-none focus:border-emerald-500 shadow-sm" min="0" required>
                </div>
            </div>

            <div>
                <label class="block mb-1 text-3xs font-bold text-slate-700 tracking-wider uppercase">Fasilitas Termasuk / Deskripsi</label>
                <textarea id="edit_deskripsi" name="deskripsi" class="w-full rounded-xl border border-slate-200 p-3 text-2xs font-bold text-slate-700 focus:outline-none focus:border-emerald-500 shadow-sm" rows="3"></textarea>
            </div>

            <div>
                <label class="block mb-1 text-3xs font-bold text-slate-700 tracking-wider uppercase">Pratinjau Foto Saat Ini</label>
                <div id="wrapperPreviewFoto" class="mb-2 hidden">
                    {{-- ⚡ TAMPILAN ABSOLUT PRATINJAU KE PORT 8000 --}}
                    <img id="previewFoto" src="" alt="Foto Paket" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shadow-sm">
                </div>
                <label class="block mb-1 text-3xs font-bold text-slate-600">Ganti Foto Baru <span class="text-emerald-600 font-normal">(Opsional)</span></label>
                <input type="file" name="foto" class="w-full h-10 rounded-xl border border-slate-200 px-3 py-1.5 text-2xs font-bold text-slate-600 focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-3xs file:font-black file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer shadow-sm" accept="image/png, image/jpeg, image/jpg">
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalEditPaket')" class="h-9 px-4 rounded-xl border border-slate-200 text-slate-600 font-black text-3xs hover:bg-slate-50 active:scale-95 transition-all cursor-pointer">Batal</button>
                <button type="submit" class="h-9 px-5 rounded-xl bg-emerald-600 text-white font-black text-3xs shadow-sm hover:bg-emerald-700 active:scale-95 transition-all cursor-pointer border-none outline-none">Perbarui Paket</button>
            </div>
        </form>
    </div>
</div>

<form id="deletePaketForm" method="POST" class="hidden">
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

// ⚡ Fungsi Membuka Modal Edit dan Memasukkan Data Awal secara Absolut
function openEditModal(item) {
    document.getElementById('edit_nama_paket').value = item.nama_paket || '';
    document.getElementById('edit_kapasitas').value = item.kapasitas_tamu || ''; 
    document.getElementById('edit_harga').value = item.harga_per_malam || ''; 
    document.getElementById('edit_total_slot').value = item.total_slot || '';
    document.getElementById('edit_deskripsi').value = item.deskripsi || '';

    const wrapperPreview = document.getElementById('wrapperPreviewFoto');
    const previewImg = document.getElementById('previewFoto');
    
    // ⚡ PENGECIAKAN FOTO LANGSUNG KE ALAMAT PORT 8000
    if (item.foto) {
        previewImg.src = 'http://127.0.0.1:8000/storage/' + item.foto;
        wrapperPreview.classList.remove('hidden');
    } else {
        wrapperPreview.classList.add('hidden');
    }

    const updateRoute = '{{ route("pengelola.camping.update", ":id") }}'.replace(':id', item.id);
    document.getElementById('formEditPaket').action = updateRoute;

    openModal('modalEditPaket');
}

function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Paket Camping?',
        text: `Apakah Anda yakin menghapus "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: { popup: 'rounded-2xl font-sans text-2xs font-black' }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deletePaketForm');
            form.action = '{{ route("pengelola.camping.destroy", ":id") }}'.replace(':id', id);
            form.submit();
        }
    });
}
function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.getElementById(id).classList.add('flex'); }
function closeModal(id) { document.getElementById(id).classList.remove('flex'); document.getElementById(id).classList.add('hidden'); }
</script>
@endpush