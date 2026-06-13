@extends('layouts.app')
@section('title','Manajemen User')
@section('topbar-title','👥 Manajemen User')
@section('show-search','1')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
  <span class="bc-sep">›</span><span>Manajemen User</span>
</div>

<div class="page-hd">
  <div class="page-hd-left">
    <h1>👥 Manajemen User</h1>
    <p>Kelola semua akun pengguna sistem CitiisGo</p>
  </div>
  <div class="page-hd-right">
    <button class="btn btn-out btn-sm">📥 Export CSV</button>
    <button class="btn btn-g" onclick="openModal('modalTambahUser')">➕ Tambah User</button>
  </div>
</div>

<!-- Stats -->
<div class="stats-grid">
  <div class="stat-card" style="--ac:var(--g600)">
    <div class="stat-label">Total User</div>
    <div class="stat-value">{{ number_format($users['total'] ?? 4829) }}</div>
    <div class="stat-sub"><span class="stat-up">▲ 12.4%</span> bulan ini</div>
    <div class="stat-icon">👥</div>
  </div>
  <div class="stat-card" style="--ac:var(--b700)">
    <div class="stat-label">Wisatawan Aktif</div>
    <div class="stat-value">{{ number_format($users['wisatawan'] ?? 4742) }}</div>
    <div class="stat-sub"><span class="stat-up">▲ 8.2%</span></div>
    <div class="stat-icon">🧳</div>
  </div>
  <div class="stat-card" style="--ac:var(--o500)">
    <div class="stat-label">Pengelola</div>
    <div class="stat-value">{{ $users['pengelola'] ?? 48 }}</div>
    <div class="stat-sub">+3 baru bulan ini</div>
    <div class="stat-icon">🏔️</div>
  </div>
  <div class="stat-card" style="--ac:var(--r700)">
    <div class="stat-label">Akun Suspend</div>
    <div class="stat-value">{{ $users['suspended'] ?? 39 }}</div>
    <div class="stat-sub"><span class="stat-down">▲ 2</span> kasus baru</div>
    <div class="stat-icon">🚫</div>
  </div>
</div>

<div class="card">
  <div class="card-head">
    <div class="card-title">Daftar Semua User</div>
    <div style="display:flex;align-items:center;gap:8px">
      <span class="text-sm text-muted">{{ $users['total'] ?? 4829 }} total user</span>
    </div>
  </div>
  <div class="card-body" style="padding-bottom:0">
    <div class="filter-bar">
      <form method="GET" action="{{ route('admin.users') }}" style="display:flex;gap:10px;flex-wrap:wrap;flex:1">
        <div class="search-input" style="flex:1;min-width:200px;max-width:320px">
          <span>🔍</span>
          <input type="text" name="search" placeholder="Cari nama, email..." value="{{ request('search') }}">
        </div>
        <select name="role" class="select-filter" onchange="this.form.submit()">
          <option value="">Semua Role</option>
          <option value="user" {{ request('role')=='user'?'selected':'' }}>Wisatawan</option>
          <option value="pengelola" {{ request('role')=='pengelola'?'selected':'' }}>Pengelola</option>
          <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
        </select>
        <select name="status" class="select-filter" onchange="this.form.submit()">
          <option value="">Semua Status</option>
          <option value="active" {{ request('status')=='active'?'selected':'' }}>Aktif</option>
          <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
          <option value="suspended" {{ request('status')=='suspended'?'selected':'' }}>Suspended</option>
        </select>
        @if(request('search') || request('role') || request('status'))
          <a href="{{ route('admin.users') }}" class="btn btn-out btn-sm">✕ Reset</a>
        @endif
      </form>
    </div>
  </div>

  <div class="tbl-wrap">
    <table class="tbl">
      <thead>
        <tr>
          <th style="width:32px"><input type="checkbox" id="selectAll"></th>
          <th>User</th><th>No. HP</th><th>Role</th><th>Status</th>
          <th>Terdaftar</th><th>Transaksi</th><th style="width:120px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @php
        $dummies = [
          ['Budi Santoso','budi.s@email.com','0812-3456-7890','user','active','12 Jan 2025',24,'#E3F2FD','#1565C0','BS'],
          ['Budi Kusuma','budi.k@wisata.com','0821-9876-5432','pengelola','active','3 Feb 2025',0,'var(--o50)','var(--o700)','BK'],
          ['Siti Rahayu','siti.r@email.com','0895-1234-5678','user','suspended','28 Mar 2025',7,'var(--r50)','var(--r700)','SR'],
          ['Ahmad Fauzi','ahmad.f@email.com','0877-6543-2109','user','active','5 Apr 2025',31,'var(--g50)','var(--g700)','AF'],
          ['Dewi Permata','dewi.p@wisata.co.id','0813-5678-9012','pengelola','active','10 Apr 2025',0,'var(--p50)','var(--p700)','DP'],
          ['Rizky Wardana','rizky.w@email.com','0856-4321-8765','user','inactive','22 Apr 2025',3,'#FFF8E1','#F57F17','RW'],
        ];
        $roleLabel = ['user'=>'Wisatawan','pengelola'=>'Pengelola','admin'=>'Admin'];
        @endphp

        @foreach($users['data'] ?? $dummies as $u)
        @php $isArr = is_array($u); @endphp
        <tr>
          <td><input type="checkbox" class="row-check"></td>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              <div class="av" style="background:{{ $isArr ? $u[7] : 'var(--g50)' }};color:{{ $isArr ? $u[8] : 'var(--g700)' }}">
                {{ $isArr ? $u[9] : strtoupper(substr($u['nama'],0,2)) }}
              </div>
              <div>
                <div class="fw7" style="font-size:13.5px">{{ $isArr ? $u[0] : $u['nama'] }}</div>
                <div class="text-sm text-muted">{{ $isArr ? $u[1] : $u['email'] }}</div>
              </div>
            </div>
          </td>
          <td class="text-muted">{{ $isArr ? $u[2] : ($u['no_hp'] ?? '—') }}</td>
          <td>
            @php $role = $isArr ? $u[3] : $u['role'] @endphp
            <span class="badge {{ $role==='admin'?'bg-p':($role==='pengelola'?'bg-w':'bg-i') }}">
              {{ $roleLabel[$role] ?? $role }}
            </span>
          </td>
          <td>
            @php $status = $isArr ? $u[4] : $u['status'] @endphp
            <span class="badge {{ $status==='active'?'bg-s':($status==='suspended'?'bg-d':'bg-y') }}">
              <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block"></span>
              {{ ucfirst($status) }}
            </span>
          </td>
          <td class="text-muted text-sm">{{ $isArr ? $u[5] : ($u['created_at'] ?? '-') }}</td>
          <td class="fw7">{{ $isArr ? $u[6] : '—' }}</td>
          <td>
            <div style="display:flex;gap:4px">
              <button class="btn btn-out btn-xs" title="Edit" onclick="openModal('modalEditUser')">✏️</button>
              @if(($isArr?$u[4]:$u['status']) === 'suspended')
                <button class="btn btn-xs bg-s" style="background:var(--g50);color:var(--g700);border:1px solid var(--g100)" title="Aktifkan">✅</button>
              @else
                <button class="btn btn-red btn-xs" title="Hapus" onclick="confirmDelete({{ $isArr ? 0 : $u['id'] }})">🗑️</button>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="card-foot">
    <span class="text-sm text-muted">
      Menampilkan <strong>1–{{ count($users['data'] ?? $dummies) }}</strong> dari <strong>{{ $users['total'] ?? 4829 }}</strong> user
    </span>
    <div class="page-nav">
      <button class="page-btn">‹</button>
      <button class="page-btn active">1</button>
      <button class="page-btn">2</button>
      <button class="page-btn">3</button>
      <button class="page-btn">...</button>
      <button class="page-btn">483</button>
      <button class="page-btn">›</button>
    </div>
  </div>
