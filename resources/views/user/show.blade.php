<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemesanan - CitiisGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
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
                    <a href="{{ route('user.dashboard') }}" class="text-2xl font-black text-brand-green tracking-tight">Citiis<span class="text-slate-800">Go</span></a>
                    <span class="bg-emerald-50 text-emerald-700 text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full border border-emerald-100">Pemesanan Tiket</span>
                </div>
                <a href="{{ route('user.wisata.index') }}" class="text-xs font-bold text-slate-600 hover:text-brand-green transition flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <div>
                <div class="rounded-3xl overflow-hidden shadow-sm border border-slate-200 h-80 bg-slate-200 mb-6">
                    <img id="wisata-foto" src="" alt="Foto Wisata" class="w-full h-full object-cover">
                </div>
                
                <h1 id="wisata-nama" class="text-3xl font-black text-slate-900 tracking-tight mb-3 animate-pulse bg-slate-200 h-8 rounded w-3/4"></h1>
                <p id="wisata-deskripsi" class="text-gray-600 text-sm leading-relaxed mb-6 bg-slate-200 h-16 rounded animate-pulse"></p>

                <div class="flex items-center gap-4 border-t border-slate-100 pt-6">
                    <div class="bg-emerald-50 text-brand-green p-4 rounded-2xl flex items-center justify-center text-2xl"><i class="fa-solid fa-location-dot"></i></div>
                    <div>
                        <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Lokasi / Alamat</div>
                        <div id="wisata-alamat" class="font-bold text-slate-700 text-sm">Memuat lokasi...</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-8 border border-slate-100 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-black text-slate-800 tracking-tight mb-1">Formulir Reservasi</h2>
                    <p class="text-slate-400 text-xs mb-6">Lengkapi data kunjungan Anda di bawah ini</p>

                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5 mb-6 flex justify-between items-center">
                        <span class="text-xs font-bold text-slate-600">Harga Tiket Masuk</span>
                        <span id="wisata-harga" class="text-xl font-black text-accent-orange">Rp 0</span>
                    </div>

                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label class="block text-xs font-bold text-slate-600 mb-2.5" for="tanggal">Tanggal Kunjungan</label>
                            <input class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:bg-white transition" 
                                   id="tanggal" type="date" name="tanggal_kunjungan" required>
                        </div>

                        <div class="mb-5">
                            <label class="block text-xs font-bold text-slate-600 mb-2.5" for="jumlah">Jumlah Tiket (Orang)</label>
                            <input class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:bg-white transition" 
                                   id="jumlah" type="number" name="jumlah_tiket" min="1" value="1" placeholder="1" required>
                        </div>

                        <button class="w-full bg-brand-green text-white font-bold py-4 rounded-2xl hover-bg-brand-green transition shadow-xl shadow-emerald-100 flex items-center justify-center gap-3 tracking-wide text-sm mt-8" 
                                type="submit">
                            <i class="fa-solid fa-lock"></i> Lanjutkan Pembayaran Reservasi
                        </button>
                    </form>
                </div>

                <div class="mt-6 border-t border-slate-50 pt-4 flex items-center gap-3 text-[10px] text-slate-400 font-bold tracking-wider uppercase">
                    <i class="fa-solid fa-shield-halved text-accent-orange"></i> Transaksi terenkripsi & aman
                </div>
            </div>

        </div>

    </main>

    <footer class="bg-white border-t border-slate-100 py-8 mt-12 text-center text-slate-400 text-xs font-semibold tracking-wider uppercase">
        <p>&copy; 2026 CitiisGo - Portal Reservasi Wisatawan</p>
    </footer>

    <script>
        const BASE_API_URL = window.location.origin + '/api/v1';
        const wisataId = "{{ $id ?? '' }}";

        async function fetchDetailWisata() {
            if (!wisataId) return;
            try {
                const response = await fetch(`${BASE_API_URL}/wisata/${wisataId}`);
                const result = await response.json();

                if (result.success) {
                    const data = result.data;
                    
                    document.getElementById('wisata-foto').src = data.foto_url;
                    document.getElementById('wisata-nama').textContent = data.nama;
                    document.getElementById('wisata-nama').classList.remove('animate-pulse', 'bg-slate-200');
                    document.getElementById('wisata-deskripsi').textContent = data.deskripsi || 'Nikmati liburan yang seru dan menyenangkan di wisata alam pegunungan ini.';
                    document.getElementById('wisata-deskripsi').classList.remove('animate-pulse', 'bg-slate-200');
                    document.getElementById('wisata-alamat').textContent = data.alamat || 'Area Tasikmalaya';
                    
                    const hargaFormat = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data.harga_tiket);
                    document.getElementById('wisata-harga').textContent = hargaFormat;
                }
            } catch (error) {
                console.error("Gagal mengambil detail:", error);
            }
        }

        document.addEventListener('DOMContentLoaded', fetchDetailWisata);
    </script>

</body>
</html>