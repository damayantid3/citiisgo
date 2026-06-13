@extends('layouts.app')
@section('title','Kelola Wisata')
@section('topbar-title','🏔️ Kelola Wisata Saya')
@section('content')
<div class="bc"><a href="{{ route('pengelola.dashboard') }}">🏠 Dashboard</a><span class="bc-sep">›</span><span>Kelola Wisata</span></div>
<div class="ph">
  <div><h1>🏔️ Kelola Data Wisata</h1><p>Edit informasi, galeri foto, dan fasilitas wisata Anda</p></div>
  <div class="ph-right">
    <button class="btn btn-out btn-sm" onclick="window.open('#','_blank')">👁️ Preview Publik</button>
    <button class="btn btn-g" onclick="document.getElementById('formSave').submit()">💾 Simpan Perubahan</button>
  </div>
</div>

@php $w = $wisata['data'] ?? ['nama'=>'Curug Cimedang','deskripsi'=>'Air terjun indah tersembunyi di antara hijaunya hutan tropis Tasikmalaya. Dengan ketinggian 25 meter, menawarkan pemandangan memukau dan udara sejuk yang menyegarkan.','alamat'=>'Desa Cikatomas, Kec. Cikatomas, Tasikmalaya, Jawa Barat','latitude'=>'-7.3842','longitude'=>'108.1247','harga_tiket'=>25000,'kuota_harian'=>150,'status'=>'active']; @endphp

