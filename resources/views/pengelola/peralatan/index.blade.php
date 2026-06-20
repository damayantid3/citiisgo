@extends('layouts.app')
@section('title', 'Manajemen Peralatan Camping - Pengelola Citiis')
@section('topbar-title', '⛺ Inventaris Peralatan Camping')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 font-medium">
    <span class="text-sm">🛠️</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Operasional Lapangan</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Peralatan Camping</span>
</div>

{{-- ── PAGE HEADER ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 w-full">
    <div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">⛺ Gudang Peralatan Camping Citiis</h1>
        <p class="text-sm text-slate-500 font-medium mt-1">Kelola stok fisik peralatan camping, harga sewa satuan, dan ketersediaan unit real-time.</p>
    </div>
    <div>
        <button onclick="openModal('modalTambahPeralatan')" class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white font-bold text-xs px-4 h-10 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-all duration-150 cursor-pointer border-none outline-none">
            ➕ Tambah Aset Peralatan
        </button>
    </div>
</div>

{{-- ── STATS GRID ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden border-t-4 border-t-emerald-600">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Varian Alat</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">{{ count($peralatan ?? []) }} Jenis</div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-4xl opacity-10">📦</div>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden border-t-4 border-t-blue-500">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Unit di Gudang</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">{{ collect($peralatan ?? [])->sum('total_stok') }} Unit</div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-4xl opacity-10">🔢</div>
    </div>
</div>

{{-- ── TABLE CONTAINER CARD ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full mb-6">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="px-5 py-4 w-1/3">Nama Peralatan Camping</th>
                    <th class="px-5 py-4 text-center">Stok Total</th>
                    <th class="px-5 py-4 text-center">Tersedia (Ready)</th>
                    <th class="px-5 py-4">Harga Sewa / Hari</th>
                    <th class="px-5 py-4 text-center w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($peralatan ?? [] as $alat)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200/60 overflow-hidden flex items-center justify-center font-bold text-base text-slate-400 flex-shrink-0">
                                ⛺
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-sm tracking-tight">{{ $alat['nama'] }}</div>
                                <div class="text-slate-400 text-[11px] font-medium mt-0.5 truncate max-w-xs">📝 {{ $alat['deskripsi'] ?? 'Tidak ada info detail' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-center font-bold text-slate-800">{{ $alat['total_stok'] }} Pcs</td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md font-bold {{ $alat['stok_tersedia'] > 0 ? 'bg-green-50 text-green-700' : 'bg-rose-50 text-rose-700' }}">
                            {{ $alat['stok_tersedia'] }} Unit Ready
                        </span>
                    </td>
                    <td class="px-5 py-3.5 font-bold text-emerald-600 text-sm">Rp {{ number_format($alat['harga_sewa_per_hari']) }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                            <button onclick="confirmDelete({{ $alat['id'] }}, '{{ $alat['nama'] }}')" class="w-7 h-7 bg-white border border-rose-200 rounded-lg flex items-center justify-center hover:bg-rose-50 text-rose-600 text-xs shadow-sm active:scale-95 cursor-pointer">🗑️</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-slate-400 font-medium">📭 Gudang kosong. Belum ada aset peralatan camping terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── MODAL POPUP: TAMBAH PERALATAN ── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalTambahPeralatan">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">➕ Daftarkan Peralatan Baru</h3>
            <button onclick="closeModal('modalTambahPeralatan')" class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-rose-50 text-slate-400 font-bold flex items-center justify-center text-xs cursor-pointer">✕</button>
        </div>
        <form action="{{ route('pengelola.peralatan.store') }}" method="POST" class="m-0">
            @csrf
            <div class="p-6 space-y-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Nama Barang / Peralatan <span class="text-rose-600">*</span></label>
                    <input type="text" name="nama" placeholder="Contoh: Tenda Borneo 4 Orang" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Jumlah Stok Total <span class="text-rose-600">*</span></label>
                        <input type="number" name="total_stok" min="1" placeholder="Contoh: 30" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Harga Sewa / Hari (Rp) <span class="text-rose-600">*</span></label>
                        <input type="number" name="harga_sewa_per_hari" min="0" placeholder="Contoh: 25000" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
                    </div>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Informasi Singkat Spesifikasi Alat</label>
                    <textarea name="deskripsi" rows="3" placeholder="Sebutkan detail spesifikasi barang..." class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 resize-none"></textarea>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="closeModal('modalTambahPeralatan')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-bold text-xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 cursor-pointer">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-bold text-xs px-4 h-9 rounded-xl shadow-md hover:bg-emerald-700 cursor-pointer">💾 Simpan Aset</button>
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

function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Peralatan?',
        text: `Apakah Anda yakin ingin menghapus "${name}" dari gudang?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: { popup: 'rounded-2xl font-sans' }
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