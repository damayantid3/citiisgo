{{-- resources/views/partials/sidebar-pengelola.blade.php --}}
<div class="py-2 flex-1 flex flex-col space-y-6">

    {{-- ── SECTION: MENU PENGELOLA ── --}}
    <div>
        <div class="px-5 mb-2 text-[10px] font-bold tracking-widest text-white/30 uppercase">
            Menu Pengelola
        </div>
        <div class="space-y-1">
            <a href="{{ route('pengelola.dashboard') }}" class="sb-item flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-all duration-150 group">
                <span class="w-5 text-center text-base filter group-hover:scale-110 transition-transform duration-150">📊</span> 
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('pengelola.wisata') }}" class="sb-item flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-all duration-150 group">
                <span class="w-5 text-center text-base filter group-hover:scale-110 transition-transform duration-150">🏔️</span> 
                <span>Kelola Wisata</span>
            </a>
        </div>
    </div>

    {{-- ── SECTION: LAYANAN WISATA ── --}}
    <div>
        <div class="px-5 mb-2 text-[10px] font-bold tracking-widest text-white/30 uppercase">
            Layanan Wisata
        </div>
        <div class="space-y-1">
            <a href="{{ route('pengelola.camping') }}" class="sb-item flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-all duration-150 group">
                <span class="w-5 text-center text-base filter group-hover:scale-110 transition-transform duration-150">⛺</span> 
                <span>Paket Camping</span>
            </a>
            
            <a href="{{ route('pengelola.penginapan') }}" class="sb-item flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-all duration-150 group">
                <span class="w-5 text-center text-base filter group-hover:scale-110 transition-transform duration-150">🏨</span> 
                <span>Penginapan & Kamar</span>
            </a>
            
            <a href="{{ route('pengelola.peralatan') }}" class="sb-item flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-all duration-150 group">
                <span class="w-5 text-center text-base filter group-hover:scale-110 transition-transform duration-150">🎒</span> 
                <span>Sewa Peralatan</span>
            </a>
        </div>
    </div>

    {{-- ── SECTION: PESANAN ── --}}
    <div>
        <div class="px-5 mb-2 text-[10px] font-bold tracking-widest text-white/30 uppercase">
            Pesanan
        </div>
        <div class="space-y-1">
            <a href="{{ route('pengelola.reservasi') }}" class="sb-item flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-all duration-150 group">
                <span class="w-5 text-center text-base filter group-hover:scale-110 transition-transform duration-150">🎫</span> 
                <span class="flex-1 truncate">Reservasi & Booking</span>
                @if(!empty($pendingCount))
                    <span class="sb-badge bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm shadow-amber-500/20 animate-pulse">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>
        </div>
    </div>

    {{-- ── SECTION: ANALITIK ── --}}
    <div>
        <div class="px-5 mb-2 text-[10px] font-bold tracking-widest text-white/30 uppercase">
            Analitik
        </div>
        <div class="space-y-1">
            <a href="{{ route('pengelola.laporan') }}" class="sb-item flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-all duration-150 group">
                <span class="w-5 text-center text-base filter group-hover:scale-110 transition-transform duration-150">📈</span> 
                <span>Laporan Kunjungan</span>
            </a>
            
            <a href="#" class="sb-item flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-all duration-150 group">
                <span class="w-5 text-center text-base filter group-hover:scale-110 transition-transform duration-150">⭐</span> 
                <span>Ulasan Wisata</span>
            </a>
        </div>
    </div>

</div>

{{-- CSS Injeksi Khusus Sisi Pengelola untuk Efek Menu Aktif --}}
@push('styles')
<style>
    .sb-item.active {
        background-color: rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        box-shadow: inset 4px 0 0 0 #f59e0b; /* Garis vertikal indikator warna amber-500 */
    }
</style>
@endpush