<div class="g2">
  {{-- KIRI: Info dasar --}}
  <div>
    <div class="card">
      <div class="card-hd"><div class="card-title">📋 Informasi Dasar</div></div>
      <div class="card-body">
        <form action="{{ route('pengelola.wisata.update') }}" method="POST" id="formSave">
          @csrf @method('PUT')
          <div class="fg"><label class="fl">Nama Wisata <span class="req">*</span></label>
            <input name="nama" class="fc" value="{{ $w['nama'] }}" required></div>
          <div class="fg"><label class="fl">Kategori</label>
            <select name="kategori_id" class="fc">
              <option value="1" selected>🌿 Alam</option><option value="2">🌊 Pantai</option>
              <option value="3">⛰️ Gunung</option><option value="4">🏛️ Budaya</option><option value="5">💧 Air Terjun</option>
            </select></div>
          <div class="fg"><label class="fl">Deskripsi</label>
            <textarea name="deskripsi" class="fc" rows="4" style="resize:vertical">{{ $w['deskripsi'] }}</textarea></div>
          <div class="fg"><label class="fl">Alamat Lengkap</label>
            <input name="alamat" class="fc" value="{{ $w['alamat'] }}"></div>
          <div class="fr"><div class="fg"><label class="fl">Latitude</label><input name="latitude" class="fc" value="{{ $w['latitude'] ?? '' }}" placeholder="-7.3842"></div>
            <div class="fg"><label class="fl">Longitude</label><input name="longitude" class="fc" value="{{ $w['longitude'] ?? '' }}" placeholder="108.1247"></div></div>
          <div class="fr"><div class="fg"><label class="fl">Harga Tiket (Rp)</label><input name="harga_tiket" type="number" class="fc" value="{{ $w['harga_tiket'] }}" min="0"></div>
            <div class="fg"><label class="fl">Kuota Harian (orang)</label><input name="kuota_harian" type="number" class="fc" value="{{ $w['kuota_harian'] }}" min="1"></div></div>
          <div class="fg"><label class="fl">Status Wisata</label>
            <select name="status" class="fc">
              <option value="active" {{ ($w['status']??'')=='active'?'selected':'' }}>✅ Aktif — tampil & dapat dipesan</option>
              <option value="inactive" {{ ($w['status']??'')=='inactive'?'selected':'' }}>⏸️ Nonaktif — sembunyikan sementara</option>
            </select></div>
          <div class="fg"><label class="fl">Jam Operasional</label>
            <div style="display:flex;gap:10px;align-items:center">
              <input type="time" name="jam_buka" class="fc" value="07:00" style="flex:1">
              <span style="color:var(--tm);font-weight:700;flex-shrink:0">s/d</span>
              <input type="time" name="jam_tutup" class="fc" value="17:00" style="flex:1">
            </div></div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-hd"><div class="card-title">🗺️ Lokasi Peta</div><a href="https://maps.google.com?q={{ $w['latitude']??0 }},{{ $w['longitude']??0 }}" target="_blank" class="btn btn-out btn-sm">Buka Maps</a></div>
      <div class="card-body" style="padding:12px">
        <div style="background:linear-gradient(135deg,#e8f5e9,#c8e6c9);border-radius:10px;height:150px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;color:var(--g700)">
          <span style="font-size:36px">🗺️</span>
          <span style="font-weight:700;font-size:13px">{{ $w['nama'] }}</span>
          <span style="font-size:11px;color:var(--t2)">{{ $w['latitude'] }}, {{ $w['longitude'] }}</span>
        </div>
      </div>
    </div>
  </div>

  {{-- KANAN: Galeri & Fasilitas --}}
  <div>
    <div class="card">
      <div class="card-hd"><div class="card-title">📸 Galeri Foto</div>
        <button class="btn btn-g btn-sm" onclick="openModal('modalFoto')">➕ Upload Foto</button></div>
      <div class="card-body">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px" id="galeriGrid">
          @foreach([['🏔️',true],['💧',false],['🌿',false],['🌅',false],['🏕️',false]] as [$ico,$cover])
          <div style="aspect-ratio:1;border-radius:10px;border:{{ $cover?'2px solid var(--g600)':'1px solid var(--border)' }};overflow:hidden;position:relative;background:{{ $cover?'var(--g50)':'#f7f7f7' }};display:flex;align-items:center;justify-content:center;font-size:28px">
            {{ $ico }}
            @if($cover)<div style="position:absolute;bottom:4px;left:4px;background:var(--g700);color:#fff;font-size:9px;font-weight:700;padding:2px 6px;border-radius:4px">COVER</div>@endif
            <form action="{{ route('pengelola.wisata.galeri.delete',['id'=>$loop->index+1]) }}" method="POST" style="position:absolute;top:4px;right:4px">
              @csrf @method('DELETE')
              <button type="submit" onclick="return confirm('Hapus foto?')" style="width:22px;height:22px;background:rgba(198,40,40,.85);border:none;border-radius:5px;color:#fff;cursor:pointer;font-size:12px">✕</button>
            </form>
          </div>
          @endforeach
          <div style="aspect-ratio:1;border-radius:10px;border:2px dashed var(--border);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:5px;cursor:pointer;font-size:22px;color:var(--tm);transition:all .15s" onclick="openModal('modalFoto')" onmouseover="this.style.borderColor='var(--g600)';this.style.color='var(--g700)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--tm)'">
            ➕<span style="font-size:10px">Tambah</span></div>
        </div>
        <div class="fhint" style="margin-top:9px">💡 Foto dengan label COVER tampil sebagai foto utama. Maks 4MB/foto.</div>
      </div>
    </div>

    <div class="card">
      <div class="card-hd"><div class="card-title">🏕️ Fasilitas Wisata</div>
        <button class="btn btn-g btn-sm" onclick="openModal('modalFasilitas')">➕ Tambah</button></div>
      <div class="card-body">
        <div style="display:flex;flex-wrap:wrap;gap:8px" id="fasWrap">
          @foreach(['🅿️ Parkir','🚻 Toilet','🍴 Warung Makan','📶 WiFi','🏕️ Area Camping','🏨 Penginapan','🎒 Sewa Peralatan','🚑 P3K','🕌 Mushola','♿ Akses Difabel'] as $f)
          <div class="fac-chip" style="display:flex;align-items:center;gap:6px;padding:6px 11px;background:var(--g50);border:1px solid var(--g100);border-radius:8px;font-size:12px;color:var(--g700);font-weight:600">
            {{ $f }}<span onclick="this.parentElement.remove()" style="cursor:pointer;color:var(--r700);margin-left:2px;font-size:15px;line-height:1">×</span>
          </div>
          @endforeach
        </div>
      </div>
    </div>

    {{-- Info statistik singkat --}}
    <div class="card">
      <div class="card-hd"><div class="card-title">📊 Statistik Singkat</div></div>
      <div class="card-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
          @foreach([['⭐','Rating','4.8 / 5.0','dari 128 ulasan'],['👁️','Total Dilihat','2.841','kali bulan ini'],['🎫','Total Kunjungan','1.102','tamu bulan ini'],['💰','Total Pendapatan','Rp 16,5jt','bulan ini']] as [$ico,$lbl,$val,$sub])
          <div style="background:var(--bg);border-radius:10px;padding:12px;text-align:center">
            <div style="font-size:22px;margin-bottom:4px">{{ $ico }}</div>
            <div style="font-size:10px;color:var(--tm);text-transform:uppercase;letter-spacing:.5px;font-weight:600">{{ $lbl }}</div>
            <div style="font-size:16px;font-weight:800;color:var(--t1);margin:3px 0">{{ $val }}</div>
            <div style="font-size:10.5px;color:var(--tm)">{{ $sub }}</div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal Upload Foto --}}
