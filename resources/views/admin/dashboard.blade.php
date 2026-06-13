@extends('layouts.app')
@section('title','Dashboard Admin')
@section('topbar-title','📊 Dashboard Admin')
@section('show-search','1')

@section('content')
<div class="breadcrumb">
  <span>🏠</span><span class="bc-sep">›</span><span>Dashboard</span>
</div>

<div class="page-hd">
  <div class="page-hd-left">
    <h1>Selamat Datang, {{ session('user.nama','Admin') }}! 👋</h1>
    <p>{{ now()->isoFormat('dddd, D MMMM YYYY') }} — Ringkasan sistem CitiisGo hari ini</p>
  </div>
  <div class="page-hd-right">
    <button class="btn btn-out btn-sm">📅 Filter Periode</button>
    <button class="btn btn-g btn-sm">📥 Export Laporan</button>
  </div>
</div>

<!-- Stats -->
<div class="stats-grid">
  <div class="stat-card" style="--ac:var(--g600)">
    <div class="stat-label">Total Wisatawan</div>
    <div class="stat-value">{{ number_format($stats['wisatawan'] ?? 4829) }}</div>
    <div class="stat-sub"><span class="stat-up">▲ 12.4%</span> dari bulan lalu</div>
    <div class="stat-icon">👥</div>
  </div>
  <div class="stat-card" style="--ac:var(--o500)">
    <div class="stat-label">Total Reservasi</div>
    <div class="stat-value">{{ number_format($stats['total_reservasi'] ?? 1247) }}</div>
    <div class="stat-sub"><span class="stat-up">▲ 8.1%</span> bulan ini</div>
    <div class="stat-icon">🎫</div>
  </div>
  <div class="stat-card" style="--ac:var(--b700)">
    <div class="stat-label">Pendapatan Bulan Ini</div>
    <div class="stat-value">Rp {{ number_format(($stats['pendapatan_bulan_ini'] ?? 48200000)/1000000,1) }}jt</div>
    <div class="stat-sub"><span class="stat-up">▲ 18.7%</span> vs bulan lalu</div>
    <div class="stat-icon">💰</div>
  </div>
  <div class="stat-card" style="--ac:var(--p700)">
    <div class="stat-label">Wisata Aktif</div>
    <div class="stat-value">{{ $stats['wisata_aktif'] ?? 54 }}</div>
    <div class="stat-sub"><span class="stat-up">+4</span> wisata baru bulan ini</div>
    <div class="stat-icon">🏞️</div>
  </div>
</div>

<!-- Second row stats -->
<div class="g4" style="margin-bottom:22px">
  <div style="background:#fff;border-radius:11px;border:1px solid var(--border);padding:14px 16px;display:flex;align-items:center;gap:12px">
    <div style="width:42px;height:42px;border-radius:10px;background:var(--o50);display:flex;align-items:center;justify-content:center;font-size:20px">⛺</div>
    <div><div style="font-size:20px;font-weight:800">{{ $stats['booking_camping'] ?? 124 }}</div><div class="text-sm text-muted">Booking Camping</div></div>
  </div>
  <div style="background:#fff;border-radius:11px;border:1px solid var(--border);padding:14px 16px;display:flex;align-items:center;gap:12px">
    <div style="width:42px;height:42px;border-radius:10px;background:var(--b50);display:flex;align-items:center;justify-content:center;font-size:20px">🏨</div>
    <div><div style="font-size:20px;font-weight:800">{{ $stats['booking_penginapan'] ?? 98 }}</div><div class="text-sm text-muted">Booking Penginapan</div></div>
  </div>
  <div style="background:#fff;border-radius:11px;border:1px solid var(--border);padding:14px 16px;display:flex;align-items:center;gap:12px">
    <div style="width:42px;height:42px;border-radius:10px;background:var(--p50);display:flex;align-items:center;justify-content:center;font-size:20px">🎒</div>
    <div><div style="font-size:20px;font-weight:800">{{ $stats['sewa_peralatan'] ?? 56 }}</div><div class="text-sm text-muted">Sewa Peralatan</div></div>
  </div>
  <div style="background:#fff;border-radius:11px;border:1px solid var(--border);padding:14px 16px;display:flex;align-items:center;gap:12px">
    <div style="width:42px;height:42px;border-radius:10px;background:var(--r50);display:flex;align-items:center;justify-content:center;font-size:20px">⏳</div>
    <div><div style="font-size:20px;font-weight:800">{{ $stats['transaksi_pending'] ?? 47 }}</div><div class="text-sm text-muted">Transaksi Pending</div></div>
  </div>
</div>

