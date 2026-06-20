{{-- resources/views/partials/sidebar-admin.blade.php ── --}}
<div class="space-y-4">
    {{-- SEGMEN: MENU UTAMA --}}
    <div class="space-y-0.5">
        <span class="px-3 text-[9px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Menu Utama</span>

        {{-- Menu: Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <span class="text-sm group-hover:scale-110 transition-transform">📊</span>
            <span>Dashboard</span>
        </a>

        {{-- Menu: Manajemen User --}}
        <a href="{{ route('admin.users') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.users') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <span class="text-sm group-hover:scale-110 transition-transform">👥</span>
            <span>Manajemen User</span>
        </a>

        {{-- Menu: Data Wisata --}}
        <a href="{{ route('admin.wisata') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.wisata') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <span class="text-sm group-hover:scale-110 transition-transform">🏞️</span>
            <span>Data Wisata</span>
        </a>

        {{-- Menu: Kategori Wisata --}}
        <a href="{{ route('admin.kategori') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.kategori') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <span class="text-sm group-hover:scale-110 transition-transform">🏷️</span>
            <span>Kategori Wisata</span>
        </a>
    </div>

    {{-- SEGMEN: TRANSAKSI --}}
    <div class="space-y-0.5">
        <span class="px-3 text-[9px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Transaksi</span>

        {{-- Menu: Pembayaran --}}
        <a href="{{ route('admin.pembayaran') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.pembayaran') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <span class="text-sm group-hover:scale-110 transition-transform">💳</span>
            <span>Pembayaran</span>
        </a>

        {{-- Menu: Laporan --}}
        <a href="{{ route('admin.laporan') }}" 
           class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all group relative {{ request()->routeIs('admin.laporan') ? 'active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <span class="text-sm group-hover:scale-110 transition-transform">📈</span>
            <span>Laporan & Analitik</span>
        </a>
    </div>

    {{-- SEGMEN: SISTEM --}}
    <div class="space-y-0.5">
        <span class="px-3 text-[9px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Sistem</span>
        <a href="#" class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold text-slate-400 hover:bg-white/5 hover:text-white transition-all group relative">
            <span class="text-sm opacity-70">⚙️</span>
            <span>Pengaturan</span>
        </a>
        <a href="#" class="sb-item flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-bold text-slate-400 hover:bg-white/5 hover:text-white transition-all group relative">
            <span class="text-sm opacity-70">🛡️</span>
            <span>Log Aktivitas</span>
        </a>
    </div>
</div>