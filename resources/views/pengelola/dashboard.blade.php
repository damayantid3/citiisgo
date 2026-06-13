@extends('layouts.app')
@section('title','Dashboard Pengelola')
@section('topbar-title','📊 Dashboard Pengelola')

@section('content')
<div class="breadcrumb">
  <span>🏠</span><span class="bc-sep">›</span><span>Dashboard</span>
</div>

<div class="page-hd">
  <div class="page-hd-left">
    <h1>Halo, {{ session('user.nama','Pengelola') }}! 🏔️</h1>
    <p>{{ now()->isoFormat('dddd, D MMMM YYYY') }} — Ringkasan wisata Anda hari ini</p>
  </div>
  <div class="page-hd-right">
    <a href="{{ route('pengelola.laporan') }}" class="btn btn-out btn-sm">📊 Lihat Laporan</a>
    <a href="{{ route('pengelola.wisata') }}" class="btn btn-g btn-sm">⚙️ Kelola Wisata</a>
  </div>
</div>

<!-- Wisata card banner -->
<div style="background:linear-gradient(135deg,var(--g900),var(--g700));border-radius:16px;padding:22px 24px;margin-bottom:22px;display:flex;align-items:center;gap:20px;position:relative;overflow:hidden">
  <div style="position:absolute;right:20px;bottom:-10px;font-size:100px;opacity:.1">🏔️</div>
  <div style="width:64px;height:64px;background:rgba(255,255,255,.15);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:32px;flex-shrink:0">🏔️</div>
  <div style="flex:1;position:relative;z-index:1">
    <div style="color:rgba(255,255,255,.6);font-size:12px;margin-bottom:3px">Wisata Anda</div>
    <div style="color:#fff;font-size:22px;font-weight:800">{{ $stats['wisata']['nama'] ?? 'Curug Cimedang' }}</div>
    <div style="color:rgba(255,255,255,.6);font-size:12.5px;margin-top:3px">
      📍 {{ $stats['wisata']['alamat'] ?? 'Cikatomas, Tasikmalaya' }} &nbsp;·&nbsp;
      🏷️ {{ $stats['wisata']['kategori']['nama'] ?? 'Alam' }}
    </div>
  </div>
  <div style="display:flex;gap:16px;flex-shrink:0">
    <div style="text-align:center;color:#fff">
      <div style="font-size:22px;font-weight:800">Rp {{ number_format(($stats['wisata']['harga_tiket'] ?? 25000)/1000) }}rb</div>
      <div style="font-size:11px;opacity:.6">Harga Tiket</div>
    </div>
    <div style="width:1px;background:rgba(255,255,255,.2)"></div>
    <div style="text-align:center;color:#fff">
      <div style="font-size:22px;font-weight:800">{{ $stats['wisata']['kuota_harian'] ?? 150 }}</div>
      <div style="font-size:11px;opacity:.6">Kuota/Hari</div>
    </div>
    <div style="width:1px;background:rgba(255,255,255,.2)"></div>
    <div style="text-align:center">
      <div style="background:rgba(255,255,255,.15);border-radius:20px;padding:6px 14px;color:#fff;font-size:12px;font-weight:700">✅ Aktif</div>
    </div>
  </div>
</div>

<!-- Quick stats -->
<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:22px">
  @foreach([
    ['var(--g600)','Total Kunjungan','324','bulan ini','🎫'],
    ['var(--o500)','Reservasi Pending','{{ $stats["reservasi_pending"] ?? 47 }}','perlu konfirmasi','⏳'],
    ['#1565C0','Booking Camping','{{ $stats["booking_camping"] ?? 12 }}','pending','⛺'],
    ['var(--p700)','Booking Penginapan','{{ $stats["booking_penginapan"] ?? 8 }}','pending','🏨'],
    ['var(--g700)','Pendapatan Juni','Rp 16,5jt','total bulan ini','💰'],
  ] as [$clr,$lbl,$val,$sub,$ico])
  <div style="background:#fff;border-radius:11px;border:1px solid var(--border);border-left:3px solid {{ $clr }};padding:14px 16px">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px">
      <div style="font-size:10.5px;font-weight:600;color:var(--t2);text-transform:uppercase;letter-spacing:.4px">{{ $lbl }}</div>
      <span style="font-size:16px">{{ $ico }}</span>
    </div>
    <div style="font-size:20px;font-weight:800;color:var(--t1)">{{ $val }}</div>
    <div style="font-size:11px;color:var(--tm);margin-top:2px">{{ $sub }}</div>
  </div>
  @endforeach
</div>

