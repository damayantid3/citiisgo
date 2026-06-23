<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CitiisGo - Portal Wisatawan')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        :root {
            --brand-green: #0D3D18;
            --brand-green-dark: #082A10;
            --brand-orange: #F47A20;
        }
        .bg-brand-green { background-color: var(--brand-green); }
        .text-brand-green { color: var(--brand-green); }
        .hover-bg-brand-green:hover { background-color: var(--brand-green-dark); }
        .border-brand-green { border-color: var(--brand-green); }
        .text-accent-orange { color: var(--brand-orange); }
        .bg-accent-orange { background-color: var(--brand-orange); }
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        ::-webkit-scrollbar { height: 6px; width: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .scrollbar-none::-webkit-scrollbar { display: none; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 min-h-screen flex flex-col antialiased text-slate-700">

    @php
        $sessUser = session('user', []);
        $userName = $sessUser['nama'] ?? $sessUser['name'] ?? 'Wisatawan';
        $userEmail = $sessUser['email'] ?? 'wisatawan@citiisgo.id';
    @endphp

    {{-- ── MODERN TOP NAVIGATION BAR ── --}}
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

            {{-- Sisi Kiri: Logo Asli & Nama Aplikasi --}}
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 outline-none">
                <img src="{{ asset('assets/img/CitiisgoLogo.jpeg') }}" alt="CitiisGo Logo" class="w-9 h-9 object-cover rounded-xl shadow-sm border border-slate-100">
                <div class="text-left hidden sm:block">
                    <span class="text-base font-black tracking-tight text-slate-900 block leading-tight">CitiisGo</span>
                    <span class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest block">Portal Wisatawan</span>
                </div>
            </a>

            {{-- Sisi Tengah: Menu Navigasi Utama (selaras dengan bottom nav mobile) --}}
            <div class="hidden md:flex items-center gap-2 text-xs font-bold text-slate-500">
                <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'text-brand-green bg-emerald-50' : 'hover:bg-slate-50' }} px-3.5 py-2 rounded-xl flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
                <a href="{{ route('user.wisata.index') }}" class="{{ request()->routeIs('user.wisata.*') ? 'text-brand-green bg-emerald-50' : 'hover:bg-slate-50' }} px-3.5 py-2 rounded-xl flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-compass"></i> Jelajah
                </a>
                <a href="{{ route('user.booking.history') }}" class="{{ request()->routeIs('user.booking.history') ? 'text-brand-green bg-emerald-50' : 'hover:bg-slate-50' }} px-3.5 py-2 rounded-xl flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-receipt"></i> Riwayat
                </a>
                <a href="{{ route('user.profil') }}" class="{{ request()->routeIs('user.profil') ? 'text-brand-green bg-emerald-50' : 'hover:bg-slate-50' }} px-3.5 py-2 rounded-xl flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-user"></i> Profil
                </a>
            </div>

            {{-- Sisi Kanan: Notifikasi, Info Akun & Logout --}}
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('user.notifikasi.index') }}" class="relative w-9 h-9 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 transition">
                    <i class="fa-solid fa-bell text-sm"></i>
                </a>

                <div class="hidden lg:block text-right">
                    <span class="text-xs font-black text-slate-800 block leading-tight">{{ $userName }}</span>
                    <span class="text-[10px] font-mono text-slate-400 block">{{ $userEmail }}</span>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 font-bold text-[11px] px-3.5 h-9 rounded-xl transition-all cursor-pointer border-none">
                        <span class="hidden sm:inline">Keluar</span> <i class="fa-solid fa-arrow-right-from-bracket sm:ml-1.5"></i>
                    </button>
                </form>

                <button id="mobileNavBtn" class="md:hidden w-9 h-9 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600">
                    <i class="fa-solid fa-bars text-sm"></i>
                </button>
            </div>
        </div>

        {{-- Menu Mobile --}}
        <div id="mobileNavMenu" class="hidden md:hidden border-t border-slate-100 bg-white px-4 py-3 space-y-1">
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('user.dashboard') ? 'bg-emerald-50 text-brand-green' : 'text-slate-600' }}"><i class="fa-solid fa-house w-4"></i> Beranda</a>
            <a href="{{ route('user.wisata.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('user.wisata.*') ? 'bg-emerald-50 text-brand-green' : 'text-slate-600' }}"><i class="fa-solid fa-compass w-4"></i> Jelajah</a>
            <a href="{{ route('user.booking.history') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('user.booking.history') ? 'bg-emerald-50 text-brand-green' : 'text-slate-600' }}"><i class="fa-solid fa-receipt w-4"></i> Riwayat</a>
            <a href="{{ route('user.profil') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('user.profil') ? 'bg-emerald-50 text-brand-green' : 'text-slate-600' }}"><i class="fa-solid fa-user w-4"></i> Profil</a>
        </div>
    </nav>

    {{-- ── FLASH MESSAGES ── --}}
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4">
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold px-4 py-3.5 rounded-2xl mb-4 flex items-center gap-2.5">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold px-4 py-3.5 rounded-2xl mb-4 flex items-center gap-2.5">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold px-4 py-3.5 rounded-2xl mb-4 flex items-start gap-2.5">
                <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- ── MAIN CONTENT AREA ── --}}
    <main class="flex-1 w-full bg-slate-50/50">
        @yield('content')
    </main>

    {{-- ── PREMIUM CLEAN FOOTER ── --}}
    <footer class="bg-white border-t border-slate-200 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-medium text-slate-400">
            <div>
                © {{ date('Y') }} <span class="text-slate-700 font-bold">CitiisGo Platform</span> · Tasikmalaya, Jawa Barat, Indonesia.
            </div>
            <div class="flex gap-4">
                <a href="#" class="hover:underline">Ketentuan Layanan</a>
                <span>•</span>
                <a href="#" class="hover:underline">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

    <script>
        const mobileNavBtn = document.getElementById('mobileNavBtn');
        const mobileNavMenu = document.getElementById('mobileNavMenu');
        if (mobileNavBtn) {
            mobileNavBtn.addEventListener('click', () => mobileNavMenu.classList.toggle('hidden'));
        }
    </script>
    @stack('scripts')
</body>
</html>