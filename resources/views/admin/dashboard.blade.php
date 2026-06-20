@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('topbar-title', '📊 Dashboard Admin')
@section('show-search', '1')

@section('content')
@php
    $localStats = $stats ?? [];
    $totalReservasi = $localStats['total_reservasi'] ?? $localStats['reservasi'] ?? 0;
@endphp

{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 font-medium">
    <span class="text-sm">🏠</span>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Dashboard</span>
</div>

{{-- ── PAGE HEADER (SUDAH DIPERBAIKI MENJADI SEJAJAR HORIZONTAL) ── --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6 w-full">
    <div class="text-left">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Selamat Datang, {{ session('user.nama', 'Admin') }}! 👋</h1>
        <p class="text-sm text-slate-500 font-medium mt-1">{{ now()->isoFormat('dddd, D MMMM YYYY') }} — Ringkasan sistem CitiisGo langsung dari database pusat</p>
    </div>
    <div class="flex items-center gap-2.5 justify-start lg:justify-end">
        <button class="inline-flex items-center justify-center gap-2 bg-white border border-slate-200 text-slate-700 font-bold text-xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 active:scale-95 transition-all duration-150 cursor-pointer">
            📅 Filter Periode
        </button>
        <button class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white font-bold text-xs px-4 h-9 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-all duration-150 cursor-pointer">
            📥 Export Laporan
        </button>
    </div>
</div>

{{-- ── PRIMARY STATS GRID ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    
    <!-- Card: Wisatawan -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-200 border-t-4 border-t-emerald-600">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Wisatawan</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">
            {{ number_format($localStats['total_wisatawan'] ?? $localStats['wisatawan'] ?? 0) }}
        </div>
        <div class="text-xs text-slate-500 font-medium flex items-center gap-1">
            <span class="text-emerald-600 font-bold">Real-time</span> pengguna terdaftar
        </div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-4xl opacity-10 group-hover:scale-110 transition-transform duration-200">👥</div>
    </div>

    <!-- Card: Reservasi -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-200 border-t-4 border-t-amber-500">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Reservasi</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">
            {{ number_format($totalReservasi) }}
        </div>
        <div class="text-xs text-slate-500 font-medium flex items-center gap-1">
            <span class="text-emerald-600 font-bold">Aktif</span> bulan ini
        </div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-4xl opacity-10 group-hover:scale-110 transition-transform duration-200">🎫</div>
    </div>

    <!-- Card: Pendapatan -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-200 border-t-4 border-t-blue-600">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Pendapatan</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">
            Rp {{ number_format($localStats['total_pendapatan'] ?? $localStats['pendapatan_bulan_ini'] ?? 0) }}
        </div>
        <div class="text-xs text-slate-500 font-medium flex items-center gap-1">
            <span class="text-blue-600 font-bold">Omset Bruto</span> keseluruhan
        </div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-4xl opacity-10 group-hover:scale-110 transition-transform duration-200">💰</div>
    </div>

    <!-- Card: Wisata Aktif -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-200 border-t-4 border-t-purple-600">
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Destinasi Wisata</div>
        <div class="text-3xl font-extrabold text-slate-900 my-1.5 tracking-tight">
            {{ $localStats['total_wisata'] ?? $localStats['wisata_aktif'] ?? 0 }}
        </div>
        <div class="text-xs text-slate-500 font-medium flex items-center gap-1">
            <span class="text-purple-600 font-bold">Tersebar</span> di Tasikmalaya
        </div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-4xl opacity-10 group-hover:scale-110 transition-transform duration-200">🏞️</div>
    </div>

</div>

{{-- ── SECONDARY MINI STATS GRID ── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    
    <!-- Mini Card: Camping -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 flex items-center gap-3.5 shadow-sm">
        <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-xl shadow-inner">⛺</div>
        <div>
            <div class="text-xl font-extrabold text-slate-900 leading-none">{{ $localStats['total_camping'] ?? $localStats['booking_camping'] ?? 0 }}</div>
            <div class="text-[11px] text-slate-400 font-semibold mt-1">Paket Camping</div>
        </div>
    </div>

    <!-- Mini Card: Penginapan -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 flex items-center gap-3.5 shadow-sm">
        <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-xl shadow-inner">🏨</div>
        <div>
            <div class="text-xl font-extrabold text-slate-900 leading-none">{{ $localStats['total_penginapan'] ?? $localStats['booking_penginapan'] ?? 0 }}</div>
            <div class="text-[11px] text-slate-400 font-semibold mt-1">Kamar Hotel / Resort</div>
        </div>
    </div>

    <!-- Mini Card: Peralatan -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 flex items-center gap-3.5 shadow-sm">
        <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center text-xl shadow-inner">🎒</div>
        <div>
            <div class="text-xl font-extrabold text-slate-900 leading-none">{{ $localStats['total_peralatan'] ?? $localStats['sewa_peralatan'] ?? 0 }}</div>
            <div class="text-[11px] text-slate-400 font-semibold mt-1">Sewa Alat Outdoor</div>
        </div>
    </div>

    <!-- Mini Card: Pending -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 flex items-center gap-3.5 shadow-sm">
        <div class="w-11 h-11 rounded-xl bg-rose-50 flex items-center justify-center text-xl shadow-inner">⏳</div>
        <div>
            <div class="text-xl font-extrabold text-slate-900 leading-none">{{ $localStats['total_pending'] ?? $localStats['transaksi_pending'] ?? 0 }}</div>
            <div class="text-[11px] text-slate-400 font-semibold mt-1">Transaksi Pending</div>
        </div>
    </div>

</div>

{{-- ── CHARTS & ANALYTICS ROW ── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    
    <!-- Chart: Pendapatan -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">📈 Grafik Pendapatan Bulanan</h3>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">● Tiket</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700">● Camping</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700">● Kamar</span>
            </div>
        </div>
        <div class="p-5 flex-1 flex flex-col justify-end">
            <div id="chartBars" class="flex items-end gap-3 h-36 px-2"></div>
            <div id="chartLabels" class="flex mt-2.5"></div>
        </div>
    </div>

    <!-- Chart: Distribusi Layanan (Donut) -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col">
        <div class="px-5 py-4 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-800">🍩 Distribusi Pembelian Layanan</h3>
        </div>
        <div class="p-5 flex-1 flex flex-col sm:flex-row items-center gap-6">
            <svg width="120" height="120" viewBox="0 0 110 110" class="flex-shrink-0 drop-shadow-sm">
                <circle cx="55" cy="55" r="40" fill="none" stroke="#f1f5f9" stroke-width="16"/>
                <circle cx="55" cy="55" r="40" fill="none" stroke="#059669" stroke-width="16" stroke-dasharray="100 152" stroke-dashoffset="25" stroke-linecap="round"/>
                <circle cx="55" cy="55" r="40" fill="none" stroke="#f59e0b" stroke-width="16" stroke-dasharray="55 197" stroke-dashoffset="-75" stroke-linecap="round"/>
                <circle cx="55" cy="55" r="40" fill="none" stroke="#2563eb" stroke-width="16" stroke-dasharray="45 207" stroke-dashoffset="-130" stroke-linecap="round"/>
                <circle cx="55" cy="55" r="40" fill="none" stroke="#7c3aed" stroke-width="16" stroke-dasharray="52 200" stroke-dashoffset="-175" stroke-linecap="round"/>
                <text x="55" y="52" text-anchor="middle" font-size="12" font-weight="800" fill="#0f172a" font-family="Plus Jakarta Sans">
                    {{ number_format($totalReservasi) }}
                </text>
                <text x="55" y="65" text-anchor="middle" font-size="8" font-weight="600" fill="#94a3b8" font-family="Plus Jakarta Sans">Pesanan</text>
            </svg>
            <div class="flex flex-col gap-2.5 flex-1 w-full">
                @php
                    $tiketPct = $totalReservasi > 0 ? round((($localStats['total_tiket'] ?? 0) / $totalReservasi) * 100) : 40;
                    $campPct = $totalReservasi > 0 ? round((($localStats['total_camping'] ?? 0) / $totalReservasi) * 100) : 22;
                    $hotelPct = $totalReservasi > 0 ? round((($localStats['total_penginapan'] ?? 0) / $totalReservasi) * 100) : 18;
                    $alatPct = $totalReservasi > 0 ? round((($localStats['total_peralatan'] ?? 0) / $totalReservasi) * 100) : 20;
                @endphp
                <div class="flex items-center justify-between text-xs font-medium text-slate-600 bg-slate-50/50 px-3 py-2 rounded-xl border border-slate-100">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full inline-block bg-emerald-600"></span>🎫 Tiket Masuk</div>
                    <strong class="text-slate-900 font-bold">{{ $tiketPct }}%</strong>
                </div>
                <div class="flex items-center justify-between text-xs font-medium text-slate-600 bg-slate-50/50 px-3 py-2 rounded-xl border border-slate-100">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full inline-block bg-amber-500"></span>⛺ Paket Camping</div>
                    <strong class="text-slate-900 font-bold">{{ $campPct }}%</strong>
                </div>
                <div class="flex items-center justify-between text-xs font-medium text-slate-600 bg-slate-50/50 px-3 py-2 rounded-xl border border-slate-100">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full inline-block bg-blue-600"></span>🏨 Penginapan</div>
                    <strong class="text-slate-900 font-bold">{{ $hotelPct }}%</strong>
                </div>
                <div class="flex items-center justify-between text-xs font-medium text-slate-600 bg-slate-50/50 px-3 py-2 rounded-xl border border-slate-100">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full inline-block bg-purple-600"></span>🎒 Sewa Peralatan</div>
                    <strong class="text-slate-900 font-bold">{{ $alatPct }}%</strong>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ── DATA TABLE ROW ── --}}
<div class="grid grid-cols-1 gap-6 mb-6">
    
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-800">🕐 Transaksi Terbaru</h3>
            <a href="{{ route('admin.pembayaran') }}" class="inline-flex items-center justify-center text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-colors">
                Lihat Semua →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs font-medium">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                        <th class="px-5 py-3">Kode Booking</th>
                        <th class="px-5 py-3">Wisatawan</th>
                        <th class="px-5 py-3">Destinasi</th>
                        <th class="px-5 py-3">Jenis Layanan</th>
                        <th class="px-5 py-3">Total Bayar</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Tanggal Transaksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($transaksi_terbaru ?? [] as $t)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-5 py-3.5">
                            <span class="font-mono bg-slate-100 px-2 py-0.5 rounded text-slate-600 border border-slate-200/40">
                                {{ $t['kode_booking'] ?? $t['id'] }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 font-bold text-slate-900">{{ $t['user']['nama'] ?? $t['user_nama'] ?? '—' }}</td>
                        <td class="px-5 py-3.5 text-slate-500">{{ $t['wisata']['nama'] ?? $t['wisata_nama'] ?? '—' }}</td>
                        <td class="px-5 py-3.5">
                            @php 
                                $layanan = $t['jenis_layanan'] ?? 'Tiket';
                                $badgeStyle = [
                                    'Tiket' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'Camping' => 'bg-amber-50 text-amber-700 border-amber-100',
                                    'Penginapan' => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'Sewa Alat' => 'bg-purple-50 text-purple-700 border-purple-100'
                                ][$layanan] ?? 'bg-slate-50 text-slate-700';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $badgeStyle }}">{{ $layanan }}</span>
                        </td>
                        <td class="px-5 py-3.5 font-bold text-emerald-700">Rp {{ number_format($t['total_harga'] ?? $t['total'] ?? 0) }}</td>
                        <td class="px-5 py-3.5">
                            @php $status = $t['status'] ?? 'pending'; @endphp
                            @if($status === 'success' || $status === 'paid') 
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">✅ Lunas</span>
                            @elseif($status === 'pending') 
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">⏳ Pending</span>
                            @else 
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">❌ Gagal</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-slate-400 text-[11px]">
                            {{ isset($t['created_at']) ? date('d M Y H:i', strtotime($t['created_at'])) : '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-slate-400 font-medium">
                            📭 Belum ada riwayat pembayaran riil yang tercatat di database API.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ── POPULAR & RECENT ACTIVITY ROW ── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- List: Wisata Terpopuler Riil -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-800">🏆 Wisata Terpopuler</h3>
            <a href="{{ route('admin.wisata') }}" class="inline-flex items-center justify-center text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-colors">Semua →</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($wisata_populer ?? [] as $wp)
            <div class="flex items-center gap-3.5 px-5 py-3.5 hover:bg-slate-50/50 transition-colors">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg flex-shrink-0 shadow-inner bg-emerald-50 text-emerald-700">🏞️</div>
                <div class="flex-1 min-w-0">
                    <div class="font-bold text-slate-900 text-sm truncate">{{ $wp['nama'] }}</div>
                    <div class="text-xs text-slate-400 font-medium mt-0.5">📍 {{ Str::limit($wp['alamat'], 30) }}</div>
                </div>
                <div class="text-right">
                    <div class="font-extrabold text-sm text-slate-800">{{ number_format($wp['total_kunjungan'] ?? $wp['transaksi_count'] ?? 0) }}</div>
                    <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Kunjungan</div>
                </div>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-slate-400 text-xs font-medium">
                📊 Data destinasi terpopuler belum di-kalkulasi dari transaksi.
            </div>
            @endforelse
        </div>
    </div>

    <!-- List: Aktivitas Log Terbaru -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-800">⚙️ Log Aktivitas Sistem</h3>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($logs ?? [] as $log)
            <div class="flex items-start gap-3.5 px-5 py-3.5 hover:bg-slate-50/50 transition-colors">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm border flex-shrink-0 bg-blue-50 text-blue-700 border-blue-100">⚙️</div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-bold text-slate-900 leading-none">{{ $log['activity'] ?? $log['keterangan'] }}</div>
                    <div class="text-xs text-slate-500 mt-1 font-medium truncate">Oleh: {{ $log['user']['nama'] ?? 'Sistem' }}</div>
                </div>
                <div class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200/30">
                    {{ isset($log['created_at']) ? Carbon\Carbon::parse($log['created_at'])->diffForHumans() : 'Baru saja' }}
                </div>
            </div>
            @empty
            <div class="flex items-start gap-3.5 px-5 py-3.5 hover:bg-slate-50/50 transition-colors">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm border flex-shrink-0 bg-emerald-50 text-emerald-700 border-emerald-100">✅</div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-bold text-slate-900 leading-none">Sistem Berjalan Normal</div>
                    <div class="text-xs text-slate-500 mt-1 font-medium truncate">Menunggu rekaman aktivitas masuk...</div>
                </div>
                <div class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200/30">Now</div>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul'];
const chartData = JSON.parse('{!! json_encode($chart_data ?? [28, 35, 22, 42, 38, 48, 44]) !!}');
const max = Math.max(...chartData, 1);
const chart = document.getElementById('chartBars');
const labels = document.getElementById('chartLabels');

chartData.forEach((v, i) => {
    const col = document.createElement('div');
    col.className = 'flex-1 flex flex-col items-center gap-1 cursor-pointer h-full justify-end group';
    
    const bar = document.createElement('div');
    bar.className = 'w-full rounded-t-lg transition-all duration-200 relative';
    bar.style.height = Math.round(v/max*100)+'%';
    bar.style.backgroundColor = i === chartData.length - 1 ? '#f59e0b' : '#10b981';
    bar.title = `${months[i] ?? 'Bulan'}: ${v} Transaksi`;
    
    bar.addEventListener('mouseenter', () => bar.style.opacity = '.8');
    bar.addEventListener('mouseleave', () => bar.style.opacity = '1');
    
    col.appendChild(bar); 
    chart.appendChild(col);

    const lbl = document.createElement('div');
    lbl.className = 'flex-1 text-center text-[10px] font-bold text-slate-400 uppercase tracking-wider';
    lbl.textContent = months[i] ?? 'M'; 
    labels.appendChild(lbl);
});
</script>
@endpush