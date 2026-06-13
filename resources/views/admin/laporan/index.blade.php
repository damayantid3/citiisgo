@extends('layouts.app')
@section('title','Laporan & Analitik')
@section('topbar-title','📊 Laporan & Analitik')
@section('content')
<div class="bc"><a href="{{ route('admin.dashboard') }}">🏠</a><span class="bc-sep">›</span><span>Laporan & Analitik</span></div>
<div class="ph">
  <div><h1>📊 Laporan & Analitik</h1><p>Ringkasan performa sistem CitiisGo</p></div>
  <div class="ph-right">
    <form method="GET" style="display:flex;gap:7px;align-items:center;flex-wrap:wrap">
      <select name="periode" class="sf" onchange="this.form.submit()">
        <option value="bulan_ini">Bulan Ini (Juni 2025)</option>
        <option value="bulan_lalu">Bulan Lalu</option>
        <option value="3_bulan">3 Bulan Terakhir</option>
        <option value="tahun_ini">Tahun Ini</option>
      </select>
      <input type="date" name="dari" class="sf" value="{{ $laporan['periode']['dari'] ?? now()->startOfMonth()->format('Y-m-d') }}">
      <span class="text-muted text-sm">—</span>
      <input type="date" name="sampai" class="sf" value="{{ $laporan['periode']['sampai'] ?? now()->format('Y-m-d') }}">
      <button type="submit" class="btn btn-g btn-sm">🔍 Terapkan</button>
    </form>
    <button class="btn btn-out btn-sm">📥 Unduh PDF</button>
  </div>
</div>

{{-- Summary --}}
<div class="stats">
  <div class="sc" style="--ac:var(--g700)"><div class="sc-lbl">Total Kunjungan</div><div class="sc-val">4.248</div><div class="sc-sub sc-up">▲ 14.2% vs periode lalu</div><div class="sc-ico">👣</div></div>
  <div class="sc" style="--ac:var(--o500)"><div class="sc-lbl">Total Pendapatan</div><div class="sc-val">Rp 48,2jt</div><div class="sc-sub sc-up">▲ 18.7%</div><div class="sc-ico">💰</div></div>
  <div class="sc" style="--ac:var(--b700)"><div class="sc-lbl">Total Transaksi</div><div class="sc-val">1.094</div><div class="sc-sub sc-up">▲ 11.3%</div><div class="sc-ico">🧾</div></div>
  <div class="sc" style="--ac:var(--p700)"><div class="sc-lbl">Rating Rata-rata</div><div class="sc-val">4.7 ⭐</div><div class="sc-sub">Dari 128 ulasan</div><div class="sc-ico">⭐</div></div>
</div>

<div class="g2" style="margin-bottom:16px">
  {{-- Bar chart trend --}}
  <div class="card" style="margin-bottom:0">
    <div class="card-hd"><div class="card-title">📈 Tren Kunjungan Harian</div></div>
    <div class="card-body">
      <div id="dailyBars" style="display:flex;align-items:flex-end;gap:3px;height:110px"></div>
      <div style="display:flex;justify-content:space-between;margin-top:6px;font-size:10px;color:var(--tm)">
        <span>1 Jun</span><span>7 Jun</span><span>14 Jun</span><span>21 Jun</span><span>28 Jun</span>
      </div>
    </div>
  </div>

  {{-- Distribusi per wisata --}}
  <div class="card" style="margin-bottom:0">
    <div class="card-hd"><div class="card-title">🗺️ Top 5 Wisata Terpopuler</div></div>
    <div style="padding:0">
      @foreach([
        ['🏔️','Curug Cimedang',1102,'Rp 16,5jt',26],
        ['⛺','Bukit Teletubbies',824,'Rp 12,4jt',19],
        ['🏖️','Pantai Sindangkerta',611,'Rp 9,1jt',14],
        ['💧','Situ Gede',490,'Rp 7,3jt',12],
        ['🕌','Kampung Adat Naga',421,'Rp 6,2jt',10],
      ] as [$ico,$nama,$kunjungan,$pendapatan,$pct])
      <div style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-bottom:1px solid var(--border)">
        <div style="font-size:20px;width:30px;text-align:center;flex-shrink:0">{{ $ico }}</div>
        <div style="flex:1;min-width:0">
          <div class="fw7 text-sm" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $nama }}</div>
          <div class="progress" style="margin-top:4px"><div class="progress-fill" style="width:{{ $pct }}%;background:var(--g600)"></div></div>
        </div>
        <div style="text-align:right;flex-shrink:0">
          <div class="fw7 text-sm" style="color:var(--g700)">{{ number_format($kunjungan) }}</div>
          <div style="font-size:10px;color:var(--tm)">{{ $pendapatan }}</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

