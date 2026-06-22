{{-- resources/views/partials/sidebar-pengelola.blade.php ── --}}
<div class="space-y-4">
    {{-- SEGMEN: MENU UTAMA PENGELOLA --}}
    <div class="space-y-0.5">
        <span class="px-3 text-[9px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Menu Utama</span>

        {{-- Menu: Dashboard Pengelola --}}
        <a href="{{ route('pengelola.dashboard') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('pengelola.dashboard') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="9" rx="1"></rect>
                <rect x="14" y="3" width="7" height="5" rx="1"></rect>
                <rect x="14" y="12" width="7" height="9" rx="1"></rect>
                <rect x="3" y="16" width="7" height="5" rx="1"></rect>
            </svg>
            <span>Dashboard Mitra</span>
        </a>

        {{-- Menu: Kelola Wisata / Wahana --}}
        <a href="{{ route('pengelola.wisata') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('pengelola.wisata*') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                <line x1="12" y1="22.08" x2="12" y2="12"></line>
            </svg>
            <span>Kelola Wisata</span>
        </a>
    </div>

    {{-- SEGMEN: MODUL UNIT BISNIS --}}
    <div class="space-y-0.5">
        <span class="px-3 text-[9px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Modul Unit Bisnis</span>

        {{-- Menu: Paket Camping --}}
        <a href="{{ route('pengelola.camping') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('pengelola.camping*') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 15s1-1 4 0 5 1 8 0 4-1 4-1V3s-1 1-4 0-5-1-8 0-4 1-4 1z"></path>
                <line x1="4" y1="22" x2="4" y2="15"></line>
            </svg>
            <span>Paket Camping</span>
        </a>

        {{-- Menu: Penginapan --}}
        <a href="{{ route('pengelola.penginapan') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('pengelola.penginapan*') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>Kelola Penginapan</span>
        </a>

        {{-- Menu: Peralatan --}}
        <a href="{{ route('pengelola.peralatan') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('pengelola.peralatan*') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
            </svg>
            <span>Sewa Peralatan</span>
        </a>
    </div>

    {{-- SEGMEN: TRANSAKSI & LAPORAN --}}
    <div class="space-y-0.5">
        <span class="px-3 text-[9px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Transaksi & Keuangan</span>

        {{-- Menu: Validasi Reservasi --}}
        <a href="{{ route('pengelola.reservasi') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('pengelola.reservasi*') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Validasi Reservasi</span>
        </a>

        {{-- Menu: Laporan Parsial --}}
        <a href="{{ route('pengelola.laporan') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('pengelola.laporan*') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-4 h-4 stroke-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                <polyline points="17 6 23 6 23 12"></polyline>
            </svg>
            <span>Laporan Pendapatan</span>
        </a>
    </div>
</div>