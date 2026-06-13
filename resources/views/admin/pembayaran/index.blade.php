@extends('layouts.app')
@section('title','Pembayaran')
@section('topbar-title','💳 Manajemen Pembayaran')
@section('content')
<div class="bc"><a href="{{ route('admin.dashboard') }}">🏠</a><span class="bc-sep">›</span><span>Pembayaran</span></div>
<div class="ph">
  <div><h1>💳 Manajemen Pembayaran</h1><p>Monitor semua transaksi pembayaran CitiisGo</p></div>
  <div class="ph-right"><button class="btn btn-out btn-sm">📥 Export Excel</button><button class="btn btn-out btn-sm">📄 Export PDF</button></div>
</div>

<div class="stats">
  <div class="sc" style="--ac:var(--g600)"><div class="sc-lbl">Total Pendapatan</div><div class="sc-val">Rp 48,2jt</div><div class="sc-sub sc-up">▲ 18.7% bulan ini</div><div class="sc-ico">💰</div></div>
  <div class="sc" style="--ac:var(--b700)"><div class="sc-lbl">Transaksi Lunas</div><div class="sc-val">1.024</div><div class="sc-sub sc-up">▲ 12.1%</div><div class="sc-ico">✅</div></div>
  <div class="sc" style="--ac:var(--o500)"><div class="sc-lbl">Menunggu Bayar</div><div class="sc-val">47</div><div class="sc-sub sc-dn">Perlu follow-up</div><div class="sc-ico">⏳</div></div>
  <div class="sc" style="--ac:var(--r700)"><div class="sc-lbl">Gagal / Expired</div><div class="sc-val">23</div><div class="sc-sub sc-dn">▲ 5 kasus</div><div class="sc-ico">❌</div></div>
</div>

<div class="g2" style="margin-bottom:16px">
  <div class="card" style="margin-bottom:0">
    <div class="card-hd"><div class="card-title">💰 Pendapatan per Layanan</div></div>
    <div class="card-body">
      @foreach([['🎫 Reservasi Tiket','Rp 18,4jt',72,'var(--g600)'],['⛺ Booking Camping','Rp 12,8jt',50,'var(--o500)'],['🏨 Booking Penginapan','Rp 10,5jt',41,'var(--b700)'],['🎒 Sewa Peralatan','Rp 6,5jt',25,'var(--p700)']] as [$lbl,$val,$pct,$clr])
      <div style="margin-bottom:12px">
        <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:5px">
          <span>{{ $lbl }}</span><strong style="color:{{ $clr }}">{{ $val }}</strong>
        </div>
        <div class="progress"><div class="progress-fill" style="width:{{ $pct }}%;background:{{ $clr }}"></div></div>
      </div>
      @endforeach
      <div style="border-top:1px solid var(--border);padding-top:10px;display:flex;justify-content:space-between;font-size:13px;font-weight:700">
        <span>Total</span><span style="color:var(--g700)">Rp 48,2jt</span>
      </div>
    </div>
  </div>
  <div class="card" style="margin-bottom:0">
    <div class="card-hd"><div class="card-title">📊 Metode Pembayaran</div></div>
    <div class="card-body" style="padding:0">
      @foreach([['💳','Transfer Bank','524','Rp 22,1jt','var(--b700)'],['📱','QRIS','312','Rp 14,8jt','var(--g600)'],['💰','GoPay/OVO/Dana','188','Rp 11,3jt','var(--o500)']] as [$ico,$metode,$jml,$total,$clr])
      <div style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-bottom:1px solid var(--border)">
        <div style="width:38px;height:38px;border-radius:9px;background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">{{ $ico }}</div>
        <div style="flex:1"><div class="fw7" style="font-size:13px">{{ $metode }}</div><div class="text-sm text-muted">{{ $jml }} transaksi</div></div>
        <div style="text-align:right"><div class="fw7" style="color:{{ $clr }}">{{ $total }}</div></div>
      </div>
      @endforeach
    </div>
  </div>
</div>

