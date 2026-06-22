{{-- resources/views/partials/sidebar-admin.blade.php --}}
<div class="space-y-4">
    <div class="space-y-0.5">
        <span class="px-3 text-[9px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Menu Utama</span>
        <a href="{{ route('admin.dashboard') }}" class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="9"></rect>
                <rect x="14" y="3" width="7" height="5"></rect>
                <rect x="14" y="12" width="7" height="9"></rect>
                <rect x="3" y="16" width="7" height="5"></rect>
            </svg>
            <span>Dashboard Audit</span>
        </a>
        <a href="{{ route('admin.users') }}" class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.users*') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
            </svg>
            <span>Manajemen Pengguna</span>
        </a>
    </div>

    <div class="space-y-0.5">
        <span class="px-3 text-[9px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Obyek Wisata & Keuangan</span>
        <a href="{{ route('admin.wisata') }}" class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.wisata*') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
            </svg>
            <span>Destinasi Terdaftar</span>
        </a>
        <a href="{{ route('admin.kategori') }}" class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.kategori*') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                <polyline points="2 17 12 22 22 17"></polyline>
                <polyline points="2 12 12 17 22 12"></polyline>
            </svg>
            <span>Kategori Wahana</span>
        </a>
        <a href="{{ route('admin.pembayaran') }}" class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.pembayaran*') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
            <span>Audit Pembayaran</span>
        </a>
        <a href="{{ route('admin.laporan') }}" class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.laporan*') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                <polyline points="17 6 23 6 23 12"></polyline>
            </svg>
            <span>Rekap Pendapatan</span>
        </a>
    </div>

    <div class="space-y-0.5">
        <span class="px-3 text-[9px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Sistem Konfigurasi</span>
        <a href="{{ route('admin.sistem.pengaturan') }}" class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.sistem.pengaturan*') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg>
            <span>Pengaturan Utama</span>
        </a>
        <a href="{{ route('admin.sistem.log') }}" class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.sistem.log*') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
            </svg>
            <span>Log Aktivitas</span>
        </a>
    </div>
</div>