<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - CitiisGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-brand-green { background-color: #0D3D18; }
        .text-brand-green { color: #0D3D18; }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Plus Jakarta Sans', sans-serif;" class="bg-gray-50 font-sans antialiased text-slate-700">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <a href="{{ route('user.dashboard') }}" class="text-2xl font-black text-brand-green tracking-tight">Citiis<span class="text-slate-800">Go</span></a>
                    <span class="bg-emerald-50 text-emerald-700 text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full border border-emerald-100">Riwayat Pesanan</span>
                </div>
                <a href="{{ route('user.wisata.index') }}" class="text-xs font-bold text-slate-600 hover:text-brand-green transition flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-16">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Riwayat Reservasi Anda</h1>
            <p class="text-slate-500 text-xs font-medium">Semua tiket dan pesanan layanan yang Anda buat akan muncul di sini secara transparan.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl p-12 border border-slate-100 text-center max-w-xl mx-auto">
            <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center text-4xl mx-auto mb-5">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <h2 class="font-bold text-slate-800 text-base mb-1">Belum ada riwayat pemesanan</h2>
            <p class="text-slate-400 text-xs mb-8">Silakan buat pesanan tiket destinasi, kemah, atau sewa alat terlebih dahulu melalui halaman dasbor.</p>
            <a href="{{ route('user.wisata.index') }}" class="bg-brand-green text-white font-bold text-xs px-6 py-4 rounded-2xl hover:bg-[#1A5C28] transition shadow-sm inline-block tracking-wide w-full max-w-xs">
                Jelajahi Wisata Sekarang
            </a>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-100 py-8 text-center text-slate-400 text-xs font-semibold tracking-wider uppercase mt-12">
        <p>&copy; 2026 CitiisGo - Portal Reservasi Wisatawan</p>
    </footer>

</body>
</html>