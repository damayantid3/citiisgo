{{-- ============================================================
     ADMIN KATEGORI — resources/views/admin/kategori/index.blade.php
     ============================================================ --}}
@extends('layouts.app')
@section('title','Kategori Wisata')
@section('topbar-title','🏷️ Kategori Wisata')
@section('content')
<div class="bc"><a href="{{ route('admin.dashboard') }}">🏠</a><span class="bc-sep">›</span><span>Kategori Wisata</span></div>
<div class="ph"><div><h1>🏷️ Kategori Wisata</h1><p>Kelola kategori dan klasifikasi destinasi wisata</p></div></div>

<div class="g2">
  {{-- FORM TAMBAH / EDIT --}}
  <div class="card" style="margin-bottom:0">
    <div class="card-hd"><div class="card-title" id="formKatTitle">➕ Tambah Kategori Baru</div></div>
    <div class="card-body">
      <form action="{{ route('admin.kategori.store') }}" method="POST" id="formKategori">
        @csrf
        <input type="hidden" name="_method" id="katMethod" value="POST">
        <input type="hidden" name="kategori_id" id="katId">
        <div class="fg">
          <label class="fl">Ikon (emoji) <span class="req">*</span></label>
          <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:8px">
            @foreach(['🌿','🌊','⛰️','🏛️','💧','🍽️','🏊','🌸','🎢','🦁','🏄','🚵'] as $ico)
            <span onclick="selectEmoji('{{ $ico }}')" style="font-size:22px;width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:8px;border:1px solid var(--border);cursor:pointer;transition:all .12s" class="emo-pick" onmouseover="this.style.background='var(--g50)'" onmouseout="if(!this.classList.contains('sel'))this.style.background='transparent'">{{ $ico }}</span>
            @endforeach
          </div>
          <input name="ikon" id="katIkon" class="fc" placeholder="Atau ketik emoji..." style="text-align:center;font-size:18px">
        </div>
        <div class="fg"><label class="fl">Nama Kategori <span class="req">*</span></label><input name="nama" id="katNama" class="fc" placeholder="Mis: Wisata Bahari" required></div>
        <div class="fg"><label class="fl">Deskripsi</label><textarea name="deskripsi" id="katDesc" class="fc" rows="3" style="resize:vertical" placeholder="Deskripsi singkat kategori..."></textarea></div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
          <button type="button" class="btn btn-out" onclick="resetKatForm()">🔄 Reset</button>
          <button type="submit" class="btn btn-g">💾 Simpan Kategori</button>
        </div>
      </form>
    </div>
  </div>

  {{-- DAFTAR KATEGORI --}}
  <div class="card" style="margin-bottom:0">
    <div class="card-hd"><div class="card-title">📋 Daftar Kategori</div><span class="text-muted text-sm">{{ count($kategori ?? []) ?: 12 }} kategori</span></div>
    <div class="tbl-wrap">
      <table class="tbl">
        <thead><tr><th>Ikon</th><th>Nama</th><th>Deskripsi</th><th>Wisata</th><th>Aksi</th></tr></thead>
        <tbody>
          @foreach($kategori ?? [
            ['1','🌿','Alam','Destinasi wisata alam terbuka',24],
            ['2','🌊','Pantai','Wisata pesisir dan bahari',12],
            ['3','⛰️','Gunung','Pendakian dan pemandangan pegunungan',8],
            ['4','🏛️','Budaya','Warisan budaya dan sejarah',7],
            ['5','💧','Air Terjun','Curug dan air terjun alami',9],
            ['6','🍽️','Kuliner','Wisata kuliner dan gastronomi',5],
            ['7','🏊','Kolam Renang','Wahana air dan kolam renang',3],
            ['8','🌸','Taman Bunga','Taman bunga dan kebun',4],
          ] as $k)
          @php $isArr = is_array($k) && isset($k[0]); @endphp
          <tr>
            <td style="font-size:22px">{{ $isArr ? $k[1] : $k['ikon'] }}</td>
            <td class="fw7">{{ $isArr ? $k[2] : $k['nama'] }}</td>
            <td class="text-muted text-sm" style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $isArr ? $k[3] : ($k['deskripsi']??'-') }}</td>
            <td><span class="badge bg-s" style="font-size:10px">{{ $isArr ? $k[4] : $k['wisata_count'] }} wisata</span></td>
            <td>
              <div style="display:flex;gap:4px">
                <button class="btn btn-out btn-xs" onclick="editKat('{{ $isArr?$k[0]:$k['id'] }}','{{ $isArr?$k[1]:$k['ikon'] }}','{{ $isArr?$k[2]:$k['nama'] }}','{{ $isArr?$k[3]:($k['deskripsi']??'') }}')">✏️</button>
                <form action="{{ route('admin.kategori.destroy',['id'=>$isArr?$k[0]:$k['id']]) }}" method="POST" style="margin:0">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-red btn-xs" onclick="return confirm('Hapus kategori ini?')">🗑️</button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Statistik penggunaan kategori --}}
<div class="card">
  <div class="card-hd"><div class="card-title">📊 Kunjungan per Kategori (Bulan Ini)</div></div>
  <div class="card-body">
    <div style="display:flex;flex-direction:column;gap:10px">
      @foreach([['🌿 Alam',1102,72,'var(--g600)'],['⛰️ Gunung',824,54,'var(--b700)'],['🌊 Pantai',611,40,'var(--o500)'],['💧 Air Terjun',490,32,'var(--p700)'],['🏛️ Budaya',421,28,'var(--y600)'],['🍽️ Kuliner',280,18,'var(--r700)']] as [$kat,$jml,$pct,$clr])
      <div style="display:flex;align-items:center;gap:12px">
        <div style="min-width:130px;font-size:12.5px;font-weight:600">{{ $kat }}</div>
        <div class="progress" style="flex:1"><div class="progress-fill" style="width:{{ $pct }}%;background:{{ $clr }}"></div></div>
        <div style="min-width:60px;text-align:right;font-size:12px;font-weight:700;color:{{ $clr }}">{{ number_format($jml) }}</div>
        <div style="min-width:30px;text-align:right;font-size:11px;color:var(--tm)">{{ $pct }}%</div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
function selectEmoji(e){
  document.getElementById('katIkon').value=e;
  document.querySelectorAll('.emo-pick').forEach(el=>{el.style.background='transparent';el.classList.remove('sel')});
  event.target.style.background='var(--g50)';event.target.style.borderColor='var(--g600)';event.target.classList.add('sel');
}
function editKat(id,ico,nama,desc){
  document.getElementById('katMethod').value='PUT';
  document.getElementById('katId').value=id;
  document.getElementById('katIkon').value=ico;
  document.getElementById('katNama').value=nama;
  document.getElementById('katDesc').value=desc;
  document.getElementById('formKatTitle').textContent='✏️ Edit Kategori';
  document.getElementById('formKategori').action='{{ url("admin/kategori") }}/'+id;
  window.scrollTo({top:0,behavior:'smooth'});
}
function resetKatForm(){
  document.getElementById('katMethod').value='POST';
  document.getElementById('katId').value='';
  document.getElementById('katIkon').value='';
  document.getElementById('katNama').value='';
  document.getElementById('katDesc').value='';
  document.getElementById('formKatTitle').textContent='➕ Tambah Kategori Baru';
  document.getElementById('formKategori').action='{{ route("admin.kategori.store") }}';
}
</script>
@endpush