@extends('layouts.app')
@section('title', 'Verifikasi Pembayaran - CitiisGo')
@section('topbar-title', '💳 Validasi Pembayaran Transaksi')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 font-medium">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">🏠 Dashboard</a>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Validasi Pembayaran</span>
</div>

{{-- ── PAGE HEADER ── --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">💳 Validasi Pembayaran Reservasi</h1>
        <p class="text-sm text-slate-500 font-medium mt-1">Lakukan pemantauan rekapitulasi pelunasan transaksi secara langsung dari server pusat.</p>
    </div>
</div>

{{-- ── STATS SUMMARY ── --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden group border-t-4 border-t-amber-500">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Menunggu Validasi</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">
            {{ collect($pembayarans ?? [])->where('status', 'pending')->count() }}
        </div>
        <div class="text-xs text-slate-500 font-medium">Transaksi perlu audit admin</div>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden group border-t-4 border-t-emerald-600">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Tervalidasi Sukses</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">
            {{ collect($pembayarans ?? [])->where('status', 'paid')->count() }}
        </div>
        <div class="text-xs text-slate-500 font-medium">Pembayaran terekonsiliasi</div>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden group border-t-4 border-t-rose-600">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Transaksi Gagal/Ditolak</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">
            {{ collect($pembayarans ?? [])->where('status', 'failed')->count() }}
        </div>
        <div class="text-xs text-slate-500 font-medium">Transaksi kadaluarsa/ditolak</div>
    </div>
</div>

{{-- ── TABLE DATA CONTAINER ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-6">
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 bg-slate-50/50">
        <h3 class="text-sm font-bold text-slate-800">Daftar Keseluruhan Pembayaran Pengunjung</h3>
        <span class="text-[10px] font-extrabold uppercase tracking-widest bg-slate-100 text-slate-500 px-2.5 py-1 rounded-lg border border-slate-200">Terpusat</span>
    </div>
    
    <div class="p-4 border-b border-slate-100 bg-white">
        <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 h-9 flex-1 sm:max-w-xs focus-within:border-emerald-500 focus-within:bg-white transition-all duration-150">
                <span class="text-slate-400 text-sm">🔍</span>
                <input id="search-bar-pembayaran" type="text" placeholder="Pencarian kode transaksi/modul..." class="bg-transparent border-none outline-none text-xs text-slate-700 w-full font-medium">
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="px-5 py-3">Kode Transaksi</th>
                    <th class="px-5 py-3">Modul / Referensi</th>
                    <th class="px-5 py-3">Nominal Bayar</th>
                    <th class="px-5 py-3">Status Validasi</th>
                    <th class="px-5 py-3">Metode Bayar</th>
                    <th class="px-5 py-3 text-center w-24">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700" id="table-pembayaran-data">
                @forelse($pembayarans ?? [] as $item)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-3.5 font-extrabold text-slate-800 tracking-tight uppercase">{{ $item['kode_transaksi'] ?? $item['id'] ?? '-' }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[9px] font-extrabold uppercase bg-slate-100 text-slate-600 border border-slate-200">
                            {{ $item['ref_type'] ?? 'Umum' }}
                        </span>
                        <span class="text-[9px] text-slate-400 font-bold ml-1">ID Ref: {{ $item['ref_id'] ?? '-' }}</span>
                    </td>
                    <td class="px-5 py-3.5 font-black text-emerald-700">Rp {{ number_format($item['jumlah'] ?? 0, 0, ',', '.') }}</td>
                    <td class="px-5 py-3.5">
                        @php
                            $status = strtolower($item['status'] ?? 'pending');
                        @endphp
                        @if($status == 'paid')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[9px] font-extrabold uppercase bg-emerald-50 text-emerald-700 border border-emerald-200">✅ Lunas / Berhasil</span>
                        @elseif($status == 'pending')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[9px] font-extrabold uppercase bg-amber-50 text-amber-700 border border-amber-200">⏳ Menunggu Validasi</span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[9px] font-extrabold uppercase bg-rose-50 text-rose-700 border border-rose-200">❌ Ditolak / Gagal</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 font-semibold text-slate-600 uppercase">
                        {{ $item['metode'] ?? 'Transfer Manual' }}
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        <button onclick="loadDetailPembayaran({{ $item['id'] }})" class="w-7 h-7 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-[10px] inline-flex items-center justify-center shadow-sm active:scale-95 transition-transform cursor-pointer" title="Cek Rincian">👁️</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-slate-400 font-medium">
                        <i class="fa-solid fa-ban text-2xl text-slate-300 mb-2 block"></i> Belum ada data riwayat pembayaran pusat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── MODAL: DETAIL & RINCIAN POLIMORFIK ── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalDetailPembayaran">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">📋 Rincian Transaksi Pusat</h3>
            <button onclick="toggleModal('modalDetailPembayaran')" class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-rose-50 hover:text-rose-600 font-bold flex items-center justify-center text-xs cursor-pointer">✕</button>
        </div>
        <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 grid grid-cols-2 gap-3">
                <div>
                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Kode Transaksi</div>
                    <div id="m_kode" class="font-extrabold text-slate-900 text-xs uppercase mt-0.5 tracking-tight">—</div>
                </div>
                <div>
                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Nominal Dibayar</div>
                    <div id="m_nominal" class="font-black text-emerald-700 text-sm mt-0.5">—</div>
                </div>
                <div>
                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Status Pembayaran</div>
                    <div id="m_status_badge" class="mt-0.5 inline-block">—</div>
                </div>
                <div>
                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Metode Bayar</div>
                    <div id="m_metode" class="font-semibold text-slate-600 text-xs uppercase mt-0.5">—</div>
                </div>
            </div>
            
            <div class="border-t border-slate-100 pt-4">
                <h4 class="text-xs font-bold text-slate-700 mb-3 tracking-tight">📎 Data Rujukan / Model Terkait</h4>
                <div id="m_ref_data" class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-2xs font-semibold text-slate-600 space-y-1.5 select-all">
                    Memuat rincian relasi data...
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
            <button type="button" onclick="toggleModal('modalDetailPembayaran')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-bold text-xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 cursor-pointer">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterPembayaran(query) {
        const rows = document.querySelectorAll('#table-pembayaran-data tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if(text.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.getElementById('search-bar-pembayaran').addEventListener('input', function(e) {
        filterPembayaran(e.target.value.toLowerCase());
    });

    async function loadDetailPembayaran(id) {
        try {
            const response = await fetch("{{ route('admin.pembayaran.show', ':id') }}".replace(':id', id));
            const result = await response.json();
            
            if(result.success) {
                const item = result.data.pembayaran;
                const refModel = result.data.ref;

                document.getElementById('m_kode').textContent = item.kode_transaksi || item.id;
                document.getElementById('m_nominal').textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.jumlah || 0);
                document.getElementById('m_metode').textContent = item.metode || '-';

                let badgeHtml = '';
                const status = (item.status || 'pending').toLowerCase();
                if(status === 'paid') {
                    badgeHtml = `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase bg-emerald-50 text-emerald-700 border border-emerald-200">✅ Lunas / Berhasil</span>`;
                } else if(status === 'pending') {
                    badgeHtml = `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase bg-amber-50 text-amber-700 border border-amber-200">⏳ Menunggu Validasi</span>`;
                } else {
                    badgeHtml = `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase bg-rose-50 text-rose-700 border border-rose-200">❌ Ditolak / Gagal</span>`;
                }
                document.getElementById('m_status_badge').innerHTML = badgeHtml;

                const refContainer = document.getElementById('m_ref_data');
                if (refModel) {
                    let refHtml = `<div class="grid grid-cols-2 gap-2 text-[10px]">`;
                    for (const [key, val] of Object.entries(refModel)) {
                        if (typeof val !== 'object' && val !== null) {
                            refHtml += `<div><span class="text-slate-400 font-bold uppercase">${key}:</span> <span class="text-slate-700">${val}</span></div>`;
                        }
                    }
                    refHtml += `</div>`;
                    refContainer.innerHTML = refHtml;
                } else {
                    refContainer.innerHTML = '<p class="text-rose-600 font-bold text-[10px]">Data rujukan tidak ditemukan secara polimorfik.</p>';
                }

                toggleModal('modalDetailPembayaran');
            }
        } catch(err) {
            console.error("Gagal menarik data detail pembayaran:", err);
            alert("Gagal menyambungkan ke API peladen pusat.");
        }
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