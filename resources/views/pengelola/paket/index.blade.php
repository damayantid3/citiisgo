@extends('layouts.app')
@section('title', 'Paket Camping - Pengelola Citiis')
@section('topbar-title', '🏕️ Paket Camping')

@section('content')
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 font-medium">
    <span class="text-sm">🏕️</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Operasional Lapangan</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Varian Paket Camping</span>
</div>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 w-full">
    <div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">🏕️ Pilihan Paket Camping Citiis</h1>
        <p class="text-sm text-slate-500 font-medium mt-1">Kelola varian paket kemah, kapasitas tenda, fasilitas include, serta tarif sewa per paket.</p>
    </div>
    <div>
        <button onclick="openModal('modalTambahPaket')" class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white font-bold text-xs px-4 h-10 rounded-xl shadow-md hover:bg-emerald-700 active:scale-95 transition-transform cursor-pointer">
            ➕ Tambah Paket Baru
        </button>
    </div>
</div>

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full mb-6">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="px-5 py-4 w-1/3">Nama Paket Camping</th>
                    <th class="px-5 py-4 text-center">Kapasitas Tenda</th>
                    <th class="px-5 py-4">Harga Paket</th>
                    <th class="px-5 py-4 text-center w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($paket ?? [] as $p)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/20 flex items-center justify-center font-bold text-base flex-shrink-0">🏕️</div>
                            <div>
                                <div class="font-bold text-slate-900 text-sm tracking-tight">{{ $p['nama_paket'] ?? $p['nama'] }}</div>
                                <div class="text-slate-400 text-[11px] font-medium mt-0.5 truncate max-w-xs">📋 {{ $p['deskripsi'] ?? 'Tidak ada deskripsi rincian.' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-center font-bold text-slate-800">{{ $p['kapasitas'] }} Orang</td>
                    <td class="px-5 py-3.5 font-bold text-emerald-600 text-sm">Rp {{ number_format($p['harga']) }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <button onclick="confirmDelete({{ $p['id'] }}, '{{ $p['nama_paket'] ?? $p['nama'] }}')" class="w-7 h-7 bg-white border border-rose-200 rounded-lg flex items-center justify-center hover:bg-rose-50 text-rose-600 text-xs shadow-sm active:scale-95 cursor-pointer">🗑️</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-slate-400 font-medium">📭 Belum ada varian paket camping terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalTambahPaket">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">➕ Tambah Paket Camping</h3>
            <button onclick="closeModal('modalTambahPaket')" class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-rose-50 text-slate-400 font-bold flex items-center justify-center text-xs cursor-pointer">✕</button>
        </div>
        <form action="{{ route('pengelola.camping.store') }}" method="POST" class="m-0">
            @csrf
            <div class="p-6 space-y-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Nama Paket <span class="text-rose-600">*</span></label>
                    <input type="text" name="nama_paket" placeholder="Contoh: Paket Keluarga Bahagia 4P" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Kapasitas (Orang) <span class="text-rose-600">*</span></label>
                        <input type="number" name="kapasitas" min="1" placeholder="4" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Harga Paket (Rp) <span class="text-rose-600">*</span></label>
                        <input type="number" name="harga" min="0" placeholder="150000" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
                    </div>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Rincian Fasilitas Include</label>
                    <textarea name="deskripsi" rows="3" placeholder="Contoh: Termasuk tenda, 4 matras, token listrik, dan free air hangat..." class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 resize-none"></textarea>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="closeModal('modalTambahPaket')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-bold text-xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 cursor-pointer">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-bold text-xs px-4 h-9 rounded-xl shadow-md hover:bg-emerald-700 cursor-pointer">💾 Simpan Paket</button>
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
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Paket Camping?',
        text: `Apakah Anda yakin menghapus "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
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