<div class="g2">
  <!-- Chart pendapatan -->
  <div class="card">
    <div class="card-head">
      <div class="card-title">📈 Pendapatan Bulanan 2025</div>
      <div style="display:flex;gap:8px;align-items:center">
        <span class="badge bg-s" style="font-size:10px">● Reservasi</span>
        <span class="badge bg-w" style="font-size:10px">● Camping</span>
        <span class="badge bg-i" style="font-size:10px">● Penginapan</span>
      </div>
    </div>
    <div class="card-body">
      <div id="chartBars" style="display:flex;align-items:flex-end;gap:6px;height:130px;padding:0 4px"></div>
      <div id="chartLabels" style="display:flex;margin-top:6px"></div>
    </div>
  </div>

  <!-- Donut distribusi -->
  <div class="card">
    <div class="card-head"><div class="card-title">🍩 Distribusi Layanan</div></div>
    <div class="card-body" style="display:flex;align-items:center;gap:20px">
      <svg width="110" height="110" viewBox="0 0 110 110" style="flex-shrink:0">
        <circle cx="55" cy="55" r="40" fill="none" stroke="#F0F4F8" stroke-width="20"/>
        <circle cx="55" cy="55" r="40" fill="none" stroke="#1A6B2A" stroke-width="20" stroke-dasharray="100 152" stroke-dashoffset="25" stroke-linecap="round"/>
        <circle cx="55" cy="55" r="40" fill="none" stroke="#F47A20" stroke-width="20" stroke-dasharray="55 197" stroke-dashoffset="-75" stroke-linecap="round"/>
        <circle cx="55" cy="55" r="40" fill="none" stroke="#1565C0" stroke-width="20" stroke-dasharray="45 207" stroke-dashoffset="-130" stroke-linecap="round"/>
        <circle cx="55" cy="55" r="40" fill="none" stroke="#6A1B9A" stroke-width="20" stroke-dasharray="52 200" stroke-dashoffset="-175" stroke-linecap="round"/>
        <text x="55" y="51" text-anchor="middle" font-size="13" font-weight="800" fill="#1A1A2E" font-family="Plus Jakarta Sans">1,247</text>
        <text x="55" y="65" text-anchor="middle" font-size="9" fill="#9BA3AF" font-family="Plus Jakarta Sans">Transaksi</text>
      </svg>
      <div style="display:flex;flex-direction:column;gap:9px;flex:1">
        @foreach([['#1A6B2A','🎫 Reservasi Tiket','40%'],['#F47A20','⛺ Booking Camping','22%'],['#1565C0','🏨 Booking Penginapan','18%'],['#6A1B9A','🎒 Sewa Peralatan','20%']] as [$c,$l,$p])
        <div style="display:flex;align-items:center;justify-content:space-between;font-size:12px">
          <div style="display:flex;align-items:center;gap:7px">
            <span style="width:9px;height:9px;background:{{ $c }};border-radius:50%;display:inline-block"></span>
            {{ $l }}
          </div>
          <strong>{{ $p }}</strong>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

