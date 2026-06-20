<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Wisata - CitiisGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-white shadow-sm py-4 px-6 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-teal-600">CitiisGo</a>
            <a href="/login" class="bg-teal-600 text-white px-5 py-2 rounded-xl font-bold hover:bg-teal-700 transition">Masuk</a>
        </div>
    </nav>

    <div class="bg-gradient-to-r from-teal-800 to-emerald-700 py-12 px-6 text-white text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-2">Jelajahi Wisata & Layanan CitiisGo</h1>
        <p class="text-teal-100 max-w-xl mx-auto">Temukan berbagai destinasi, wahana, dan fasilitas berkemah terbaik di kawasan Galunggung secara mudah dan dinamis.</p>
    </div>

    <div class="max-w-6xl mx-auto py-10 px-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Destinasi & Layanan</h2>

        @if(empty($wisataList))
            <div class="bg-white p-8 rounded-2xl shadow-sm text-center border border-gray-100">
                <p class="text-gray-500 font-medium">Belum ada data wisata atau layanan yang dipublikasikan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($wisataList as $wisata)
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 flex flex-col justify-between hover:shadow-md transition duration-300">
                        <div class="h-48 w-full overflow-hidden bg-gray-200">
                            <img src="{{ $wisata['foto_url'] }}" alt="{{ $wisata['nama'] }}" class="w-full h-full object-cover">
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs bg-teal-50 text-teal-700 px-3 py-1 rounded-full font-bold">{{ $wisata['kategori']['nama'] ?? 'Umum' }}</span>
                                    <span class="text-xs font-semibold text-amber-500 flex items-center">
                                        ⭐ {{ $wisata['rating'] ? number_format($wisata['rating'], 1) : 'Belum ada rating' }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-black text-gray-800 mb-2">{{ $wisata['nama'] }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $wisata['deskripsi'] }}</p>
                            </div>
                            
                            <div class="flex items-center justify-between border-t pt-4">
                                <div>
                                    <span class="text-xs text-gray-400 block font-medium">Harga Tiket / Sewa</span>
                                    <span class="text-lg font-black text-emerald-600">Rp {{ number_format($wisata['harga_tiket'], 0, ',', '.') }}</span>
                                </div>
                                <a href="#" class="bg-gray-100 text-gray-700 text-sm px-4 py-2 rounded-xl font-bold hover:bg-teal-50 hover:text-teal-600 transition">Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <footer class="bg-gray-800 text-gray-400 py-6 text-center text-sm">
        <p>&copy; 2026 CitiisGo Mobile & Web App. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>