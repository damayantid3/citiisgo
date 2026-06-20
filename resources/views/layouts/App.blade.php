<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CitiisGo') — Panel {{ strtoupper(session('user_role','')) }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

        /* ACTIVE STATE STYLE */
        .sb-item.active {
            background-color: rgba(255, 255, 255, 0.12) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }
        .sb-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 50%;
            background-color: #f59e0b; /* Warna Oranye khas CitiisgoLogo.jpeg */
            border-radius: 0 4px 4px 0;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full min-h-screen text-slate-800 flex flex-col antialiased">

    {{-- ── SIDEBAR PUSAT (FIXED & FULL HEIGHT FLEX) ── --}}
    <nav class="fixed inset-y-0 left-0 z-50 w-60 flex flex-col justify-between overflow-hidden shadow-xl select-none bg-gradient-to-b from-green-950 via-green-800 to-emerald-900 h-screen">
        
        {{-- KELOMPOK ATAS: LOGO DAN MENU NAVIGASI --}}
        <div class="flex flex-col overflow-hidden">
            {{-- HEADER LOGO UTAMA — Membaca File Gambar CitiisgoLogo.jpeg --}}
            <div class="p-4 border-b border-white/10 flex items-center gap-3 bg-slate-950/20 flex-shrink-0">
                <img src="{{ asset('assets/img/CitiisgoLogo.jpeg') }}" 
                     alt="CitiisGo Logo" 
                     class="w-10 h-10 object-contain rounded-xl bg-white p-0.5 shadow-md">
                <div class="leading-none">
                    <div class="text-white text-base font-extrabold tracking-tight">CitiisGo</div>
                    <div class="text-white/40 text-[10px] mt-0.5">Jelajah · Pesan · Nikmati</div>
                </div>
            </div>

            {{-- INDIKATOR TINGKAT HAK AKSES --}}
            <div class="mx-3 mt-3 px-3 py-1.5 bg-white/10 rounded-xl flex items-center gap-2 border border-white/5 flex-shrink-0">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></div>
                <div class="text-white/80 text-[11px] font-bold">{{ session('user_role') === 'admin' ? 'Administrator' : 'Pengelola Wisata' }}</div>
            </div>

            {{-- WIDGET MENU KONTEN --}}
            <div class="px-2 py-3 overflow-y-auto custom-scrollbar flex-1">
                @if(session('user_role') === 'admin')
                    @include('partials.sidebar-admin')
                @else
                    @include('partials.sidebar-pengelola')
                @endif
            </div>
        </div>

        {{-- KELOMPOK BAWAH: HANYA TOMBOL LOGOUT UTUH --}}
        <div class="p-3 border-t border-white/10 bg-slate-950/40 flex-shrink-0 w-full">
            <form action="{{ route('logout') }}" method="POST" class="m-0 p-0 w-full">
                @csrf
                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin melakukan logout?')"
                        class="w-full flex items-center gap-2.5 px-3 py-2.5 text-xs text-rose-400 hover:text-rose-300 rounded-xl hover:bg-rose-500/10 transition-all duration-150 border-none bg-transparent outline-none font-bold cursor-pointer text-left w-full">
                    <span>🚪</span> <span>Logout</span>
                </button>
            </form>
        </div>
    </nav>

    {{-- ── TOPBAR CONTENT PANEL ── --}}
    <header class="fixed top-0 right-0 left-60 h-16 bg-white/80 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-6 z-40 shadow-sm">
        <div class="flex items-center gap-4 flex-1 min-w-0">
            <div class="text-slate-800 font-bold text-base tracking-tight">@yield('topbar-title', 'Dashboard')</div>
            @hasSection('show-search')
            <div class="flex items-center gap-2 bg-slate-100 border border-slate-200 rounded-xl px-3 h-9 w-64 focus-within:border-emerald-500 focus-within:bg-white transition-all duration-150">
                <span class="text-sm text-slate-400">🔍</span>
                <input placeholder="Cari sesuatu..." id="topSearchInput" class="bg-transparent border-none outline-none text-xs text-slate-700 w-full font-medium">
            </div>
            @endif
        </div>
        
        <div class="flex items-center gap-3">
            <button class="w-9 h-9 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 flex items-center justify-center text-sm relative transition-all duration-150 shadow-sm" title="Notifikasi">
                🔔<div class="absolute top-2 right-2 w-2 h-2 bg-amber-500 rounded-full border border-white"></div>
            </button>
            <button class="w-9 h-9 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 flex items-center justify-center text-sm transition-all duration-150 shadow-sm" title="Bantuan">❓</button>
            <div class="h-6 w-[1px] bg-slate-200 mx-1"></div>
            <div class="flex items-center gap-2.5 pl-1">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-xs bg-amber-500 shadow-md">
                    {{ strtoupper(substr(session('user.nama', 'U'), 0, 2)) }}
                </div>
                <div class="hidden md:block text-left">
                    <div class="text-slate-800 text-xs font-bold leading-3">{{ session('user.nama', 'User') }}</div>
                    <div class="text-slate-400 text-[10px] font-medium mt-1 capitalize">{{ session('user_role', '') }}</div>
                </div>
            </div>
        </div>
    </header>

    {{-- ── MAIN CONTAINER CONTENT ── --}}
    <div class="pl-60 pt-16 flex-1 flex flex-col">
        <main class="p-6 flex-1 max-w-[1600px] w-full mx-auto">
            @if(session('success'))
              <div class="alert bg-emerald-50 text-emerald-800 border border-emerald-200/80 p-4 rounded-xl text-xs font-medium flex items-center gap-3 mb-5 shadow-sm">
                  <span>✅</span> <div>{{ session('success') }}</div>
              </div>
            @endif
            @if(session('error'))
              <div class="alert bg-rose-50 text-rose-800 border border-rose-200/80 p-4 rounded-xl text-xs font-medium flex items-center gap-3 mb-5 shadow-sm">
                  <span>❌</span> <div>{{ session('error') }}</div>
              </div>
            @endif
            @yield('content')
        </main>
    </div>

    <script>
    document.querySelectorAll('.alert').forEach(el => {
        setTimeout(() => { 
            el.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => el.remove(), 500); 
        }, 4000);
    });
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden'); modal.classList.add('flex');
    }
    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('flex'); modal.classList.add('hidden');
    }
    document.querySelectorAll('.modal-backdrop').forEach(m => {
        m.addEventListener('click', e => { if(e.target === m) closeModal(m.id); });
    });
    </script>
    @stack('scripts')
</body>
</html>