<div class="card">
  <div class="card-hd"><div class="card-title">📋 Riwayat Transaksi</div></div>
  <div class="card-body" style="padding-bottom:0">
    <div class="fbar">
      <form method="GET" action="{{ route('admin.pembayaran') }}" style="display:contents">
        <div class="si"><span style="font-size:13px;color:var(--tm)">🔍</span><input type="text" name="search" placeholder="Cari kode, nama user..." value="{{ request('search') }}"></div>
        <select name="ref_type" class="sf" onchange="this.form.submit()">
          <option value="">Semua Layanan</option>
          <option value="reservasi" {{ request('ref_type')==='reservasi'?'selected':'' }}>🎫 Reservasi Tiket</option>
          <option value="booking_camping" {{ request('ref_type')==='booking_camping'?'selected':'' }}>⛺ Booking Camping</option>
          <option value="booking_penginapan" {{ request('ref_type')==='booking_penginapan'?'selected':'' }}>🏨 Booking Penginapan</option>
          <option value="sewa_peralatan" {{ request('ref_type')==='sewa_peralatan'?'selected':'' }}>🎒 Sewa Peralatan</option>
        </select>
        <select name="status" class="sf" onchange="this.form.submit()">
          <option value="">Semua Status</option>
          <option value="paid">✅ Lunas</option>
          <option value="pending">⏳ Pending</option>
          <option value="failed">❌ Gagal</option>
          <option value="expired">⌛ Expired</option>
          <option value="refunded">↩️ Refund</option>
        </select>
        <input type="date" name="dari" class="sf" value="{{ request('dari',now()->startOfMonth()->format('Y-m-d')) }}">
        <span class="text-muted text-sm">s/d</span>
        <input type="date" name="sampai" class="sf" value="{{ request('sampai',now()->format('Y-m-d')) }}">
        <button type="submit" class="btn btn-g btn-sm">🔍 Filter</button>
      </form>
    </div>
  </div>
  <div class="tbl-wrap">
    <table class="tbl">
      <thead><tr><th>Kode Transaksi</th><th>Wisatawan</th><th>Layanan</th><th>Wisata</th><th>Metode</th><th>Jumlah</th><th>Status</th><th>Waktu</th><th>Aksi</th></tr></thead>
      <tbody>
        @foreach($pembayaran['data'] ?? [
          ['PAY-20250601-001','Budi Santoso','reservasi','Curug Cimedang','QRIS','Rp 75.000','paid','01 Jun 14:22'],
          ['PAY-20250601-002','Siti Rahma','booking_camping','Bukit Teletubbies','Transfer BCA','Rp 700.000','pending','01 Jun 15:45'],
          ['PAY-20250601-003','Ahmad Fauzi','booking_penginapan','Situ Gede Resort','GoPay','Rp 450.000','paid','01 Jun 16:10'],
          ['PAY-20250601-004','Dewi Kurnia','sewa_peralatan','Curug Dengdeng','QRIS','Rp 240.000','failed','01 Jun 17:03'],
          ['PAY-20250601-005','Rudi Setiawan','reservasi','Pantai Sindangkerta','OVO','Rp 50.000','refunded','01 Jun 18:30'],
          ['PAY-20250601-006','Hana Fitriani','booking_camping','Bukit Teletubbies','Transfer BRI','Rp 500.000','paid','01 Jun 20:15'],
        ] as $p)
        @php
          $layananLabel = ['reservasi'=>['🎫','Tiket','bg-s'],'booking_camping'=>['⛺','Camping','bg-w'],'booking_penginapan'=>['🏨','Penginapan','bg-i'],'sewa_peralatan'=>['🎒','Sewa Alat','bg-p']];
          $ll = $layananLabel[$p[2]] ?? ['📄',$p[2],'bg-y'];
          $statusBadge = ['paid'=>['bg-s','✅ Lunas'],'pending'=>['bg-w','⏳ Pending'],'failed'=>['bg-d','❌ Gagal'],'expired'=>['bg-d','⌛ Expired'],'refunded'=>['bg-i','↩️ Refund']];
          $sb = $statusBadge[$p[6]] ?? ['bg-y',$p[6]];
        @endphp
        <tr>
          <td><span class="mono">{{ $p[0] }}</span></td>
          <td class="fw7">{{ $p[1] }}</td>
          <td><span class="badge {{ $ll[2] }}">{{ $ll[0] }} {{ $ll[1] }}</span></td>
          <td class="text-muted text-sm">{{ $p[3] }}</td>
          <td class="text-sm">{{ $p[4] }}</td>
          <td class="fw7" style="color:{{ $p[6]==='paid'?'var(--g700)':($p[6]==='failed'?'var(--r700)':'var(--t2)') }}">{{ $p[5] }}</td>
          <td><span class="badge {{ $sb[0] }}">{{ $sb[1] }}</span></td>
          <td class="text-muted text-sm">{{ $p[7] }}</td>
          <td><a href="{{ route('admin.pembayaran.show',['id'=>1]) }}" class="btn btn-out btn-xs">Detail</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="card-ft">
    <span class="text-sm text-muted">Menampilkan <strong>1–10</strong> dari <strong>1.094</strong> transaksi</span>
    <div class="pg">
      <button class="pb">‹</button><button class="pb a">1</button><button class="pb">2</button><button class="pb">3</button><button class="pb">...</button><button class="pb">110</button><button class="pb">›</button>
    </div>
  </div>
</div>
@endsection