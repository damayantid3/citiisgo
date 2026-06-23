@extends('layouts.user')
@section('title', ($wisata['nama'] ?? 'Detail Wisata') . ' - CitiisGo')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 font-sans">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-[10px] text-slate-400 mb-6 font-semibold">
        <a href="{{ route('user.wisata.index') }}" class="hover:text-emerald-600">🏠 Jelajah Wisata</a>
        <span>/</span>
        <span class="text-slate-600">{{ $wisata['nama'] ?? 'Detail' }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

        {{-- Kiri: Info Wisata --}}
        <div class="lg:col-span-3">
            <div class="rounded-2xl overflow-hidden h-72 bg-slate-200 mb-6">
                <img src="{{ $wisata['foto_url'] ?? asset('assets/img/wisata/CitiisFoto.jpg') }}"
                     alt="{{ $wisata['nama'] }}" class="w-full h-full object-cover">
            </div>

            <h1 class="text-2xl font-black text-slate-900 tracking-tight mb-2">{{ $wisata['nama'] }}</h1>
            <p class="text-xs text-slate-500 mb-4">📍 {{ $wisata['alamat'] ?? 'Kawasan Wisata Citiis Galunggung' }}</p>
            <p class="text-sm text-slate-600 leading-relaxed mb-6">{{ $wisata['deskripsi'] ?? '-' }}</p>

            {{-- Galeri mini --}}
            @if(!empty($wisata['galeri']))
            <div class="grid grid-cols-4 gap-2 mb-6">
                @foreach(array_slice($wisata['galeri'], 0, 4) as $foto)
                <img src="{{ $foto['foto_url'] ?? $foto['url'] ?? '' }}" class="rounded-xl h-20 w-full object-cover">
                @endforeach
            </div>
            @endif

            {{-- Paket Camping --}}
            @if(!empty($paketCamping))
            <div class="mb-6">
                <h3 class="font-black text-sm text-slate-800 mb-3">🏕️ Paket Camping Tersedia</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($paketCamping as $paket)
                    <div class="border border-slate-200 rounded-xl p-4 bg-white">
                        <div class="font-bold text-sm text-slate-800">{{ $paket['nama_paket'] }}</div>
                        <div class="text-xs text-slate-500 mt-1">👥 Kapasitas: {{ $paket['kapasitas_tamu'] }} orang</div>
                        <div class="text-xs font-black text-emerald-700 mt-1">
                            Rp {{ number_format($paket['harga_per_malam'] ?? 0, 0, ',', '.') }} / malam
                        </div>
                        <a href="{{ route('user.booking.camping', ['wisata' => $wisata['id'], 'paket' => $paket['id']]) }}"
                           class="mt-3 block text-center bg-orange-500 text-white text-xs font-bold py-2 rounded-lg hover:bg-orange-600 transition">
                            Pesan Camping
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Penginapan --}}
            @if(!empty($penginapan))
            <div class="mb-6">
                <h3 class="font-black text-sm text-slate-800 mb-3">🏠 Penginapan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($penginapan as $inp)
                    <div class="border border-slate-200 rounded-xl p-4 bg-white">
                        <div class="font-bold text-sm text-slate-800">{{ $inp['nama'] }}</div>
                        <div class="text-xs text-slate-500 mt-1">{{ $inp['deskripsi'] ?? '-' }}</div>
                        <a href="{{ route('user.booking.penginapan', ['wisata' => $wisata['id']]) }}"
                           class="mt-3 block text-center bg-blue-600 text-white text-xs font-bold py-2 rounded-lg hover:bg-blue-700 transition">
                            Pesan Penginapan
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Kanan: Form Reservasi Tiket Masuk --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-slate-100 sticky top-6">
                <h2 class="text-base font-black text-slate-800 mb-1">🎟️ Reservasi Tiket Masuk</h2>
                <p class="text-xs text-slate-400 mb-5">Isi data kunjungan Anda</p>

                <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 mb-5 flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-600">Harga Tiket / Orang</span>
                    <span class="text-lg font-black text-emerald-700">
                        Rp {{ number_format($wisata['harga_tiket'] ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 text-xs font-bold px-4 py-3 rounded-xl mb-4">
                    {{ session('error') }}
                </div>
                @endif

                <form method="POST" action="{{ route('user.reservasi.store') }}">
                    @csrf
                    <input type="hidden" name="wisata_id" value="{{ $wisata['id'] }}">

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-slate-600 mb-2">Tanggal Kunjungan</label>
                        <input type="date" name="tanggal_kunjungan" min="{{ date('Y-m-d') }}" required
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-slate-600 mb-2">Jumlah Orang</label>
                        <input type="number" name="jumlah_orang" min="1" max="20" value="1" required
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-slate-600 mb-2">Catatan (opsional)</label>
                        <textarea name="catatan" rows="2"
                                  class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 resize-none"></textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-emerald-700 text-white font-bold py-4 rounded-xl hover:bg-emerald-800 transition shadow-lg text-sm flex items-center justify-center gap-2">
                        🔒 Lanjutkan Pembayaran
                    </button>
                </form>

                <div class="mt-4 flex items-center gap-2 text-[10px] text-slate-400 font-bold">
                    <i class="fa-solid fa-shield-halved text-orange-400"></i> Transaksi aman & terenkripsi
                </div>
            </div>
        </div>

    </div>
</div>
@endsection