</div>

<!-- ── Modal Tambah User ── -->
<div class="modal-backdrop" id="modalTambahUser">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">➕ Tambah User Baru</div>
      <button class="modal-close" onclick="closeModal('modalTambahUser')">✕</button>
    </div>
    <form action="{{ route('admin.users.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Lengkap <span class="req">*</span></label>
            <input type="text" name="nama" class="form-control" placeholder="Nama lengkap user" required>
          </div>
          <div class="form-group">
            <label class="form-label">Email <span class="req">*</span></label>
            <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">No. HP</label>
            <input type="text" name="no_hp" class="form-control" placeholder="08xx-xxxx-xxxx">
          </div>
          <div class="form-group">
            <label class="form-label">Role <span class="req">*</span></label>
            <select name="role" class="form-control" required>
              <option value="">-- Pilih Role --</option>
              <option value="user">Wisatawan</option>
              <option value="pengelola">Pengelola Wisata</option>
              <option value="admin">Administrator</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Password <span class="req">*</span></label>
            <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter" required minlength="8">
          </div>
          <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Status</label>
          <select name="status" class="form-control">
            <option value="active">Aktif</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-out" onclick="closeModal('modalTambahUser')">Batal</button>
        <button type="submit" class="btn btn-g">💾 Simpan User</button>
      </div>
    </form>
  </div>
</div>

<!-- ── Modal Edit User ── -->
<div class="modal-backdrop" id="modalEditUser">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">✏️ Edit User</div>
      <button class="modal-close" onclick="closeModal('modalEditUser')">✕</button>
    </div>
    <form action="{{ route('admin.users.update', ':id') }}" method="POST" id="formEditUser">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" id="edit_nama" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" id="edit_email" class="form-control">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" id="edit_status" class="form-control">
              <option value="active">Aktif</option>
              <option value="inactive">Inactive</option>
              <option value="suspended">Suspended</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Ubah Role</label>
            <select name="role" id="edit_role" class="form-control">
              <option value="user">Wisatawan</option>
              <option value="pengelola">Pengelola</option>
              <option value="admin">Admin</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-out" onclick="closeModal('modalEditUser')">Batal</button>
        <button type="submit" class="btn btn-g">💾 Update</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete form (hidden) -->
<form id="deleteUserForm" method="POST" style="display:none">
  @csrf @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
// Select all checkbox
document.getElementById('selectAll').addEventListener('change', function() {
  document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
});

function confirmDelete(id) {
  if (confirm('Yakin ingin menghapus user ini?')) {
    const form = document.getElementById('deleteUserForm');
    form.action = '{{ route("admin.users.destroy", ":id") }}'.replace(':id', id);
    form.submit();
  }
}
</script>
@endpush