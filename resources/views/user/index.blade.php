<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CitiisGo - Dasbor Wisatawan</title>
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
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 h-8 hover:opacity-80 transition outline-none">
                        <img src="{{ asset('assets/img/CitiisgoLogo.jpg') }}" alt="CitiisGo Logo" class="h-full w-auto object-contain">
                    </a>
                    <span class="bg-emerald-50 text-emerald-700 text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full border border-emerald-100 hidden sm:inline-block">Portal Wisatawan</span>
                </div>
                
                <div class="hidden md:flex space-x-8 text-sm font-bold text-slate-600">
                    <a href="{{ route('user.wisata.index') }}" class="text-brand-green border-b-2 border-brand-green pb-2">
                        <i class="fa-solid fa-house mr-1.5"></i> Beranda
                    </a>
                    <a href="{{ route('user.wisata.index') . '#layanan-pesanan' }}" class="hover:text-brand-green transition">
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
                <a href="{{ route('user.wisata.index') }}" class="text-brand-green bg-emerald-50 px-4 py-3 rounded-xl"><i class="fa-solid fa-house mr-2"></i> Beranda</a>
                <a href="{{ route('user.wisata.index') . '#layanan-pesanan' }}" class="px-4 py-3 rounded-xl hover:bg-slate-50 transition"><i class="fa-solid fa-compass mr-2"></i> Jelajah</a>
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

    <div class="relative bg-slate-900 overflow-hidden py-24 md:py-36">
        <img src="{{ asset('assets/img/wisata/CitiisFoto.jpg') }}" alt="Pemandangan Alam Citiis" class="absolute inset-0 w-full h-full object-cover opacity-85">
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/80 via-slate-900/40 to-transparent"></div>
        <div class="relative max-w-4xl mx-auto px-4 text-center text-white">
            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight mb-4 leading-tight shadow-sm drop-shadow-md">
                Eksplorasi Keindahan Alam <br/><span class="text-amber-300">Citiis Tasikmalaya</span>
            </h1>
            <p class="text-sm md:text-base text-gray-50 max-w-2xl mx-auto mb-8 font-medium drop-shadow">Pilih destinasi wisata pegunungan atau wahana favorit Anda dan selesaikan reservasi secara instan.</p>
            <a href="#layanan-pesanan" class="bg-brand-green text-white px-8 py-3.5 rounded-full font-bold text-xs hover:bg-[#1A5C28] transition shadow-lg inline-flex items-center gap-2 cursor-pointer border border-emerald-600">
                <i class="fa-solid fa-compass"></i> Jelajahi Layanan
            </a>
        </div>
    </div>

    <div class="bg-gray-50 pt-10 pb-4">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="w-full bg-gradient-to-r from-emerald-700 to-emerald-800 rounded-3xl p-8 shadow-sm text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border border-emerald-600">
                <div>
                    <h3 class="font-black text-base md:text-lg tracking-tight mb-1"><i class="fa-solid fa-tag text-amber-300 mr-2"></i> Diskon Spesial Camp!</h3>
                    <p class="text-emerald-50 text-xs font-medium">Dapatkan potongan tiket hingga 20% khusus bulan ini.</p>
                </div>
                <a href="{{ route('user.wisata.index') . '#layanan-pesanan' }}" class="bg-white text-emerald-900 font-extrabold text-[10px] uppercase tracking-wider px-6 py-3.5 rounded-2xl shadow-sm hover:bg-emerald-50 transition flex-shrink-0">
                    Pesan Camp Sekarang
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            <div class="mb-5">
                <h2 class="text-sm font-black text-slate-900 tracking-tight">Layanan CitiisGo</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('user.wisata.index') . '#layanan-pesanan' }}" class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:border-emerald-200 transition group">
                    <div class="w-12 h-12 bg-emerald-50 text-[#0D3D18] rounded-xl flex items-center justify-center text-xl group-hover:bg-[#0D3D18] group-hover:text-white transition"><i class="fa-solid fa-mountain-sun"></i></div>
                    <div>
                        <div class="font-bold text-slate-800 text-sm group-hover:text-brand-green transition">Tiket Masuk</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Destinasi Alam</div>
                    </div>
                </a>
                <a href="{{ route('user.booking.camping') }}" class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:border-orange-200 transition group">
                    <div class="w-12 h-12 bg-orange-50 text-[#F47A20] rounded-xl flex items-center justify-center text-xl group-hover:bg-[#F47A20] group-hover:text-white transition"><i class="fa-solid fa-tent"></i></div>
                    <div>
                        <div class="font-bold text-slate-800 text-sm group-hover:text-accent-orange transition">Sewa Camp</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Bumi Perkemahan</div>
                    </div>
                </a>
                <a href="{{ route('user.booking.camping') }}" class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:border-blue-200 transition group">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl group-hover:bg-blue-600 group-hover:text-white transition"><i class="fa-solid fa-house-chimney-window"></i></div>
                    <div>
                        <div class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition">Penginapan</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Villa & Homestay</div>
                    </div>
                </a>
                <a href="{{ route('user.booking.camping') }}" class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:border-purple-200 transition group">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl group-hover:bg-purple-600 group-hover:text-white transition"><i class="fa-solid fa-person-hiking"></i></div>
                    <div>
                        <div class="font-bold text-slate-800 text-sm group-hover:text-purple-600 transition">Sewa Alat</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Outdoor Gear</div>
                    </div>
                </a>
            </div>
        </div>

        <div id="layanan-pesanan" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="mb-8">
                <h2 class="text-base font-black text-slate-900 tracking-tight">Kategori Wisata</h2>
                <p class="text-slate-400 text-xs mt-1">Pilih Lokasi Wisata Pegunungan Resmi Dengan Fasilitas Terbaik</p>
            </div>

            <div id="wisata-grid-user" class="grid grid-cols-1 sm:px-0 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="col-span-full text-center py-12 text-slate-400" id="loading-state-user">
                    <i class="fas fa-spinner fa-spin text-3xl text-[#0D3D18] mb-3"></i>
                    <p class="font-bold text-slate-600 animate-pulse text-sm">Menarik data kategori pesanan Anda...</p>
                </div>
            </div>
        </div>

    </div>

    <footer class="bg-white border-t border-slate-100 py-8 text-center text-slate-400 text-xs font-semibold tracking-wider uppercase">
        <p>&copy; 2026 CitiisGo - Portal Reservasi Wisatawan</p>
    </footer>

    <script>
        // Toggle Mobile / Hamburger Menu
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        hamburgerBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Integrasi Data API Layanan
        const BASE_API_URL = window.location.origin + '/api/v1';

        async function loadWisataUser() {
            const gridContainer = document.getElementById('wisata-grid-user');
            const loadingState = document.getElementById('loading-state-user');

            try {
                const response = await fetch(`${BASE_API_URL}/wisata`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    if (loadingState) loadingState.remove();
                    gridContainer.innerHTML = '';

                    result.data.forEach(wisata => {
                        const realImage = wisata.foto_url;
                        const hargaFormat = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(wisata.harga_tiket);

                        const cardHTML = `
                            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition flex flex-col h-full group">
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
                        <p class="text-red-500 font-bold text-sm">Gagal Menarik Data Layanan!</p>
                    `;
                }
            }
        }

        document.addEventListener('DOMContentLoaded', loadWisataUser);
    </script>

</body>
</html>