@extends('layouts.app')
@section('title','Data Wisata')
@section('topbar-title','🏞️ Data Wisata')
@section('content')
<div class="bc"><a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a><span class="bc-sep">›</span><span>Data Wisata</span></div>
<div class="ph">
  <div><h1>🏞️ Data Wisata</h1><p>Kelola semua destinasi wisata yang terdaftar di CitiisGo</p></div>
  <div class="ph-right">
    <button class="btn btn-out btn-sm">📥 Export CSV</button>
    <button class="btn btn-g" onclick="openModal('modalTambahWisata')">➕ Tambah Wisata</button>
  </div>
</div>

<div class="stats">
  <div class="sc" style="--ac:var(--g600)"><div class="sc-lbl">Total Wisata</div><div class="sc-val">67</div><div class="sc-sub sc-up">▲ 4 baru bulan ini</div><div class="sc-ico">🏞️</div></div>
  <div class="sc" style="--ac:var(--g400)"><div class="sc-lbl">Wisata Aktif</div><div class="sc-val">54</div><div class="sc-sub">80.6% dari total</div><div class="sc-ico">✅</div></div>
  <div class="sc" style="--ac:var(--o500)"><div class="sc-lbl">Menunggu Review</div><div class="sc-val">8</div><div class="sc-sub sc-up">▲ 3 pengajuan baru</div><div class="sc-ico">⏳</div></div>
  <div class="sc" style="--ac:var(--r700)"><div class="sc-lbl">Wisata Nonaktif</div><div class="sc-val">5</div><div class="sc-sub">Perlu tindakan</div><div class="sc-ico">❌</div></div>
</div>

