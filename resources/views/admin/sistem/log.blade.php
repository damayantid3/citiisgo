@extends('layouts.app')
@section('title', 'Log Aktivitas Sistem - Admin CitiisGo')
@section('topbar-title', '📋 Audit Trail Log Aktivitas Sistem')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-[10px] text-slate-400 mb-5 font-semibold">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">🏠 Dashboard Audit</a>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Sistem Konfigurasi</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Log Aktivitas</span>
</div>

{{-- ── DATA TABLE CONTAINER ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <div>
            <h3 class="text-xs font-black text-slate-800 tracking-tight">Rekam Jejak Aktivitas Sistem (Audit Trail)</h3>
            <p class="text-[10px] text-slate-500 font-medium mt-0.5">Pemantauan riwayat tindakan dan kejadian secara transparan dari seluruh pengguna.</p>
        </div>
        <span class="text-[9px] font-black tracking-widest bg-slate-100 px-3 py-1 rounded-lg border border-slate-200 text-slate-600 uppercase">Total Log: {{ count($logs ?? []) }} Baris</span>
    </div>

    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-3xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[9px]">
                    <th class="px-6 py-3.5 w-1/12">ID Log</th>
                    <th class="px-6 py-3.5 w-1/2">Uraian Kejadian / Tindakan</th>
                    <th class="px-6 py-3.5">Eksekutor Pengguna</th>
                    <th class="px-6 py-3.5 text-center">Waktu Kejadian</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 text-2xs">
                @forelse($logs ?? [] as $log)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-6 py-3.5 font-extrabold font-mono text-slate-400">#{{ $log['id'] }}</td>
                    <td class="px-6 py-3.5 font-bold text-slate-700 tracking-tight">{{ $log['keterangan'] ?? 'Aksi Sistem Tidak Diketahui' }}</td>
                    <td class="px-6 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-black border uppercase tracking-wider bg-slate-50 text-slate-600 border-slate-200">
                            {{ $log['user']['nama'] ?? 'Sistem Utama' }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5 font-bold text-slate-400 text-center font-mono">
                        {{ \Carbon\Carbon::parse($log['created_at'])->format('d M Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-semibold">
                        📭 Belum ada rekaman log aktivitas yang masuk ke dalam sistem audit.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection