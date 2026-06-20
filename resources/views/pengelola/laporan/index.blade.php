@extends('layouts.app')
@section('title', 'Laporan Kunjungan - Pengelola Citiis')
@section('topbar-title', '📈 Laporan Kunjungan')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 font-medium">
    <span class="text-sm">📈</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Analitik</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Laporan Periodik</span>
</div>

{{-- ── PAGE HEADER ── --}}
<div class="mb-6 w-full text-left">
    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">📈 Rekapitulasi & Laporan Kunjungan</h1>
    <p class="text-sm text-slate-500 font-medium mt-1">Halaman rangkuman performa statistik jumlah kunjungan wisatawan serta total omzet pendapatan berkala di Kawasan Citiis.</p>
</div>

{{-- ── TABLE CONTAINER CARD ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full mb-6">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="px-5 py-4 w-1/12">ID Lap</th>
                    <th class="px-5 py-4">Periode Laporan</th>
                    <th class="px-5 py-4 text-center">Total Kunjungan</th>
                    <th class="px-5 py-4">Total Pendapatan (Omzet)</th>
                    <th class="px-5 py-4 text-center">Waktu Pembuatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($laporan ?? [] as $lap)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-5 py-3.5 font-mono text-slate-400 font-bold">#{{ $lap['id'] }}</td>
                    <td class="px-5 py-3.5 font-bold text-slate-800">
                        🗓️ {{ \Carbon\Carbon::parse($lap['periode_awal'])->translatedFormat('d M Y') }} 
                        <span class="text-slate-400 font-normal">s/d</span> 
                        {{ \Carbon\Carbon::parse($lap['periode_akhir'])->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-5 py-3.5 text-center font-extrabold text-blue-600 text-sm">
                        {{ number_format($lap['total_kunjungan']) }} Wisandari
                    </td>
                    <td class="px-5 py-3.5 font-bold text-emerald-600 text-sm">
                        Rp {{ number_format($lap['total_pendapatan']) }}
                    </td>
                    <td class="px-5 py-3.5 text-center text-slate-400 font-mono text-[11px]">
                        {{ \Carbon\Carbon::parse($lap['generated_at'] ?? $lap['created_at'])->translatedFormat('d M Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-slate-400 font-medium">
                        📭 Belum ada arsip laporan kunjungan berkala yang dicetak oleh sistem backend.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection