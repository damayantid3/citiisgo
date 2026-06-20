@extends('layouts.app')
@section('title', 'Jenis Layanan Citiis - Admin')
@section('topbar-title', '🗂️ Jenis Layanan')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 font-medium">
    <span class="text-sm">🏠</span>
    <span class="text-slate-300">/</span>
    <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition-colors">Dashboard</a>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Jenis Layanan</span>
</div>

{{-- ── PAGE HEADER ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 w-full">
    <div class="text-left">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">🗂️ Manajemen Jenis Layanan</h1>
        <p class="text-sm text-slate-500 font-medium mt-1">Standarisasi rumpun kategori produk, fasilitas, dan akomodasi yang tersedia di Kawasan Citiis.</p>
    </div>
    <div class="flex-shrink-0">
        <button onclick="openModal('modalTambahKategori')" class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white font-bold text-xs px-4 h-10 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-all duration-150 cursor-pointer border-none outline-none">
            ➕ Tambah Jenis Layanan
        </button>
    </div>
</div>

{{-- ── DATA TABLE CARD CONTAINER ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full mb-6">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="px-5 py-4 w-1/12">ID</th>
                    <th class="px-5 py-4 w-1/2">Nama Rumpun Layanan</th>
                    <th class="px-5 py-4 w-1/4">Slug Sistem</th>
                    <th class="px-5 py-4 text-center w-1/6">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($kategori ?? [] as $k)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-5 py-3.5 font-mono text-slate-400 font-bold">#{{ $k['id'] }}</td>
                    <td class="px-5 py-3.5 font-bold text-slate-900">
                        <div class="flex items-center gap-2.5">
                            <div class="w-6 h-6 rounded-lg bg-emerald-50 font-bold text-[11px] text-emerald-700 flex items-center justify-center border border-emerald-200/20">
                                📁
                            </div>
                            <span>{{ $k['nama'] }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-500 font-mono">{{ $k['slug'] ?? \Illuminate\Support\Str::slug($k['nama']) }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-center gap-1.5">
                            <button type="button" 
                                    onclick="openEditModal(this)"
                                    data-id="{{ $k['id'] }}"
                                    data-nama="{{ $k['nama'] }}"
                                    class="w-7 h-7 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-50 text-xs shadow-sm active:scale-95 transition-transform cursor-pointer" title="Ubah Nama Kategori">
                                ✏️
                            </button>
                            <button type="button"
                                    onclick="confirmDelete({{ $k['id'] }}, '{{ $k['nama'] }}')"
                                    class="w-7 h-7 bg-white border border-rose-200 rounded-lg flex items-center justify-center hover:bg-rose-50 text-rose-600 text-xs shadow-sm active:scale-95 transition-transform cursor-pointer" title="Hapus Jenis Layanan">
                                🗑️
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-slate-400 font-medium text-xs">
                        📭 Belum ada jenis kategori layanan terdaftar di database.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── MODAL POPUP: TAMBAH KATEGORI ── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalTambahKategori">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">➕ Tambah Jenis Layanan Baru</h3>
            <button onclick="closeModal('modalTambahKategori')" class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-rose-50 hover:text-rose-600 text-slate-400 font-bold flex items-center justify-center text-xs cursor-pointer">✕</button>
        </div>
        <form action="{{ route('admin.kategori.store') }}" method="POST" class="m-0">
            @csrf
            <div class="p-6 space-y-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Nama Rumpun / Jenis Layanan <span class="text-rose-600">*</span></label>
                    <input type="text" name="nama" placeholder="Contoh: Kuliner & Catering, Spot Foto Premium" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-all">
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="closeModal('modalTambahKategori')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-bold text-xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 active:scale-95 transition-transform cursor-pointer">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-bold text-xs px-4 h-9 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-transform cursor-pointer">💾 Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL POPUP: EDIT KATEGORI ── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalEditKategori">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">✏️ Edit Jenis Layanan</h3>
            <button onclick="closeModal('modalEditKategori')" class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-rose-50 hover:text-rose-600 text-slate-400 font-bold flex items-center justify-center text-xs cursor-pointer">✕</button>
        </div>
        <form action="" method="POST" id="formEditKategori" class="m-0">
            @csrf @method('PUT')
            <div class="p-6 space-y-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Ubah Nama Jenis Layanan</label>
                    <input type="text" name="nama" id="edit_nama" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-all">
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="closeModal('modalEditKategori')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-bold text-xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 active:scale-95 transition-transform cursor-pointer">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-bold text-xs px-4 h-9 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-transform cursor-pointer">💾 Update Kategori</button>
            </div>
        </form>
    </div>
</div>

{{-- Hidden Core Delete Form --}}
<form id="deleteKategoriForm" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Menampilkan Popup Sukses Modern dari Session Flash Laravel
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2500,
        customClass: { popup: 'rounded-2xl font-sans text-xs' }
    });
@endif

function openEditModal(button) {
    const id = button.getAttribute('data-id');
    const nama = button.getAttribute('data-nama');

    document.getElementById('edit_nama').value = nama;

    const form = document.getElementById('formEditKategori');
    form.action = "{{ route('admin.kategori.update', ':id') }}".replace(':id', id);

    openModal('modalEditKategori');
}

function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Jenis Layanan?',
        text: `Apakah Anda yakin ingin menghapus "${name}"? Seluruh layanan di bawah rumpun ini akan terpengaruh.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: { popup: 'rounded-2xl font-sans' }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteKategoriForm');
            form.action = '{{ route("admin.kategori.destroy", ":id") }}'.replace(':id', id);
            form.submit();
        }
    });
}

function openModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('hidden'); modal.classList.add('flex');
}

function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('flex'); modal.classList.add('hidden');
}
</script>
@endpush