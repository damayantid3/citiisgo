@extends('layouts.app')
@section('title', 'Laporan Kunjungan - Pengelola Citiis')
@section('topbar-title', '📈 Rekapitulasi Laporan Keuangan Parsial')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-[10px] text-slate-400 mb-5 font-semibold">
    <span class="text-[9px]">🏠</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Analitik</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Laporan Periodik</span>
</div>

{{-- ── PAGE HEADER ── --}}
<div class="mb-6 w-full text-left">
    <h1 class="text-base font-extrabold tracking-tight text-slate-800">Rekapitulasi Laporan Pendapatan</h1>
    <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Rangkuman performa statistik jumlah kunjungan serta total omzet pendapatan berkala murni khusus unit wahana dan aset bisnis Anda.</p>
</div>

{{-- ── TABLE CONTAINER CARD ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full mb-6">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-3xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[9px]">
                    <th class="px-6 py-3.5 w-1/12">ID Lap</th>
                    <th class="px-6 py-3.5">Periode Laporan</th>
                    <th class="px-6 py-3.5 text-center">Total Kunjungan</th>
                    <th class="px-6 py-3.5">Total Pendapatan (Omzet)</th>
                    <th class="px-6 py-3.5 text-center">Waktu Pembuatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-2xs">
                @forelse($laporan ?? [] as $lap)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-6 py-3.5 font-mono text-slate-400 font-black">#{{ $lap['id'] }}</td>
                    <td class="px-6 py-3.5 font-black text-slate-800 tracking-tight">
                        <span class="text-[9px]">🗓️</span> {{ \Carbon\Carbon::parse($lap['periode_awal'])->translatedFormat('d M Y') }} 
                        <span class="text-slate-400 font-normal">s/d</span> 
                        {{ \Carbon\Carbon::parse($lap['periode_akhir'])->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-6 py-3.5 text-center font-extrabold text-blue-600 text-2xs tracking-tight">
                        {{ number_format($lap['total_kunjungan'] ?? 0) }} Wisatawan
                    </td>
                    <td class="px-6 py-3.5 font-black text-emerald-700 text-2xs tracking-tight">
                        Rp {{ number_format($lap['total_pendapatan'] ?? 0) }}
                    </td>
                    <td class="px-6 py-3.5 text-center text-slate-400 font-mono font-bold text-[9px]">
                        {{ \Carbon\Carbon::parse($lap['generated_at'] ?? $lap['created_at'])->translatedFormat('d M Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-bold text-2xs">
                        📭 Belum ada arsip laporan rekapitulasi periodik tercetak.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection