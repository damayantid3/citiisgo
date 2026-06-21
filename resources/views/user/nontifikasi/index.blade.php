@extends('layouts.app')
@section('title', 'Notifikasi - CitiisGo')
@section('topbar-title', '🔔 Kotak Pesan & Notifikasi')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-black text-slate-800 tracking-tight">Pusat Pemberitahuan</h1>
        <p class="text-xs text-slate-500 font-medium">Informasi terkini mengenai status booking dan reservasi wisata Anda.</p>
    </div>
    @if(count($notifData ?? []) > 0)
    <form action="{{ route('user.notifikasi.read-all') }}" method="POST">
        @csrf
        <button type="submit" class="bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl px-4 h-9 text-2xs font-bold text-slate-600 active:scale-95 transition-transform cursor-pointer">✓ Tandai Semua Dibaca</button>
    </form>
    @endif
</div>

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden max-w-2xl">
    <div class="divide-y divide-slate-100 text-xs text-slate-600 font-medium">
        @forelse($notifData ?? [] as $notif)
            @php
                $isRead = !empty($notif['read_at']);
            @endphp
            <div class="flex items-start justify-between p-4 hover:bg-slate-50/50 transition-colors {{ $isRead ? 'opacity-60 bg-slate-50/30' : 'bg-white' }}">
                <div class="flex items-start gap-3.5 min-w-0">
                    <div class="flex-shrink-0 mt-0.5">
                        @if($isRead)
                            <div class="w-8 h-8 rounded-xl bg-slate-100 border border-slate-200 inline-flex items-center justify-center">📩</div>
                        @else
                            <div class="w-8 h-8 rounded-xl bg-amber-50 border border-amber-200 inline-flex items-center justify-center relative">
                                🔔
                                <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-amber-600 animate-pulse"></span>
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <h4 class="font-bold text-slate-800 text-xs tracking-tight truncate">{{ $notif['data']['title'] ?? 'Pemberitahuan Sistem' }}</h4>
                        <p class="text-2xs text-slate-500 font-semibold mt-0.5 leading-relaxed">{{ $notif['data']['message'] ?? '-' }}</p>
                        <span class="text-[9px] font-bold text-slate-400 block mt-2">
                            🕒 {{ \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}
                        </span>
                    </div>
                </div>
                
                @if(!$isRead)
                <form action="{{ route('user.notifikasi.read', $notif['id']) }}" method="POST" class="flex-shrink-0 ml-4">
                    @csrf @method('PUT')
                    <button type="submit" class="text-[9px] font-black tracking-wider uppercase bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-lg hover:bg-emerald-100 transition-colors cursor-pointer">BACA</button>
                </form>
                @endif
            </div>
        @empty
            <div class="px-6 py-12 text-center text-slate-400 font-semibold text-xs">
                📭 Kotak masuk Anda masih bersih. Belum ada notifikasi.
            </div>
        @endforelse
    </div>
</div>
@endsection