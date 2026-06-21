{{-- resources/views/partials/sidebar-admin.blade.php ── --}}
<div class="space-y-4">
    {{-- SEGMEN: MENU UTAMA --}}
    <div class="space-y-0.5">
        <span class="px-3 text-[9px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Menu Utama</span>

        {{-- Menu: Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="9" rx="1"></rect>
                <rect x="14" y="3" width="7" height="5" rx="1"></rect>
                <rect x="14" y="12" width="7" height="9" rx="1"></rect>
                <rect x="3" y="16" width="7" height="5" rx="1"></rect>
            </svg>
            <span>Dashboard</span>
        </a>

        {{-- Menu: Manajemen User --}}
        <a href="{{ route('admin.users') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.users') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Manajemen User</span>
        </a>

        {{-- Menu: Data Wisata --}}
        <a href="{{ route('admin.wisata') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.wisata') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                <line x1="12" y1="22.08" x2="12" y2="12"></line>
            </svg>
            <span>Data Wisata</span>
        </a>

        {{-- Menu: Kategori Wisata --}}
        <a href="{{ route('admin.kategori') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.kategori') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                <line x1="7" y1="7" x2="7.01" y2="7"></line>
            </svg>
            <span>Kategori Wisata</span>
        </a>
    </div>

    {{-- SEGMEN: TRANSAKSI --}}
    <div class="space-y-0.5">
        <span class="px-3 text-[9px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Transaksi</span>

        {{-- Menu: Pembayaran --}}
        <a href="{{ route('admin.pembayaran') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.pembayaran') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            <span>Pembayaran</span>
        </a>

        {{-- Menu: Laporan --}}
        <a href="{{ route('admin.laporan') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.laporan') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                <polyline points="17 6 23 6 23 12"></polyline>
            </svg>
            <span>Laporan & Analitik</span>
        </a>
    </div>

    {{-- SEGMEN: SISTEM --}}
    <div class="space-y-0.5">
        <span class="px-3 text-[9px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Sistem</span>
        <a href="#" class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold opacity-60 cursor-not-allowed text-white/70 bg-white/5 transition-all group relative">
            <svg class="w-4 h-4 stroke-current" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg>
            <span>Pengaturan</span>
        </a>
        <a href="#" class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold opacity-60 cursor-not-allowed text-white/70 bg-white/5 transition-all group relative">
            <svg class="w-4 h-4 stroke-current" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            </svg>
            <span>Log Aktivitas</span>
        </a>
    </div>
</div>