<div class="card">
  <div class="card-hd">
    <div class="card-title">Semua Data Wisata</div>
    <div style="display:flex;gap:7px">
      <button class="btn btn-out btn-sm" id="btnGrid" onclick="setView('grid',this)">⊞ Grid</button>
      <button class="btn btn-g btn-sm" id="btnList" onclick="setView('list',this)">☰ List</button>
    </div>
  </div>
  <div class="card-body" style="padding-bottom:0">
    <div class="fbar">
      <form method="GET" action="{{ route('admin.wisata') }}" style="display:contents">
        <div class="si"><span style="font-size:13px;color:var(--tm)">🔍</span><input type="text" name="search" placeholder="Cari nama wisata..." value="{{ request('search') }}"></div>
        <select name="kategori_id" class="sf" onchange="this.form.submit()">
          <option value="">Semua Kategori</option>
          @foreach($kat ?? [['id'=>1,'nama'=>'Alam'],['id'=>2,'nama'=>'Pantai'],['id'=>3,'nama'=>'Gunung'],['id'=>4,'nama'=>'Budaya'],['id'=>5,'nama'=>'Air Terjun']] as $k)
          <option value="{{ $k['id'] }}" {{ request('kategori_id')==$k['id']?'selected':'' }}>{{ $k['nama'] }}</option>
          @endforeach
        </select>
        <select name="status" class="sf" onchange="this.form.submit()">
          <option value="">Semua Status</option>
          <option value="active" {{ request('status')==='active'?'selected':'' }}>✅ Aktif</option>
          <option value="pending" {{ request('status')==='pending'?'selected':'' }}>⏳ Pending</option>
          <option value="inactive" {{ request('status')==='inactive'?'selected':'' }}>❌ Nonaktif</option>
        </select>
        <button type="submit" class="btn btn-out btn-sm">🔍 Cari</button>
        @if(request('search')||request('kategori_id')||request('status'))
          <a href="{{ route('admin.wisata') }}" class="btn btn-ghost btn-sm">✕ Reset</a>
        @endif
      </form>
    </div>
  </div>

  {{-- TABLE VIEW --}}
  <div id="viewList">
    <div class="tbl-wrap">
      <table class="tbl">
        <thead><tr>
          <th style="width:30px"><input type="checkbox" id="selAll" onchange="document.querySelectorAll('.rc').forEach(c=>c.checked=this.checked)"></th>
          <th>Wisata</th><th>Pengelola</th><th>Kategori</th><th>Tiket</th><th>Kuota/hari</th><th>Rating</th><th>Status</th><th>Aksi</th>
        </tr></thead>
        <tbody>
          @php $dummies = [
            ['🏔️','Curug Cimedang','Budi Kusuma','🌿 Alam','Rp 25.000',150,4.8,'active'],
            ['🏖️','Pantai Sindangkerta','Dewi Permata','🌊 Pantai','Rp 10.000',300,4.3,'active'],
            ['⛺','Bukit Teletubbies','Ridwan Setiadi','⛰️ Gunung','Rp 20.000',200,4.7,'pending'],
            ['💧','Situ Gede','Muhammad Fauzi','💧 Danau','Rp 15.000',100,4.6,'active'],
            ['🕌','Kampung Adat Naga','Siti Hartini','🏛️ Budaya','Rp 30.000',80,4.9,'inactive'],
            ['🌊','Curug Dengdeng','Ahmad Setiawan','🌿 Alam','Rp 20.000',120,4.4,'active'],
          ]; @endphp
          @foreach($wisata['data'] ?? $dummies as $w)
          <tr>
            <td><input type="checkbox" class="rc"></td>
            <td>
              <div style="display:flex;align-items:center;gap:10px">
                <div style="width:40px;height:40px;border-radius:9px;background:var(--g50);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">{{ $w[0] }}</div>
                <div>
                  <div class="fw7" style="font-size:13px">{{ $w[1] }}</div>
                  <div class="text-sm text-muted">📍 Tasikmalaya, Jabar</div>
                </div>
              </div>
            </td>
            <td>
              <div style="display:flex;align-items:center;gap:6px">
                <div class="av" style="background:var(--o50);color:var(--o700);font-size:10px">{{ strtoupper(substr($w[2],0,2)) }}</div>
                <span style="font-size:12px">{{ $w[2] }}</span>
              </div>
            </td>
            <td><span class="badge bg-s" style="font-size:10.5px">{{ $w[3] }}</span></td>
            <td class="fw7" style="color:var(--g700)">{{ $w[4] }}</td>
            <td class="text-muted">{{ $w[5] }} org</td>
            <td>
              <div style="display:flex;align-items:center;gap:3px;font-size:12px">
                <span style="color:#FFC107">⭐</span>
                <strong>{{ $w[6] }}</strong>
              </div>
            </td>
            <td>
              @if($w[7]==='active')<span class="badge bg-s">✅ Aktif</span>
              @elseif($w[7]==='pending')<span class="badge bg-w">⏳ Pending</span>
              @else<span class="badge bg-d">❌ Nonaktif</span>@endif
            </td>
            <td>
              <div style="display:flex;gap:4px">
                <button class="btn btn-out btn-xs" title="Detail" onclick="openModal('modalDetailWisata')">👁️</button>
                <button class="btn btn-out btn-xs" title="Edit" onclick="openModal('modalEditWisata')">✏️</button>
                @if($w[7]==='pending')
                  <button class="btn btn-g btn-xs" title="Setujui">✅</button>
                  <button class="btn btn-red btn-xs" title="Tolak">❌</button>
                @else
                  <button class="btn btn-red btn-xs" title="Hapus" onclick="return confirm('Hapus wisata ini?')">🗑️</button>
                @endif
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- GRID VIEW --}}
  <div id="viewGrid" style="display:none;padding:16px">
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:14px">
      @foreach($wisata['data'] ?? $dummies as $w)
      <div style="border:1px solid var(--border);border-radius:12px;overflow:hidden;transition:box-shadow .15s;background:#fff" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.08)'" onmouseout="this.style.boxShadow='none'">
        <div style="height:100px;background:linear-gradient(135deg,var(--g700),var(--g600));display:flex;align-items:center;justify-content:center;font-size:40px;position:relative">
          {{ $w[0] }}
          <span class="badge {{ $w[7]==='active'?'bg-s':($w[7]==='pending'?'bg-w':'bg-d') }}" style="position:absolute;top:8px;right:8px;font-size:9.5px">{{ ucfirst($w[7]) }}</span>
        </div>
        <div style="padding:12px">
          <div class="fw7" style="font-size:13.5px;margin-bottom:3px">{{ $w[1] }}</div>
          <div style="font-size:11px;color:var(--tm);margin-bottom:8px">📍 Tasikmalaya · {{ $w[3] }}</div>
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
            <span class="fw7" style="color:var(--g700);font-size:13px">{{ $w[4] }}</span>
            <span style="font-size:11.5px;color:var(--tm)">⭐ {{ $w[6] }}</span>
          </div>
          <div style="display:flex;gap:5px">
            <button class="btn btn-out btn-xs" style="flex:1" onclick="openModal('modalDetailWisata')">👁️ Detail</button>
            <button class="btn btn-out btn-xs" onclick="openModal('modalEditWisata')">✏️</button>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <div class="card-ft">
    <span class="text-sm text-muted">Menampilkan <strong>1–{{ count($wisata['data'] ?? $dummies) }}</strong> dari <strong>67</strong> wisata</span>
    <div class="pg">
      <button class="pb">‹</button>
      <button class="pb a">1</button><button class="pb">2</button><button class="pb">3</button><button class="pb">4</button><button class="pb">5</button>
      <button class="pb">›</button>
    </div>
  </div>
