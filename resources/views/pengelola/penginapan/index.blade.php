@extends('layouts.app')
@section('title', 'Manajemen Penginapan - Pengelola Citiis')
@section('topbar-title', '🏡 Manajemen Penginapan')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 font-medium">
    <span class="text-sm">🏡</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Operasional Lapangan</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Daftar Penginapan</span>
</div>

{{-- ── PAGE HEADER ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 w-full">
    <div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">🏡 Manajemen Unit Penginapan</h1>
        <p class="text-sm text-slate-500 font-medium mt-1">Kelola data villa, homestay, atau area glamping eksklusif yang tersedia di Kawasan Wisata Citiis.</p>
    </div>
    <div>
        <button onclick="openModal('modalTambahPenginapan')" class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white font-bold text-xs px-4 h-10 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-all duration-150 cursor-pointer border-none outline-none">
            ➕ Daftarkan Properti Penginapan
        </button>
    </div>
</div>

{{-- ── TABLE CONTAINER CARD ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full mb-6">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="px-5 py-4 w-1/12">ID Unit</th>
                    <th class="px-5 py-4 w-1/3">Nama Properti / Kamar</th>
                    <th class="px-5 py-4 w-1/3">Lokasi / Alamat Properti</th>
                    <th class="px-5 py-4 text-center w-28">Status Keaktifan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($penginapan ?? [] as $item)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-5 py-3.5 font-mono text-slate-400 font-bold">#{{ $item['id'] }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200/60 overflow-hidden flex items-center justify-center font-bold text-lg text-slate-400 flex-shrink-0">
                                🏡
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-sm tracking-tight">{{ $item['nama'] }}</div>
                                <div class="text-slate-400 text-[11px] font-medium mt-0.5 truncate max-w-xs">📝 {{ $item['deskripsi'] ?? 'Tidak ada deskripsi fasilitas.' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 font-medium">{{ $item['alamat'] ?? 'Kawasan Utama Citiis Galunggung' }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/40 text-[10px]">
                            ● Siap Disewa
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-slate-400 font-medium">📭 Belum ada properti penginapan terdaftar di database.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── MODAL POPUP: TAMBAH PENGINAPAN ── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalTambahPenginapan">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">🏡 Daftarkan Penginapan Baru</h3>
            <button onclick="closeModal('modalTambahPenginapan')" class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-rose-50 text-slate-400 font-bold flex items-center justify-center text-xs cursor-pointer">✕</button>
        </div>
        <form action="{{ route('pengelola.penginapan.store') }}" method="POST" class="m-0">
            @csrf
            <div class="p-6 space-y-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Nama Properti / Tipe Penginapan <span class="text-rose-600">*</span></label>
                    <input type="text" name="nama" placeholder="Contoh: Cottage Kayu Mini Alam #01" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Alamat Internal / Blok Area</label>
                    <input type="text" name="alamat" placeholder="Contoh: Zona Atas Dekat Kolam Air Hangat" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Detail Fasilitas Penginapan</label>
                    <textarea name="deskripsi" rows="3" placeholder="Contoh: Kapasitas 4 orang, include kasur bantal, toilet dalam..." class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 resize-none"></textarea>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="closeModal('modalTambahPenginapan')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-bold text-xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 cursor-pointer">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-bold text-xs px-4 h-9 rounded-xl shadow-md hover:bg-emerald-700 cursor-pointer">💾 Simpan Kamar / Villa</button>
            </div>
        </form>
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