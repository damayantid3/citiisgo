{{-- resources/views/layouts/sidebar-pengelola.blade.php --}}
<div style="padding:6px 0;flex:1">
  <div class="sb-section">Menu Pengelola</div>
  <a href="{{ route('pengelola.dashboard') }}" class="sb-item"><span class="sb-icon">📊</span> Dashboard</a>
  <a href="{{ route('pengelola.wisata') }}" class="sb-item"><span class="sb-icon">🏔️</span> Kelola Wisata</a>

  <div class="sb-section">Layanan Wisata</div>
  <a href="{{ route('pengelola.camping') }}" class="sb-item"><span class="sb-icon">⛺</span> Paket Camping</a>
  <a href="{{ route('pengelola.penginapan') }}" class="sb-item"><span class="sb-icon">🏨</span> Penginapan & Kamar</a>
  <a href="{{ route('pengelola.peralatan') }}" class="sb-item"><span class="sb-icon">🎒</span> Sewa Peralatan</a>

  <div class="sb-section">Pesanan</div>
  <a href="{{ route('pengelola.reservasi') }}" class="sb-item">
    <span class="sb-icon">🎫</span> Reservasi & Booking
    <span class="sb-badge" style="background:var(--g500)">{{ $pendingCount ?? '' }}</span>
  </a>

  <div class="sb-section">Analitik</div>
  <a href="{{ route('pengelola.laporan') }}" class="sb-item"><span class="sb-icon">📈</span> Laporan Kunjungan</a>
  <a href="#" class="sb-item"><span class="sb-icon">⭐</span> Ulasan Wisata</a>
</div>