</div>

{{-- MODAL TAMBAH WISATA --}}
<div class="modal-bg" id="modalTambahWisata">
  <div class="modal modal-lg">
    <div class="modal-hd"><div class="modal-t">🏞️ Tambah Wisata Baru</div><button class="modal-x" onclick="closeModal('modalTambahWisata')">✕</button></div>
    <form action="{{ route('admin.wisata.store') }}" method="POST">
      @csrf
      <div class="modal-bd">
        <div class="fr">
          <div class="fg"><label class="fl">Nama Wisata <span class="req">*</span></label><input name="nama" class="fc" placeholder="Nama destinasi wisata" required></div>
          <div class="fg"><label class="fl">Kategori <span class="req">*</span></label>
            <select name="kategori_id" class="fc" required>
              <option value="">-- Pilih Kategori --</option>
              @foreach($kat ?? [['id'=>1,'nama'=>'Alam'],['id'=>2,'nama'=>'Pantai'],['id'=>3,'nama'=>'Gunung'],['id'=>4,'nama'=>'Budaya']] as $k)
              <option value="{{ $k['id'] }}">{{ $k['nama'] }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="fg"><label class="fl">Pengelola <span class="req">*</span></label>
          <select name="pengelola_id" class="fc" required>
            <option value="">-- Pilih Pengelola --</option>
            <option value="2">Budi Kusuma</option>
            <option value="5">Dewi Permata</option>
            <option value="6">Ridwan Setiadi</option>
          </select>
        </div>
        <div class="fg"><label class="fl">Deskripsi <span class="req">*</span></label><textarea name="deskripsi" class="fc" rows="3" style="resize:vertical" required placeholder="Deskripsi lengkap wisata..."></textarea></div>
        <div class="fg"><label class="fl">Alamat Lengkap <span class="req">*</span></label><input name="alamat" class="fc" placeholder="Kec. ..., Kab. ..., Provinsi" required></div>
        <div class="fr3">
          <div class="fg"><label class="fl">Latitude</label><input name="latitude" class="fc" placeholder="-7.3842"></div>
          <div class="fg"><label class="fl">Longitude</label><input name="longitude" class="fc" placeholder="108.1247"></div>
          <div class="fg"><label class="fl">Status</label>
            <select name="status" class="fc">
              <option value="active">✅ Aktif</option>
              <option value="pending">⏳ Pending Review</option>
              <option value="inactive">❌ Nonaktif</option>
            </select>
          </div>
        </div>
        <div class="fr">
          <div class="fg"><label class="fl">Harga Tiket (Rp) <span class="req">*</span></label><input name="harga_tiket" type="number" class="fc" placeholder="25000" min="0" required></div>
          <div class="fg"><label class="fl">Kuota Harian (orang) <span class="req">*</span></label><input name="kuota_harian" type="number" class="fc" placeholder="150" min="1" required></div>
        </div>
      </div>
      <div class="modal-ft"><button type="button" class="btn btn-out" onclick="closeModal('modalTambahWisata')">Batal</button><button type="submit" class="btn btn-g">💾 Simpan Wisata</button></div>
    </form>
  </div>
</div>

{{-- MODAL DETAIL WISATA --}}
<div class="modal-bg" id="modalDetailWisata">
  <div class="modal modal-lg">
    <div class="modal-hd"><div class="modal-t">👁️ Detail Wisata</div><button class="modal-x" onclick="closeModal('modalDetailWisata')">✕</button></div>
    <div class="modal-bd">
      <div style="background:linear-gradient(135deg,var(--g700),var(--g600));border-radius:10px;padding:16px;margin-bottom:16px;display:flex;align-items:center;gap:14px;color:#fff">
        <span style="font-size:36px">🏔️</span>
        <div><div style="font-size:16px;font-weight:700">Curug Cimedang</div><div style="font-size:11.5px;opacity:.7">📍 Cikatomas, Tasikmalaya · 🌿 Alam</div></div>
        <span class="badge bg-s" style="margin-left:auto">✅ Aktif</span>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px">
        @foreach([['Pengelola','Budi Kusuma'],['Harga Tiket','Rp 25.000'],['Kuota Harian','150 orang'],['Rating','⭐ 4.8 (128 ulasan)'],['Total Kunjungan','1.102 tamu/bln'],['Total Pendapatan','Rp 16,5jt/bln']] as [$k,$v])
        <div style="background:var(--bg);border-radius:9px;padding:11px 13px">
          <div style="font-size:10px;color:var(--tm);font-weight:600;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px">{{ $k }}</div>
          <div class="fw7" style="font-size:13px">{{ $v }}</div>
        </div>
        @endforeach
      </div>
      <div class="fg"><label class="fl">Deskripsi</label>
        <div style="background:var(--bg);border-radius:9px;padding:11px 13px;font-size:12.5px;color:var(--t2);line-height:1.6">Air terjun indah tersembunyi di antara hijaunya hutan tropis Tasikmalaya. Dengan ketinggian 25 meter, menawarkan pemandangan memukau.</div>
      </div>
    </div>
    <div class="modal-ft"><button type="button" class="btn btn-out" onclick="closeModal('modalDetailWisata')">Tutup</button><button class="btn btn-g" onclick="closeModal('modalDetailWisata');openModal('modalEditWisata')">✏️ Edit</button></div>
  </div>
</div>

{{-- MODAL EDIT WISATA --}}
<div class="modal-bg" id="modalEditWisata">
  <div class="modal modal-lg">
    <div class="modal-hd"><div class="modal-t">✏️ Edit Wisata</div><button class="modal-x" onclick="closeModal('modalEditWisata')">✕</button></div>
    <form action="{{ route('admin.wisata.update',['id'=>1]) }}" method="POST">
      @csrf @method('PUT')
      <div class="modal-bd">
        <div class="fr">
          <div class="fg"><label class="fl">Nama Wisata</label><input name="nama" class="fc" value="Curug Cimedang"></div>
          <div class="fg"><label class="fl">Status</label>
            <select name="status" class="fc">
              <option value="active" selected>✅ Aktif</option>
              <option value="pending">⏳ Pending</option>
              <option value="inactive">❌ Nonaktif</option>
            </select>
          </div>
        </div>
        <div class="fr">
          <div class="fg"><label class="fl">Harga Tiket (Rp)</label><input name="harga_tiket" type="number" class="fc" value="25000"></div>
          <div class="fg"><label class="fl">Kuota Harian</label><input name="kuota_harian" type="number" class="fc" value="150"></div>
        </div>
        <div class="fg"><label class="fl">Kategori</label>
          <select name="kategori_id" class="fc">
            <option value="1" selected>🌿 Alam</option><option value="2">🌊 Pantai</option>
          </select>
        </div>
        <div class="fg"><label class="fl">Deskripsi</label><textarea name="deskripsi" class="fc" rows="3" style="resize:vertical">Air terjun indah di Tasikmalaya.</textarea></div>
        <div class="fg"><label class="fl">Alamat</label><input name="alamat" class="fc" value="Desa Cikatomas, Kec. Cikatomas, Tasikmalaya"></div>
      </div>
      <div class="modal-ft"><button type="button" class="btn btn-out" onclick="closeModal('modalEditWisata')">Batal</button><button type="submit" class="btn btn-g">💾 Update Wisata</button></div>
    </form>
  </div>
</div>
@endsection
@push('scripts')
<script>
function setView(v,btn){
  document.getElementById('viewList').style.display=v==='list'?'block':'none';
  document.getElementById('viewGrid').style.display=v==='grid'?'block':'none';
  document.getElementById('btnGrid').className='btn btn-'+(v==='grid'?'g':'out')+' btn-sm';
  document.getElementById('btnList').className='btn btn-'+(v==='list'?'g':'out')+' btn-sm';
}
</script>
@endpush