<div class="g2" style="margin-bottom:16px">
  {{-- Pendapatan per layanan --}}
  <div class="card" style="margin-bottom:0">
    <div class="card-hd"><div class="card-title">💳 Pendapatan per Layanan</div></div>
    <div class="card-body">
      @foreach([
        ['🎫 Reservasi Tiket','Rp 18,4jt',72,'var(--g600)',4248],
        ['⛺ Booking Camping','Rp 12,8jt',50,'var(--o500)',280],
        ['🏨 Booking Penginapan','Rp 10,5jt',41,'var(--b700)',192],
        ['🎒 Sewa Peralatan','Rp 6,5jt',25,'var(--p700)',374],
      ] as [$lbl,$val,$pct,$clr,$jml])
      <div style="margin-bottom:13px">
        <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:5px">
          <span>{{ $lbl }}</span>
          <div style="display:flex;gap:8px;align-items:center">
            <span class="text-muted text-sm">{{ number_format($jml) }} transaksi</span>
            <strong style="color:{{ $clr }}">{{ $val }}</strong>
          </div>
        </div>
        <div class="progress"><div class="progress-fill" style="width:{{ $pct }}%;background:{{ $clr }}"></div></div>
      </div>
      @endforeach
      <div style="border-top:1px solid var(--border);padding-top:11px;display:flex;justify-content:space-between;font-size:13.5px;font-weight:700">
        <span>Total Pendapatan</span><span style="color:var(--g700)">Rp 48,2jt</span>
      </div>
    </div>
  </div>

  {{-- Laporan per pengelola --}}
  <div class="card" style="margin-bottom:0">
    <div class="card-hd"><div class="card-title">👤 Pendapatan per Pengelola</div></div>
    <div class="tbl-wrap">
      <table class="tbl">
        <thead><tr><th>Pengelola</th><th>Wisata</th><th>Kunjungan</th><th>Pendapatan</th></tr></thead>
        <tbody>
          @foreach([['Budi Kusuma','Curug Cimedang',1102,'Rp 16,5jt'],['Ridwan Setiadi','Bukit Teletubbies',824,'Rp 12,4jt'],['Dewi Permata','Pantai Sindangkerta',611,'Rp 9,1jt'],['M. Fauzi','Situ Gede',490,'Rp 7,3jt']] as [$p,$w,$k,$d])
          <tr>
            <td class="fw7">{{ $p }}</td><td class="text-sm text-muted">{{ $w }}</td>
            <td class="fw7">{{ number_format($k) }}</td>
            <td class="fw7" style="color:var(--g700)">{{ $d }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Detail laporan tabel --}}
<div class="card">
  <div class="card-hd">
    <div class="card-title">📋 Detail Laporan Kunjungan</div>
    <div style="display:flex;gap:7px">
      <button class="btn btn-out btn-sm">📥 CSV</button>
      <button class="btn btn-out btn-sm">📄 PDF</button>
    </div>
  </div>
  <div class="tbl-wrap">
    <table class="tbl">
      <thead><tr><th>Pengelola</th><th>Wisata</th><th>Periode</th><th>Kunjungan</th><th>Tiket</th><th>Camping</th><th>Penginapan</th><th>Sewa Alat</th><th>Total</th></tr></thead>
      <tbody>
        @foreach([
          ['Budi Kusuma','Curug Cimedang','Jun 2025','1.102','Rp 8,24jt','Rp 4,10jt','Rp 2,80jt','Rp 1,40jt','Rp 16,54jt'],
          ['Ridwan Setiadi','Bukit Teletubbies','Jun 2025','824','Rp 5,00jt','Rp 4,80jt','Rp 1,60jt','Rp 1,00jt','Rp 12,40jt'],
          ['Dewi Permata','Pantai Sindangkerta','Jun 2025','611','Rp 3,10jt','Rp 2,40jt','Rp 2,20jt','Rp 1,40jt','Rp 9,10jt'],
          ['M. Fauzi','Situ Gede','Jun 2025','490','Rp 2,45jt','Rp 1,80jt','Rp 1,90jt','Rp 1,15jt','Rp 7,30jt'],
        ] as $r)
        <tr>
          @foreach($r as $i=>$v)
          <td class="{{ $i===0||$i===1?'fw7':'' }} {{ $i===8?'fw7':'text-muted' }}" style="{{ $i===8?'color:var(--g700)':'' }}">{{ $v }}</td>
          @endforeach
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
@push('scripts')
<script>
(function(){
  const vals=[120,145,132,168,189,210,198,224,156,178,134,145,167,190,201,215,178,234,248,260,242,218,190,205,232,248,267,280];
  const max=Math.max(...vals);
  const c=document.getElementById('dailyBars');
  vals.forEach((v,i)=>{
    const b=document.createElement('div');
    b.style.cssText=`flex:1;border-radius:2px 2px 0 0;background:${i===vals.length-1?'var(--o500)':'var(--g500)'};min-width:6px;cursor:pointer;transition:opacity .15s`;
    b.style.height=Math.round(v/max*100)+'%';
    b.title=`Hari ${i+1}: ${v} kunjungan`;
    b.addEventListener('mouseenter',()=>b.style.opacity='.7');
    b.addEventListener('mouseleave',()=>b.style.opacity='1');
    c.appendChild(b);
  });
})();
</script>
@endpush