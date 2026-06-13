{{-- resources/views/layouts/sidebar-admin.blade.php --}}
<div style="padding:6px 0;flex:1">
  <div class="sb-section">Menu Utama</div>
  <a href="{{ route('admin.dashboard') }}" class="sb-item"><span class="sb-icon">🏠</span> Dashboard</a>
  <a href="{{ route('admin.users') }}" class="sb-item"><span class="sb-icon">👥</span> Manajemen User <span class="sb-badge">{{ $totalUserBaru ?? '' }}</span></a>
  <a href="{{ route('admin.wisata') }}" class="sb-item"><span class="sb-icon">🏞️</span> Data Wisata</a>
  <a href="{{ route('admin.kategori') }}" class="sb-item"><span class="sb-icon">🏷️</span> Kategori Wisata</a>

  <div class="sb-section">Transaksi</div>
  <a href="{{ route('admin.pembayaran') }}" class="sb-item"><span class="sb-icon">💳</span> Pembayaran <span class="sb-badge">{{ $pendingBayar ?? '' }}</span></a>
  <a href="{{ route('admin.laporan') }}" class="sb-item"><span class="sb-icon">📊</span> Laporan & Analitik</a>

  <div class="sb-section">Sistem</div>
  <a href="#" class="sb-item"><span class="sb-icon">⚙️</span> Pengaturan</a>
  <a href="#" class="sb-item"><span class="sb-icon">🛡️</span> Log Aktivitas</a>
</div>