<div class="g2">
  <!-- Pesanan mendatang -->
  <div class="card">
    <div class="card-head">
      <div class="card-title">📅 Pesanan Mendatang</div>
      <a href="{{ route('pengelola.reservasi') }}" class="btn btn-out btn-sm">Semua →</a>
    </div>
    <div style="padding:0">
      @foreach([
        ['🎫','bg-s','Budi Santoso','Reservasi 3 tiket · 7 Jun 2025','Rp 75.000','confirmed'],
        ['⛺','bg-w','Siti Rahma','Camping 2 malam · 8–10 Jun','Rp 700.000','pending'],
        ['🏨','bg-i','Ahmad Fauzi','Suite View · 10–12 Jun','Rp 900.000','confirmed'],
        ['🎒','bg-p','Rizky Wardana','Sewa Tenda + Carrier · 14–16 Jun','Rp 170.000','pending'],
      ] as [$ico,$cls,$nama,$detail,$total,$status])
      <div style="display:flex;gap:12px;padding:12px 18px;border-bottom:1px solid var(--border);align-items:center">
        <div style="width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:16px" class="{{ $cls }}">{{ $ico }}</div>
        <div style="flex:1">
          <div class="fw7" style="font-size:13px">{{ $nama }}</div>
          <div class="text-sm text-muted">{{ $detail }}</div>
        </div>
        <div style="text-align:right">
          <div class="fw7" style="font-size:13px;color:var(--g700)">{{ $total }}</div>
          <span class="badge {{ $status==='confirmed'?'bg-s':'bg-w' }}" style="font-size:10px">{{ ucfirst($status) }}</span>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <!-- Ulasan terbaru -->
  <div class="card">
    <div class="card-head"><div class="card-title">⭐ Ulasan Terbaru</div></div>
    <div style="padding:0">
      @foreach([
        ['Budi S.','5.0','Tempatnya sangat indah dan bersih. Pengelola sangat ramah!','3 hari lalu'],
        ['Dewi K.','4.0','Pemandangan luar biasa! Parkir perlu diperluas.','5 hari lalu'],
        ['Rudi W.','5.0','Camping di sini pengalaman tak terlupakan. Pasti balik!','1 minggu lalu'],
        ['Hana F.','4.5','Fasilitas oke, air terjunnya keren. Recommended!','2 minggu lalu'],
      ] as [$nama,$rating,$komen,$waktu])
      <div style="padding:12px 18px;border-bottom:1px solid var(--border)">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px">
          <div class="fw7" style="font-size:13px">{{ $nama }}</div>
          <div style="display:flex;align-items:center;gap:3px;font-size:12px">
            <span style="color:#FFC107">⭐</span>
            <strong>{{ $rating }}</strong>
          </div>
        </div>
        <div style="font-size:12.5px;color:var(--t2);line-height:1.5">"{{ $komen }}"</div>
        <div class="text-sm text-muted" style="margin-top:4px">{{ $waktu }}</div>
      </div>
      @endforeach
    </div>
  </div>
</div>

<!-- Chart kunjungan -->
<div class="g2">
  <div class="card">
    <div class="card-head"><div class="card-title">📈 Kunjungan per Minggu (Juni 2025)</div></div>
    <div class="card-body">
      <div id="weekBars" style="display:flex;align-items:flex-end;gap:10px;height:120px"></div>
      <div style="display:flex;justify-content:space-around;margin-top:6px;font-size:11px;color:var(--tm)">
        <span>Mg 1 (245)</span><span>Mg 2 (290)</span><span>Mg 3 (320)</span><span>Mg 4 (247)</span>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-head"><div class="card-title">💰 Pendapatan per Layanan</div></div>
    <div class="card-body">
      @foreach([
        ['🎫 Tiket Masuk','Rp 8,24jt',72,'var(--g600)'],
        ['⛺ Camping','Rp 4,10jt',36,'var(--o500)'],
        ['🏨 Penginapan','Rp 2,80jt',24,'#1565C0'],
        ['🎒 Sewa Alat','Rp 1,40jt',12,'var(--p700)'],
      ] as [$lbl,$val,$pct,$clr])
      <div style="margin-bottom:12px">
        <div style="display:flex;justify-content:space-between;font-size:12.5px;margin-bottom:5px">
          <span>{{ $lbl }}</span><strong style="color:{{ $clr }}">{{ $val }}</strong>
        </div>
        <div class="progress"><div class="progress-fill" style="width:{{ $pct }}%;background:{{ $clr }}"></div></div>
      </div>
      @endforeach
      <div style="border-top:1px solid var(--border);padding-top:12px;display:flex;justify-content:space-between;font-size:14px;font-weight:700">
        <span>Total Bulan Ini</span><span style="color:var(--g700)">Rp 16,54jt</span>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
const weekData = [245, 290, 320, 247];
const weekMax  = Math.max(...weekData);
const wc = document.getElementById('weekBars');
weekData.forEach((v,i) => {
  const col = document.createElement('div');
  col.style.cssText = 'flex:1;display:flex;flex-direction:column;align-items:center;gap:3px';
  const bar = document.createElement('div');
  bar.style.cssText = `width:100%;border-radius:6px 6px 0 0;background:${i===2?'var(--o500)':'var(--g500)'};transition:opacity .15s`;
  bar.style.height = Math.round(v/weekMax*100) + '%';
  bar.title = `Minggu ke-${i+1}: ${v} kunjungan`;
  bar.addEventListener('mouseenter', () => bar.style.opacity = '.7');
  bar.addEventListener('mouseleave', () => bar.style.opacity = '1');
  col.appendChild(bar); wc.appendChild(col);
});
</script>
@endpush