<div class="g2">
  <!-- Recent transaksi -->
  <div class="card col2">
    <div class="card-head">
      <div class="card-title">🕐 Transaksi Terbaru</div>
      <a href="{{ route('admin.pembayaran') }}" class="btn btn-out btn-sm">Lihat Semua →</a>
    </div>
    <div class="tbl-wrap">
      <table class="tbl">
        <thead>
          <tr>
            <th>Kode</th><th>Wisatawan</th><th>Wisata</th><th>Layanan</th><th>Total</th><th>Status</th><th>Waktu</th>
          </tr>
        </thead>
        <tbody>
          @foreach([
            ['CG-3021','Budi Santoso','Curug Cimedang','Tiket','Rp 75.000','paid','14:22'],
            ['CG-3020','Siti Rahma','Bukit Teletubbies','Camping','Rp 700.000','pending','15:45'],
            ['CG-3019','Ahmad Fauzi','Situ Gede Resort','Penginapan','Rp 450.000','paid','16:10'],
            ['CG-3018','Dewi Kurnia','Curug Dengdeng','Sewa Alat','Rp 240.000','failed','17:03'],
            ['CG-3017','Rudi Setiawan','Pantai Sindangkerta','Tiket','Rp 50.000','paid','18:30'],
          ] as [$kode,$user,$wisata,$layanan,$total,$status,$jam])
          <tr>
            <td><span class="mono">{{ $kode }}</span></td>
            <td class="fw7">{{ $user }}</td>
            <td class="text-muted">{{ $wisata }}</td>
            <td>
              @php $bclass = ['Tiket'=>'bg-s','Camping'=>'bg-w','Penginapan'=>'bg-i','Sewa Alat'=>'bg-p'][$layanan] ?? 'bg-s' @endphp
              <span class="badge {{ $bclass }}">{{ $layanan }}</span>
            </td>
            <td class="fw7" style="color:var(--g700)">{{ $total }}</td>
            <td>
              @if($status==='paid') <span class="badge bg-s">✅ Lunas</span>
              @elseif($status==='pending') <span class="badge bg-w">⏳ Pending</span>
              @else <span class="badge bg-d">❌ Gagal</span>
              @endif
            </td>
            <td class="text-muted text-sm">Hari ini {{ $jam }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="g2">
  <!-- Wisata terpopuler -->
  <div class="card">
    <div class="card-head">
      <div class="card-title">🏆 Wisata Terpopuler</div>
      <a href="{{ route('admin.wisata') }}" class="btn btn-out btn-sm">Semua →</a>
    </div>
    <div class="card-body" style="padding:0">
      @foreach([
        ['🏔️','Curug Cimedang','Tasikmalaya',1102,'var(--g700)'],
        ['⛺','Bukit Teletubbies','Cipatujah',824,'var(--o700)'],
        ['🏖️','Pantai Sindangkerta','Cipatujah',611,'var(--b700)'],
        ['💧','Situ Gede','Tasikmalaya',490,'var(--p700)'],
      ] as [$ico,$nama,$lok,$kunjungan,$clr])
      <div style="display:flex;align-items:center;gap:12px;padding:12px 18px;border-bottom:1px solid var(--border)">
        <div style="width:40px;height:40px;border-radius:9px;background:var(--g50);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">{{ $ico }}</div>
        <div style="flex:1;min-width:0">
          <div class="fw7" style="font-size:13.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $nama }}</div>
          <div class="text-sm text-muted">📍 {{ $lok }}</div>
        </div>
        <div style="text-align:right">
          <div class="fw7" style="font-size:14px;color:{{ $clr }}">{{ number_format($kunjungan) }}</div>
          <div class="text-sm text-muted">kunjungan</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <!-- Aktivitas terbaru -->
  <div class="card">
    <div class="card-head"><div class="card-title">🔔 Aktivitas Terbaru</div></div>
    <div class="card-body" style="padding:0">
      @foreach([
        ['✅','bg-s','Wisata baru disetujui','Bukit Teletubbies oleh Ridwan Setiadi','5 menit lalu'],
        ['👤','bg-i','User baru terdaftar','Andi Pratama (Wisatawan)','12 menit lalu'],
        ['💳','bg-w','Pembayaran pending','CG-3020 — Rp 700.000','23 menit lalu'],
        ['⭐','bg-y','Ulasan baru masuk','Rating 5.0 — Curug Cimedang','1 jam lalu'],
        ['🏞️','bg-p','Pengelola baru','Siti Hartini — Kampung Naga','2 jam lalu'],
      ] as [$ico,$cls,$title,$sub,$time])
      <div style="display:flex;gap:12px;padding:12px 18px;border-bottom:1px solid var(--border);align-items:flex-start">
        <div style="width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0" class="{{ $cls }}">{{ $ico }}</div>
        <div style="flex:1">
          <div style="font-size:13px;font-weight:600;color:var(--t1)">{{ $title }}</div>
          <div class="text-sm text-muted">{{ $sub }}</div>
        </div>
        <div class="text-sm text-muted" style="white-space:nowrap">{{ $time }}</div>
      </div>
      @endforeach
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul'];
const values = [28,35,22,42,38,48,44];
const max = Math.max(...values);
const chart = document.getElementById('chartBars');
const labels = document.getElementById('chartLabels');
values.forEach((v,i) => {
  const col = document.createElement('div');
  col.style.cssText = 'flex:1;display:flex;flex-direction:column;align-items:center;gap:3px;cursor:pointer';
  const bar = document.createElement('div');
  bar.style.cssText = `width:100%;border-radius:5px 5px 0 0;min-width:20px;transition:opacity .15s;`;
  bar.style.height = Math.round(v/max*100)+'%';
  bar.style.background = i === 5 ? 'var(--o500)' : 'var(--g500)';
  bar.title = `${months[i]}: Rp ${v}jt`;
  bar.addEventListener('mouseenter', () => bar.style.opacity = '.75');
  bar.addEventListener('mouseleave', () => bar.style.opacity = '1');
  col.appendChild(bar); chart.appendChild(col);

  const lbl = document.createElement('div');
  lbl.style.cssText = 'flex:1;text-align:center;font-size:10px;color:var(--tm)';
  lbl.textContent = months[i]; labels.appendChild(lbl);
});
</script>
@endpush