@extends('layouts.user')
@section('title', 'Riwayat Pesanan - CitiisGo')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8 font-sans">

    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">📋 Riwayat Pesanan Saya</h1>
        <p class="text-xs text-slate-500 mt-1">Semua transaksi tiket, camping, dan penginapan Anda tercatat di sini.</p>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold px-4 py-3 rounded-xl mb-6">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- ── TIKET MASUK ─────────────────────────────────────────────── --}}
    <div class="mb-8">
        <h2 class="font-black text-sm text-slate-700 mb-3 uppercase tracking-wider">🎟️ Tiket Masuk</h2>
        @if(!empty($reservasi))
        <div class="space-y-3">
            @foreach($reservasi as $r)
            <div class="bg-white border border-slate-200 rounded-2xl p-5 flex items-center justify-between shadow-sm">
                <div>
                    <div class="font-bold text-sm text-slate-800">{{ $r['wisata']['nama'] ?? 'Destinasi Wisata' }}</div>
                    <div class="text-xs text-slate-400 mt-0.5">📅 {{ $r['tanggal_kunjungan'] ?? '-' }} · 👥 {{ $r['jumlah_orang'] ?? 1 }} orang</div>
                </div>
                <span class="text-[10px] font-black uppercase px-3 py-1.5 rounded-full
                    {{ ($r['status'] ?? '') === 'confirmed' ? 'bg-emerald-100 text-emerald-700' :
                       (($r['status'] ?? '') === 'pending'   ? 'bg-amber-100 text-amber-700' :
                       (($r['status'] ?? '') === 'cancelled' ? 'bg-red-100 text-red-600' : 'bg-slate-100 text-slate-500')) }}">
                    {{ $r['status'] ?? 'pending' }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8 text-center text-slate-400 text-xs">
            Belum ada reservasi tiket masuk. <a href="{{ route('user.wisata.index') }}" class="text-emerald-600 font-bold">Jelajahi sekarang →</a>
        </div>
        @endif
    </div>

    {{-- ── BOOKING CAMPING ──────────────────────────────────────────── --}}
    <div class="mb-8">
        <h2 class="font-black text-sm text-slate-700 mb-3 uppercase tracking-wider">🏕️ Booking Camping</h2>
        @if(!empty($camping))
        <div class="space-y-3">
            @foreach($camping as $c)
            <div class="bg-white border border-slate-200 rounded-2xl p-5 flex items-center justify-between shadow-sm">
                <div>
                    <div class="font-bold text-sm text-slate-800">{{ $c['paket']['nama_paket'] ?? 'Paket Camping' }}</div>
                    <div class="text-xs text-slate-400 mt-0.5">
                        📅 {{ $c['tanggal_checkin'] ?? '-' }} → {{ $c['tanggal_checkout'] ?? '-' }}
                    </div>
                </div>
                <span class="text-[10px] font-black uppercase px-3 py-1.5 rounded-full
                    {{ ($c['status'] ?? '') === 'confirmed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ $c['status'] ?? 'pending' }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8 text-center text-slate-400 text-xs">
            Belum ada booking camping. <a href="{{ route('user.booking.camping') }}" class="text-emerald-600 font-bold">Pesan sekarang →</a>
        </div>
        @endif
    </div>

    {{-- ── BOOKING PENGINAPAN ───────────────────────────────────────── --}}
    <div class="mb-8">
        <h2 class="font-black text-sm text-slate-700 mb-3 uppercase tracking-wider">🏠 Booking Penginapan</h2>
        @if(!empty($penginapan))
        <div class="space-y-3">
            @foreach($penginapan as $p)
            <div class="bg-white border border-slate-200 rounded-2xl p-5 flex items-center justify-between shadow-sm">
                <div>
                    <div class="font-bold text-sm text-slate-800">{{ $p['kamar']['penginapan']['nama'] ?? 'Penginapan' }}</div>
                    <div class="text-xs text-slate-400 mt-0.5">
                        📅 {{ $p['tanggal_checkin'] ?? '-' }} → {{ $p['tanggal_checkout'] ?? '-' }}
                    </div>
                </div>
                <span class="text-[10px] font-black uppercase px-3 py-1.5 rounded-full
                    {{ ($p['status'] ?? '') === 'confirmed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ $p['status'] ?? 'pending' }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8 text-center text-slate-400 text-xs">
            Belum ada booking penginapan.
        </div>
        @endif
    </div>

</div>
@endsection