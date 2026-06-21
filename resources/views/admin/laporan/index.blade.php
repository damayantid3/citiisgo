@extends('layouts.app')
@section('title', 'Laporan Agregasi Pusat - CitiisGo')
@section('topbar-title', '📈 Rekapitulasi Laporan Kunjungan & Keuangan')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-[10px] text-slate-400 mb-4 font-semibold">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">🏠 Dashboard</a>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Laporan Pusat</span>
</div>

{{-- ── PAGE HEADER & FILTER ── --}}
<div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4 mb-5">
    <div>
        <h1 class="text-lg font-black tracking-tight text-slate-800">📈 Laporan Agregasi Pusat Citiis</h1>
        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Audit dan rekapitulasi performa kawasan, data kunjungan, serta omset keuangan secara makro.</p>
    </div>
    
    <form action="{{ route('admin.laporan') }}" method="GET" class="flex flex-wrap items-center gap-2 bg-white border border-slate-200 rounded-xl p-1.5 shadow-sm self-start xl:self-auto text-[10px]">
        <div class="flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 rounded-lg border border-slate-200">
            <span class="text-[8px] font-black text-slate-400 uppercase tracking-wider">Dari</span>
            <input type="date" name="dari" value="{{ $summary['periode_dari'] ?? '' }}" class="bg-transparent border-none outline-none font-bold text-slate-600">
        </div>
        <div class="flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 rounded-lg border border-slate-200">
            <span class="text-[8px] font-black text-slate-400 uppercase tracking-wider">Sampai</span>
            <input type="date" name="sampai" value="{{ $summary['periode_sampai'] ?? '' }}" class="bg-transparent border-none outline-none font-bold text-slate-600">
        </div>
        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black px-3 h-7 rounded-lg shadow-sm active:scale-95 transition-transform cursor-pointer outline-none border-none tracking-wide">
            Filter
        </button>
        <button type="button" onclick="window.print()" class="bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold px-3 h-7 rounded-lg shadow-sm active:scale-95 transition-transform cursor-pointer">
            🖨️ Cetak / PDF
        </button>
    </form>
</div>

{{-- ── STATS SUMMARY ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm relative overflow-hidden group border-t-4 border-t-emerald-600">
        <div class="text-[8px] font-black uppercase tracking-widest text-slate-400">Total Omset Bersih (Lunas)</div>
        <div class="text-xl font-black text-emerald-700 mt-0.5 tracking-tight">
            Rp {{ number_format($summary['total_pendapatan'] ?? 0, 0, ',', '.') }}
        </div>
        <div class="text-[9px] text-slate-500 font-bold mt-0.5">Akumulasi omset kotor terverifikasi sistem</div>
    </div>
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm relative overflow-hidden group border-t-4 border-t-teal-600">
        <div class="text-[8px] font-black uppercase tracking-widest text-slate-400">Total Transaksi Sukses</div>
        <div class="text-xl font-black text-slate-800 mt-0.5 tracking-tight">
            {{ number_format($summary['total_transaksi'] ?? 0, 0, ',', '.') }} Pesanan
        </div>
        <div class="text-[9px] text-slate-500 font-bold mt-0.5">Total reservasi tiket, camping, & sewa alat</div>
    </div>
</div>

{{-- ── RINCIAN LAPORAN DATA TABLE ── --}}
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-5">
    <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100 bg-slate-50/50">
        <h3 class="text-xs font-black text-slate-800 tracking-tight">Rincian Log Reservasi Kunjungan</h3>
        <span class="text-[8px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full border border-emerald-200">
            Periode: {{ \Carbon\Carbon::parse($summary['periode_dari'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($summary['periode_sampai'])->format('d M Y') }}
        </span>
    </div>
    
    <div class="p-3 border-b border-slate-100 bg-white print:hidden">
        <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg px-2.5 h-8 w-full sm:max-w-xs focus-within:border-emerald-500 transition-all text-[11px]">
            <span class="text-slate-400 text-xs">🔍</span>
            <input id="search-bar-laporan" type="text" placeholder="Pencarian log rincian laporan..." class="bg-transparent border-none outline-none text-[11px] text-slate-700 w-full font-bold">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-[11px] font-medium text-slate-700">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-black uppercase tracking-wider">
                    <th class="px-4 py-3">Waktu Dibuat</th>
                    <th class="px-4 py-3">Item / Layanan</th>
                    <th class="px-4 py-3">Atas Nama User</th>
                    <th class="px-4 py-3">Tarif / Slot</th>
                    <th class="px-4 py-3 text-center">Qty</th>
                    <th class="px-4 py-3">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100" id="table-laporan-data">
                @forelse($rincian ?? [] as $log)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-4 py-3 font-bold text-slate-400 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($log['created_at'])->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-black text-slate-800 tracking-tight">
                            {{ $log['wisata']['nama'] ?? $log['nama_layanan'] ?? 'Layanan / Tiket' }}
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-bold text-slate-600">{{ $log['nama_pemesan'] ?? $log['user']['name'] ?? '-' }}</div>
                    </td>
                    <td class="px-4 py-3 font-black text-emerald-600 whitespace-nowrap">
                        Rp {{ number_format($log['harga_tiket'] ?? $log['tarif'] ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3 font-black text-slate-600 text-center">
                        {{ $log['jumlah_tiket'] ?? $log['kuota_pesan'] ?? $log['qty'] ?? 1 }}
                    </td>
                    <td class="px-4 py-3 font-black text-slate-800 whitespace-nowrap">
                        @php
                            $harga = $log['harga_tiket'] ?? $log['tarif'] ?? 0;
                            $qty = $log['jumlah_tiket'] ?? $log['kuota_pesan'] ?? $log['qty'] ?? 1;
                            $subtotal = $harga * $qty;
                        @endphp
                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-slate-400 font-bold">
                        <i class="fa-solid fa-ban text-lg text-slate-300 mb-1 block"></i> Belum ada log transaksi reservasi pada rentang tanggal ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterLaporan(query) {
        const rows = document.querySelectorAll('#table-laporan-data tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if(text.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    const searchBar = document.getElementById('search-bar-laporan');
    if(searchBar) {
        searchBar.addEventListener('input', function(e) {
            filterLaporan(e.target.value.toLowerCase());
        });
    }
</script>
<style type="text/css" media="print">
    @page { size: landscape; margin: 10mm; }
    body { font-size: 11px !important; }
    .print\:hidden { display: none !important; }
    .xl\:justify-between { justify-content: space-between !important; }
</style>
@endpush