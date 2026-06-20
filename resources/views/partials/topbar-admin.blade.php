{{-- resources/views/partials/topbar-admin.blade.php --}}
<div class="w-full flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm mb-6">
    
    {{-- Sisi Kiri: Judul Menu Dinamis & Pencarian Global --}}
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 flex-1 min-w-0">
        <div class="text-slate-800 font-extrabold text-lg tracking-tight whitespace-nowrap">
            @yield('topbar-title', 'Dashboard Admin')
        </div>
        
        {{-- Input Pencarian dengan ikon inner --}}
        <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 h-10 w-full sm:max-w-xs focus-within:border-emerald-500 focus-within:bg-white focus-within:ring-4 focus-within:ring-emerald-500/5 transition-all duration-150">
            <span class="text-sm text-slate-400">🔍</span>
            <input type="text" placeholder="Cari data..." class="bg-transparent border-none outline-none text-xs text-slate-700 w-full font-medium placeholder-slate-400">
        </div>
    </div>

    {{-- Sisi Kanan: Quick Actions & Tombol Pintasan Utama --}}
    <div class="flex items-center justify-between sm:justify-end gap-3 flex-shrink-0">
        
        {{-- Tombol Notifikasi & Profile Quick Links --}}
        <div class="flex items-center gap-2">
            <button class="w-10 h-10 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 flex items-center justify-center text-base relative transition-all duration-150 active:scale-95" title="Notifikasi Baru">
                🔔
                <div class="absolute top-2.5 right-2.5 w-2 h-2 bg-amber-500 rounded-full border border-white animate-pulse"></div>
            </button>
            
            <button class="w-10 h-10 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 flex items-center justify-center text-base transition-all duration-150 active:scale-95" title="Profil Pengguna">
                👤
            </button>
        </div>

        <div class="h-6 w-[1px] bg-slate-200 mx-1 hidden sm:block"></div>

        {{-- Action Button Utama Bertema Modern Emerald/Amber khas CitiisGo --}}
        <a href="{{ route('admin.wisata') }}" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 h-10 rounded-xl shadow-md shadow-emerald-600/10 hover:shadow-emerald-600/20 active:scale-95 transition-all duration-150 decoration-none cursor-pointer">
            <span class="text-sm">➕</span> Tambah Wisata
        </a>
        
    </div>

</div>