<div class="modal-bg" id="modalFoto">
  <div class="modal"><div class="modal-hd"><div class="modal-t">📷 Upload Foto Galeri</div><button class="modal-x" onclick="closeModal('modalFoto')">✕</button></div>
    <form action="{{ route('pengelola.wisata.galeri.upload') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-bd">
        <div class="fg">
          <div style="border:2px dashed var(--border);border-radius:10px;padding:24px;text-align:center;cursor:pointer;transition:all .15s" id="dropArea" onclick="document.getElementById('fotoIn').click()" onmouseover="this.style.borderColor='var(--g600)'" onmouseout="this.style.borderColor='var(--border)'">
            <div style="font-size:36px;margin-bottom:8px">📷</div>
            <div style="font-size:13px;font-weight:600;color:var(--t2)">Klik untuk pilih foto</div>
            <div style="font-size:11.5px;color:var(--tm);margin-top:3px">JPG, PNG, WebP — Maks 4MB</div>
          </div>
          <input type="file" name="foto" id="fotoIn" accept="image/*" style="display:none" onchange="prvFoto(this)">
          <img id="prvImg" style="display:none;width:100%;border-radius:8px;margin-top:10px;max-height:180px;object-fit:cover">
        </div>
        <div class="fg"><label class="fl">Keterangan Foto</label><input name="keterangan" class="fc" placeholder="Mis: Pemandangan air terjun dari atas"></div>
        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;padding:10px;background:var(--g50);border-radius:9px;border:1px solid var(--g100)">
          <input type="checkbox" name="is_cover" value="1" style="accent-color:var(--g600);width:15px;height:15px">
          <span style="font-size:13px;font-weight:600;color:var(--g700)">⭐ Jadikan foto cover utama wisata ini</span>
        </label>
      </div>
      <div class="modal-ft"><button type="button" class="btn btn-out" onclick="closeModal('modalFoto')">Batal</button><button type="submit" class="btn btn-g">📤 Upload</button></div>
    </form>
  </div>
</div>

{{-- Modal Fasilitas --}}
<div class="modal-bg" id="modalFasilitas">
  <div class="modal" style="width:400px"><div class="modal-hd"><div class="modal-t">🏕️ Tambah Fasilitas</div><button class="modal-x" onclick="closeModal('modalFasilitas')">✕</button></div>
    <div class="modal-bd">
      <div class="fg"><label class="fl">Pilih Ikon</label>
        <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:10px" id="iconPicker">
          @foreach(['🅿️','🚻','🍴','📶','🏕️','🏨','🎒','🚑','🕌','♿','🚿','⚡','🌡️','🎪','🛡️'] as $ico)
          <span onclick="selectIcon('{{ $ico }}')" style="font-size:22px;width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:8px;border:1px solid var(--border);cursor:pointer;transition:all .12s" class="ico-pick">{{ $ico }}</span>
          @endforeach
        </div>
        <input class="fc" id="selIcon" placeholder="Atau ketik emoji ikon..." style="font-size:18px;text-align:center">
      </div>
      <div class="fg"><label class="fl">Nama Fasilitas <span class="req">*</span></label><input class="fc" id="fasNama" placeholder="Mis: Area Parkir Motor"></div>
      <div class="fg"><label class="fl">Status</label>
        <select class="fc" id="fasStatus"><option value="1">✅ Tersedia</option><option value="0">❌ Tidak Tersedia</option></select>
      </div>
    </div>
    <div class="modal-ft"><button type="button" class="btn btn-out" onclick="closeModal('modalFasilitas')">Batal</button><button type="button" class="btn btn-g" onclick="addFasilitas()">➕ Tambah Fasilitas</button></div>
  </div>
</div>
@endsection
@push('scripts')
<script>
function prvFoto(i){if(i.files&&i.files[0]){const r=new FileReader();r.onload=e=>{const img=document.getElementById('prvImg');img.src=e.target.result;img.style.display='block'};r.readAsDataURL(i.files[0])}}
function selectIcon(ico){document.getElementById('selIcon').value=ico;document.querySelectorAll('.ico-pick').forEach(e=>e.style.background='');event.target.style.background='var(--g50)';event.target.style.borderColor='var(--g600)'}
function addFasilitas(){
  const ico=document.getElementById('selIcon').value||'✅';
  const nama=document.getElementById('fasNama').value.trim();
  if(!nama)return alert('Nama fasilitas wajib diisi!');
  const chip=document.createElement('div');
  chip.className='fac-chip';
  chip.style.cssText='display:flex;align-items:center;gap:6px;padding:6px 11px;background:var(--g50);border:1px solid var(--g100);border-radius:8px;font-size:12px;color:var(--g700);font-weight:600';
  chip.innerHTML=`${ico} ${nama}<span onclick="this.parentElement.remove()" style="cursor:pointer;color:var(--r700);margin-left:2px;font-size:15px;line-height:1">×</span>`;
  document.getElementById('fasWrap').appendChild(chip);
  closeModal('modalFasilitas');
  document.getElementById('selIcon').value='';document.getElementById('fasNama').value='';
}
</script>
@endpush