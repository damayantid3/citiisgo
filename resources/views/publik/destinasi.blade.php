<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajah Destinasi - CitiisGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .bg-brand-green { background-color: #0D3D18; }
        .text-brand-green { color: #0D3D18; }
        .hover-bg-brand-green:hover { background-color: #1A5C28; }
        .border-brand-green { border-color: #0D3D18; }
        .text-accent-orange { color: #F47A20; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-slate-700">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-1.5 text-2xl font-black text-brand-green tracking-tight hover:opacity-80 transition outline-none">
                        <i class="fa-solid fa-leaf text-emerald-600 text-lg"></i>
                        <span>Citiis<span class="text-slate-800">Go</span></span>
                    </a>
                    <span class="bg-emerald-50 text-emerald-700 text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full border border-emerald-100 hidden sm:inline-block">Portal Wisatawan</span>
                </div>
                
                <div class="hidden md:flex space-x-8 text-sm font-bold text-slate-600">
                    <a href="{{ route('user.wisata.index') }}" class="hover:text-brand-green transition">
                        <i class="fa-solid fa-house mr-1.5"></i> Beranda
                    </a>
                    <a href="{{ route('user.wisata.index') . '#layanan-pesanan' }}" class="text-brand-green border-b-2 border-brand-green pb-2">
                        <i class="fa-solid fa-compass mr-1.5"></i> Jelajah
                    </a>
                    <a href="{{ route('user.booking.history') }}" class="hover:text-brand-green transition">
                        <i class="fa-solid fa-receipt mr-1.5"></i> Riwayat
                    </a>
                    <a href="{{ route('user.booking.history') }}" class="hover:text-brand-green transition">
                        <i class="fa-solid fa-user mr-1.5"></i> Profil
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <span class="hidden sm:block text-xs font-bold text-slate-700">Hai, {{ session('user.name') ?? 'Petualang' }}</span>
                    
                    <button id="hamburgerBtn" class="md:hidden text-slate-600 hover:text-brand-green focus:outline-none text-base w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 border border-slate-200">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                        @csrf
                        <button type="submit" class="bg-slate-100 text-slate-700 px-5 py-2 rounded-xl font-bold text-xs hover:bg-slate-200 transition outline-none">Keluar</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="mobileMenu" class="hidden md:hidden border-t border-slate-100 bg-white px-4 pt-4 pb-6 shadow-sm space-y-4">
            <div class="flex flex-col space-y-3 text-xs font-bold text-slate-600">
                <a href="{{ route('user.wisata.index') }}" class="px-4 py-3 rounded-xl hover:bg-slate-50 transition"><i class="fa-solid fa-house mr-2"></i> Beranda</a>
                <a href="{{ route('user.wisata.index') . '#layanan-pesanan' }}" class="text-brand-green bg-emerald-50 px-4 py-3 rounded-xl"><i class="fa-solid fa-compass mr-2"></i> Jelajah</a>
                <a href="{{ route('user.booking.history') }}" class="px-4 py-3 rounded-xl hover:bg-slate-50 transition"><i class="fa-solid fa-receipt mr-2"></i> Riwayat</a>
                <a href="{{ route('user.booking.history') }}" class="px-4 py-3 rounded-xl hover:bg-slate-50 transition"><i class="fa-solid fa-user mr-2"></i> Profil</a>
            </div>
            <div class="pt-4 border-t border-slate-50 flex items-center justify-between px-2">
                <span class="text-xs font-bold text-slate-700">Hai, {{ session('user.name') ?? 'Petualang' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-slate-100 text-slate-700 px-6 py-2.5 rounded-xl font-bold text-xs hover:bg-slate-200 transition outline-none">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <header class="bg-gradient-to-br from-[#0D3D18] to-[#1A5C28] text-white py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/30 to-transparent z-0"></div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold mb-3 tracking-tight">Jelajah Destinasi Alam</h1>
            <p class="text-emerald-50 text-xs font-medium max-w-xl mx-auto mb-8">Temukan pesona pegunungan, curug, dan kawasan wisata terbaik di Tasikmalaya dan sekitarnya.</p>
            
            <div class="max-w-2xl mx-auto bg-white p-2.5 rounded-2xl shadow-lg flex items-center gap-3 border border-emerald-800/20">
                <span class="text-slate-400 pl-3 text-sm"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input id="search-input" type="text" placeholder="Cari destinasi alam pilihanmu..." 
                       class="w-full py-2.5 pr-4 text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none border-none bg-transparent">
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
            <div>
                <h2 class="text-lg font-black text-slate-900 tracking-tight">Daftar Destinasi</h2>
                <p class="text-slate-400 text-xs mt-0.5">Pilih lokasi yang Anda inginkan dan lakukan reservasi instan</p>
            </div>
            <div class="flex gap-2 overflow-x-auto w-full sm:w-auto pb-1 sm:pb-0">
                <button onclick="filterKategori('all')" class="filter-btn active bg-emerald-50 text-brand-green text-[10px] font-extrabold uppercase tracking-wider px-5 py-2.5 rounded-xl border border-emerald-100 flex-shrink-0 transition">Semua</button>
                <button onclick="filterKategori('Curug')" class="filter-btn bg-white text-slate-600 text-[10px] font-extrabold uppercase tracking-wider px-5 py-2.5 rounded-xl border border-slate-100 flex-shrink-0 transition hover:bg-slate-50">Curug</button>
                <button onclick="filterKategori('Camping')" class="filter-btn bg-white text-slate-600 text-[10px] font-extrabold uppercase tracking-wider px-5 py-2.5 rounded-xl border border-slate-100 flex-shrink-0 transition hover:bg-slate-50">Camping</button>
                <button onclick="filterKategori('Wana Wisata')" class="filter-btn bg-white text-slate-600 text-[10px] font-extrabold uppercase tracking-wider px-5 py-2.5 rounded-xl border border-slate-100 flex-shrink-0 transition hover:bg-slate-50">Wana Wisata</button>
            </div>
        </div>

        <div id="jelajah-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="col-span-full text-center py-16 text-slate-400" id="loading-state">
                <i class="fas fa-spinner fa-spin text-3xl text-[#0D3D18] mb-3"></i>
                <p class="font-bold text-slate-600 animate-pulse text-sm">Menarik katalog destinasi penjelajahan...</p>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-100 py-8 text-center text-slate-400 text-xs font-semibold tracking-wider uppercase">
        <p>&copy; 2026 CitiisGo - Portal Reservasi Wisatawan</p>
    </footer>

    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        hamburgerBtn.addEventListener('click', () => { mobileMenu.classList.toggle('hidden'); });

        const BASE_API_URL = window.location.origin + '/api/v1';
        let allWisataData = [];
        let activeKategori = 'all';

        async function loadJelajahWisata() {
            const gridContainer = document.getElementById('jelajah-grid');
            const loadingState = document.getElementById('loading-state');

            try {
                const response = await fetch(`${BASE_API_URL}/wisata`, {
                    method: 'GET',
                    headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' }
                });

                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    allWisataData = result.data;
                    renderWisata(allWisataData);
                } else {
                    if (loadingState) {
                        loadingState.innerHTML = `
                            <i class="fa-solid fa-ban text-3xl text-slate-300 mb-2 block"></i>
                            <p class="font-black text-slate-600">Belum ada data destinasi.</p>
                        `;
                    }
                }
            } catch (error) {
                console.error('Gagal:', error);
                if (loadingState) {
                    loadingState.innerHTML = `
                        <i class="fa-solid fa-triangle-exclamation text-3xl text-red-400 mb-2 block"></i>
                        <p class="text-red-500 font-bold text-sm">Gagal Menarik Data Katalog!</p>
                    `;
                }
            }
        }

        function renderWisata(dataList) {
            const gridContainer = document.getElementById('jelajah-grid');
            gridContainer.innerHTML = '';

            if (dataList.length === 0) {
                gridContainer.innerHTML = `
                    <div class="col-span-full text-center py-12 text-slate-400">
                        <i class="fa-solid fa-search text-2xl mb-2 block"></i>
                        <p class="font-bold text-slate-600 text-sm">Destinasi yang Anda cari tidak ditemukan.</p>
                    </div>
                `;
                return;
            }

            dataList.forEach(wisata => {
                const realImage = wisata.foto_url;
                const hargaFormat = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(wisata.harga_tiket);

                const cardHTML = `
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition flex flex-col h-full group animate-fade-in">
                        <div class="h-48 bg-emerald-50 relative overflow-hidden">
                            <img src="${realImage}" alt="${wisata.nama}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-slate-800 text-[10px] font-black px-3 py-1.5 rounded-full shadow-sm border border-white/20">
                                <i class="fa-solid fa-ticket text-accent-orange mr-1"></i> ${hargaFormat}
                            </span>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-black text-base text-slate-900 mb-2 line-clamp-1 group-hover:text-brand-green transition">${wisata.nama}</h3>
                            <p class="text-slate-500 text-xs mb-6 line-clamp-3 flex-grow">${wisata.deskripsi || 'Nikmati liburan yang seru dan menyenangkan di wisata alam pegunungan ini.'}</p>
                            <div class="border-t border-slate-100 pt-4 mt-auto flex items-center justify-between">
                                <span class="text-[11px] text-slate-400 font-bold flex items-center gap-1.5 max-w-[60%]">
                                    <i class="fa-solid fa-location-dot flex-shrink-0"></i> 
                                    <span class="truncate" title="${wisata.alamat}">${wisata.alamat || 'Area Tasikmalaya'}</span>
                                </span>
                                <a href="/user/wisata/${wisata.id}" class="bg-brand-green text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition flex-shrink-0 hover-bg-brand-green shadow-sm tracking-wide">
                                    Pesan Tiket
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                gridContainer.innerHTML += cardHTML;
            });
        }

        // Fitur Pencarian Dinamis Berdasarkan Input
        document.getElementById('search-input').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            applyFilterAndSearch(query, activeKategori);
        });

        // Fitur Filter Kategori
        function filterKategori(kategori) {
            activeKategori = kategori;
            
            // Ubah Visual Tombol Aktif
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => {
                btn.classList.remove('active', 'bg-emerald-50', 'text-brand-green', 'border-emerald-100');
                btn.classList.add('bg-white', 'text-slate-600', 'border-slate-100');
            });
            event.currentTarget.classList.add('active', 'bg-emerald-50', 'text-brand-green', 'border-emerald-100');
            event.currentTarget.classList.remove('bg-white', 'text-slate-600', 'border-slate-100');

            const query = document.getElementById('search-input').value.toLowerCase();
            applyFilterAndSearch(query, activeKategori);
        }

        function applyFilterAndSearch(query, kategori) {
            let filtered = allWisataData;

            // Filter Kategori
            if (kategori !== 'all') {
                filtered = filtered.filter(item => {
                    const catName = item.kategori ? (item.kategori.nama || '') : '';
                    return catName.toLowerCase().includes(kategori.toLowerCase()) || 
                           item.nama.toLowerCase().includes(kategori.toLowerCase());
                });
            }

            // Filter Pencarian
            if (query !== '') {
                filtered = filtered.filter(item => 
                    item.nama.toLowerCase().includes(query) || 
                    (item.deskripsi && item.deskripsi.toLowerCase().includes(query)) ||
                    (item.alamat && item.alamat.toLowerCase().includes(query))
                );
            }

            renderWisata(filtered);
        }

        document.addEventListener('DOMContentLoaded', loadJelajahWisata);
    </script>
</body>
</html>