@extends('layouts.app')
@section('title', 'Manajemen User - CitiisGo')
@section('topbar-title', '👥 Manajemen User')

@section('content')
{{-- ── BREADCRUMB ── --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 font-medium">
    <span class="text-sm">🏠</span>
    <span class="text-slate-300">/</span>
    <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition-colors">Dashboard</a>
    <span class="text-slate-300">/</span>
    <span class="text-slate-500">Manajemen User</span>
</div>

{{-- ── PAGE HEADER ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 w-full">
    <div class="text-left">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Daftar Pengguna Sistem</h1>
        <p class="text-sm text-slate-500 font-medium mt-1">Kelola data administrator, pengelola objek wisata, dan wisatawan terdaftar secara berkala.</p>
    </div>
    <div class="flex-shrink-0">
        <button onclick="openModal('modalTambahUser')" class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white font-bold text-xs px-4 h-10 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-all duration-150 cursor-pointer border-none outline-none">
            ➕ Tambah User Baru
        </button>
    </div>
</div>

{{-- FIXED: Notifikasi error validasi lokal dipusatkan di sini saja --}}
@if($errors->any())
<div class="mb-5 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold px-4 py-3 rounded-xl shadow-sm">
    <ul class="list-disc pl-4 space-y-0.5">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- ── DATA TABLE CARD CONTAINER ── --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full mb-6">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-xs font-medium">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="px-5 py-4 w-1/4">Nama Lengkap</th>
                    <th class="px-5 py-4 w-1/4">Email Resmi</th>
                    <th class="px-5 py-4 w-1/6">No. Telepon</th>
                    <th class="px-5 py-4 w-1/6">Hak Akses / Role</th>
                    <th class="px-5 py-4 w-1/12">Status</th>
                    <th class="px-5 py-4 text-center w-1/12">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($users ?? [] as $user)
                <tr class="hover:bg-slate-50/40 transition-colors">
                    <td class="px-5 py-3.5 font-bold text-slate-900 flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full bg-emerald-50 font-extrabold text-[11px] text-emerald-700 flex items-center justify-center border border-emerald-200/30 shadow-inner flex-shrink-0">
                            {{ strtoupper(substr($user['nama'] ?? $user['name'] ?? 'U', 0, 2)) }}
                        </div>
                        <span class="truncate">{{ $user['nama'] ?? $user['name'] ?? '—' }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-500 font-mono truncate">{{ $user['email'] ?? '—' }}</td>
                    <td class="px-5 py-3.5 text-slate-500 font-mono">{{ $user['telepon'] ?? $user['no_hp'] ?? '—' }}</td>
                    <td class="px-5 py-3.5">
                        @php
                            $role = strtolower($user['role'] ?? 'user');
                            if($role === 'user') $role = 'wisatawan';

                            $roleStyles = [
                                'admin' => 'bg-purple-50 text-purple-700 border-purple-100',
                                'admin utama' => 'bg-purple-50 text-purple-700 border-purple-100',
                                'pengelola' => 'bg-amber-50 text-amber-700 border-amber-100',
                                'wisatawan' => 'bg-blue-50 text-blue-700 border-blue-100'
                            ][$role] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                            
                            $roleLabel = [
                                'admin' => 'Admin Utama',
                                'admin utama' => 'Admin Utama',
                                'pengelola' => 'Pengelola Wisata',
                                'wisatawan' => 'Wisatawan'
                            ][$role] ?? ucfirst($role);
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $roleStyles }}">
                            {{ $roleLabel }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        @if(($user['status'] ?? 'active') === 'active' || ($user['is_active'] ?? true) == true)
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-bold bg-slate-50 text-slate-400 border border-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-center gap-1.5">
                            <button type="button" 
                                    onclick="openEditModal(this)"
                                    data-id="{{ $user['id'] }}"
                                    data-nama="{{ $user['nama'] ?? $user['name'] ?? '—' }}"
                                    data-email="{{ $user['email'] }}"
                                    data-role="{{ $role }}"
                                    class="w-7 h-7 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-50 text-xs shadow-sm active:scale-95 transition-transform cursor-pointer" title="Ubah Data Profil">
                                ✏️
                            </button>
                            <button type="button"
                                    onclick="confirmDelete({{ $user['id'] }}, '{{ $user['nama'] ?? $user['name'] ?? 'User' }}')"
                                    class="w-7 h-7 bg-white border border-rose-200 rounded-lg flex items-center justify-center hover:bg-rose-50 text-rose-600 text-xs shadow-sm active:scale-95 transition-transform cursor-pointer" title="Hapus Akun User">
                                🗑️
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-slate-400 font-medium text-xs">
                        📭 Tidak ada data pengguna terdaftar di dalam database sistem.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── MODAL POPUP: TAMBAH USER BARU ── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalTambahUser">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">➕ Tambah User Baru</h3>
            <button onclick="closeModal('modalTambahUser')" class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-rose-50 hover:text-rose-600 text-slate-400 font-bold flex items-center justify-center text-xs cursor-pointer">✕</button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST" class="m-0">
            @csrf
            <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Nama Lengkap <span class="text-rose-600">*</span></label>
                        <input type="text" name="nama" placeholder="Nama lengkap user" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-all">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Email <span class="text-rose-600">*</span></label>
                        <input type="email" name="email" placeholder="email@example.com" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-all">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">No. HP / Telepon</label>
                        <input type="text" name="no_hp" placeholder="08xx-xxxx-xxxx" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-all">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Role Hak Akses <span class="text-rose-600">*</span></label>
                        <select name="role" required class="w-full border border-slate-200 bg-white rounded-xl px-3 py-2 text-xs font-semibold outline-none focus:border-emerald-500 transition-all cursor-pointer">
                            <option value="wisatawan">Wisatawan</option>
                            <option value="pengelola">Pengelola Wisata</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Password <span class="text-rose-600">*</span></label>
                        <input type="password" name="password" placeholder="Min. 6 karakter" required minlength="6" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-all">
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="closeModal('modalTambahUser')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-bold text-xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 active:scale-95 transition-transform cursor-pointer">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-bold text-xs px-4 h-9 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-transform cursor-pointer">💾 Simpan User</button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL POPUP: EDIT DATA USER ── --}}
<div class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4 modal-backdrop" id="modalEditUser">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">✏️ Edit Profil User</h3>
            <button onclick="closeModal('modalEditUser')" class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-rose-50 hover:text-rose-600 text-slate-400 font-bold flex items-center justify-center text-xs cursor-pointer">✕</button>
        </div>
        <form action="" method="POST" id="formEditUser" class="m-0">
            @csrf @method('PUT')
            <div class="p-6 space-y-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Nama Lengkap</label>
                    <input type="text" name="nama" id="edit_nama" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-all">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500">Email Alamat</label>
                    <input type="email" name="email" id="edit_email" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium outline-none focus:border-emerald-500 transition-all">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-slate-500">Ubah Role</label>
                        <select name="role" id="edit_role" class="w-full border border-slate-200 bg-white rounded-xl px-3 py-2 text-xs font-semibold outline-none focus:border-emerald-500 cursor-pointer">
                            <option value="wisatawan">Wisatawan</option>
                            <option value="pengelola">Pengelola Wisata</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 px-6 py-3.5 border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="closeModal('modalEditUser')" class="inline-flex items-center justify-center border border-slate-200 bg-white text-slate-700 font-bold text-xs px-4 h-9 rounded-xl shadow-sm hover:bg-slate-50 active:scale-95 transition-transform cursor-pointer">Batal</button>
                <button type="submit" class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-bold text-xs px-4 h-9 rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 active:scale-95 transition-transform cursor-pointer">💾 Update Data</button>
            </div>
        </form>
    </div>
</div>

{{-- Hidden Core Delete Form --}}
<form id="deleteUserForm" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>
@endsection

@push('scripts')
{{-- Pustaka SweetAlert2 Untuk Mewarnai Notifikasi & Dialog Konfirmasi --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Menampilkan Popup Sukses Modern dari Session Flash Laravel
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2500,
        customClass: {
            popup: 'rounded-2xl font-sans text-xs',
            title: 'font-extrabold text-slate-900'
        }
    });
@endif

function openEditModal(button) {
    const id = button.getAttribute('data-id');
    const nama = button.getAttribute('data-nama');
    const email = button.getAttribute('data-email');
    const role = button.getAttribute('data-role');

    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_role').value = role;

    const form = document.getElementById('formEditUser');
    form.action = "{{ route('admin.users.update', ':id') }}".replace(':id', id);

    openModal('modalEditUser');
}

// FIXED: Mengganti konfirmasi hapus bawaan browser menjadi Dialog Interaktif Kustom Premium
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Pengguna?',
        text: `Apakah Anda yakin ingin menghapus permanen akun "${name}"? Tindakan ini tidak dapat dibatalkan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48', // Warna merah rose Tailwind
        cancelButtonColor: '#64748b',  // Warna slate grey
        confirmButtonText: 'Ya, Hapus Permanen!',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-2xl font-sans',
            title: 'font-extrabold text-slate-900 text-lg',
            htmlContainer: 'text-xs text-slate-500 font-medium mt-2',
            confirmButton: 'text-xs font-bold px-4 py-2 rounded-xl',
            cancelButton: 'text-xs font-bold px-4 py-2 rounded-xl'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteUserForm');
            form.action = '{{ route("admin.users.destroy", ":id") }}'.replace(':id', id);
            form.submit();
        }
    });
}

function openModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}
</script>
@endpush