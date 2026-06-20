<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CitiisGo - Platform Pemesanan Wisata Pegunungan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .bg-brand-green { background-color: #0D3D18; }
        .hover-bg-brand-green:hover { background-color: #1A5C28; }
        .text-accent-orange { color: #F47A20; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-slate-700">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-black text-[#0D3D18] tracking-tight">Citiis<span class="text-slate-800">Go</span></a>
                </div>
                <div class="hidden md:flex space-x-8 text-sm font-bold text-slate-600">
                    <a href="#" class="text-brand-green border-b-2 border-[#0D3D18] pb-2">Beranda</a>
                    <a href="#wisata-section" class="hover:text-brand-green transition">Destinasi</a>
                    <a href="{{ url('/camping') }}" class="hover:text-brand-green transition">Camping</a>
                    <a href="{{ url('/penginapan') }}" class="hover:text-brand-green transition">Penginapan</a>
                </div>
                <div>
                    <a href="/login" class="bg-brand-green text-white px-6 py-2.5 rounded-xl font-bold text-xs hover-bg-brand-green transition shadow-sm tracking-wide">Masuk</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-slate-900 overflow-hidden py-24 md:py-32">
        <img src="https://images.unsplash.com/photo-1506012787146-f92b2d7d6d96?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Pemandangan Alam" class="absolute inset-0 w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent"></div>
        <div class="relative max-w-4xl mx-auto px-4 text-center text-white">
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-6 leading-tight">Jelajahi Keindahan Wisata<br/><span class="text-accent-orange">Citiis & Sekitarnya</span></h1>
            <p class="text-lg md:text-xl text-gray-200 max-w-2xl mx-auto mb-10">Rencanakan liburan, kemah di alam terbuka, dan sewa perlengkapan secara mudah dalam satu genggaman.</p>
            <a href="#wisata-section" class="bg-white text-slate-900 px-8 py-4 rounded-full font-bold text-xs hover:bg-gray-100 transition shadow-lg inline-flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-compass"></i> Mulai Jelajahi
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 text-[#0D3D18] rounded-xl flex items-center justify-center text-xl"><i class="fa-solid fa-mountain-sun"></i></div>
                <div>
                    <div class="font-bold text-slate-800 text-sm">Alam & Pegunungan</div>
                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Destinasi Asri</div>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-50 text-[#F47A20] rounded-xl flex items-center justify-center text-xl"><i class="fa-solid fa-tent"></i></div>
                <div>
                    <div class="font-bold text-slate-800 text-sm">Camping Area</div>
                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Bumi Perkemahan</div>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl"><i class="fa-solid fa-house-chimney-window"></i></div>
                <div>
                    <div class="font-bold text-slate-800 text-sm">Penginapan</div>
                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Villa & Homestay</div>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl"><i class="fa-solid fa-person-hiking"></i></div>
                <div>
                    <div class="font-bold text-slate-800 text-sm">Sewa Alat</div>
                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Perlengkapan Outdoor</div>
                </div>
            </div>
        </div>
    </div>

    <div id="wisata-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Destinasi Pilihan</h2>
                <p class="text-gray-500 mt-1 text-xs">Pilih destinasi wisata resmi dengan fasilitas terbaik dan terpercaya</p>
            </div>
            <a href="{{ url('/destinasi') }}" class="text-[#0D3D18] font-bold text-xs hover:underline flex items-center gap-1">
                Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div id="wisata-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="col-span-full text-center py-12 text-gray-400" id="loading-state">
                <i class="fas fa-spinner fa-spin text-3xl text-[#0D3D18] mb-3"></i>
                <p class="font-medium text-slate-600 animate-pulse text-sm">Menarik data destinasi dari server backend...</p>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-400 text-xs font-semibold tracking-wider uppercase">
            &copy; 2026 CitiisGo - Platform Reservasi Terpadu
        </div>
    </footer>

    <script>
        const BASE_API_URL = window.location.origin + '/api/v1';

        async function loadWisataPublic() {
            const gridContainer = document.getElementById('wisata-grid');
            const loadingState = document.getElementById('loading-state');

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
                            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition flex flex-col h-full group">
                                <div class="h-48 bg-teal-50 relative overflow-hidden">
                                    <img src="${realImage}" alt="${wisata.nama}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-slate-800 text-xs font-black px-3 py-1.5 rounded-full shadow-sm border border-white/20">
                                        <i class="fa-solid fa-ticket text-[#0D3D18] mr-1"></i> ${hargaFormat}
                                    </span>
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <h3 class="font-bold text-base text-slate-900 mb-2 line-clamp-1 group-hover:text-[#0D3D18] transition">${wisata.nama}</h3>
                                    <p class="text-gray-500 text-xs mb-4 line-clamp-3 flex-grow">${wisata.deskripsi || 'Nikmati liburan yang seru dan menyenangkan di wisata alam pegunungan ini.'}</p>
                                    <div class="border-t border-gray-50 pt-4 mt-auto flex items-center justify-between">
                                        <span class="text-xs text-gray-400 font-semibold flex items-center gap-1.5 max-w-[65%]">
                                            <i class="fa-solid fa-location-dot flex-shrink-0"></i> 
                                            <span class="truncate" title="${wisata.alamat}">${wisata.alamat || 'Area Tasikmalaya'}</span>
                                        </span>
                                        <a href="/login" class="bg-emerald-50 text-[#0D3D18] hover:bg-[#0D3D18] hover:text-white text-xs font-bold px-4 py-2.5 rounded-xl transition flex-shrink-0 shadow-sm border border-emerald-100">
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
                            <i class="fa-solid fa-ban text-3xl text-gray-300 mb-2 block"></i>
                            <p class="font-semibold text-slate-600">Belum ada data destinasi.</p>
                        `;
                    }
                }
            } catch (error) {
                console.error('Gagal:', error);
                if (loadingState) {
                    loadingState.innerHTML = `
                        <i class="fa-solid fa-triangle-exclamation text-3xl text-red-400 mb-2 block"></i>
                        <p class="text-red-500 font-bold">Gagal Terhubung ke Backend API!</p>
                    `;
                }
            }
        }

        document.addEventListener('DOMContentLoaded', loadWisataPublic);
    </script>

</body>
</html>