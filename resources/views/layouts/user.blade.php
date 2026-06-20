<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CitiisGo')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col antialiased">

    {{-- ── MODERN TOP NAVIGATION BAR ── --}}
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-xs">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            
            {{-- Sisi Kiri: Logo Asli & Nama Aplikasi --}}
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/img/CitiisgoLogo.jpeg') }}" alt="CitiisGo Logo" class="w-9 h-9 object-cover rounded-xl shadow-xs border border-slate-100">
                <div class="text-left">
                    <span class="text-base font-black tracking-tight text-slate-900 block leading-tight">CitiisGo</span>
                    <span class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest block">Wisandari Portal</span>
                </div>
            </div>

            {{-- Sisi Tengah: Menu Navigasi --}}
            <div class="hidden sm:flex items-center gap-6 text-xs font-bold text-slate-500">
                <a href="{{ route('user.wisata.index') }}" class="text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-xl flex items-center gap-1.5">🌿 Jelajah Wisata</a>
                <a href="/user/booking/history" class="hover:text-slate-800 transition-colors flex items-center gap-1.5">💼 Pesanan Saya</a>
            </div>

            {{-- Sisi Kanan: Info Akun & Logout --}}
            <div class="flex items-center gap-4">
                <div class="hidden md:text-right md:block">
                    <span class="text-xs font-black text-slate-800 block leading-tight">{{ session('user.name') ?? 'Wisatawan' }}</span>
                    <span class="text-[10px] font-mono text-slate-400 block">{{ session('user.email') ?? 'wisatawan@citiisgo.id' }}</span>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 font-bold text-[11px] px-3.5 h-9 rounded-xl transition-all cursor-pointer">
                        Keluar 🚪
                    </button>
                </form>
            </div>

        </div>
    </nav>

    {{-- ── MAIN CONTENT AREA ── --}}
    <main class="flex-1 w-full bg-slate-50/50">
        @yield('content')
    </main>

    {{-- ── PREMIUM CLEAN FOOTER ── --}}
    <footer class="bg-white border-t border-slate-200 py-6 mt-12">
        <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-medium text-slate-400">
            <div>
                © 2026 <span class="text-slate-700 font-bold">CitiisGo Platform</span> · All West Java, Indonesia.
            </div>
            <div class="flex gap-4">
                <a href="#" class="hover:underline">Ketentuan Layanan</a>
                <span>•</span>
                <a href="#" class="hover:underline">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

</body>
</html>