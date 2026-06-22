<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - CitiisGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-forest-green { background-color: #0d3d18; }
        .hover-bg-forest-green:hover { background-color: #1a5c28; }
        .text-accent-orange { color: #f47a20; }
        .focus-ring-forest:focus-within { box-shadow: 0 0 0 4px rgba(13, 61, 24, 0.15); border-color: #0d3d18; }
    </style>
</head>
<body class="bg-slate-50 font-sans antialiased min-h-screen flex flex-col justify-between p-4 md:p-6">

    <div class="w-full max-w-md mx-auto flex justify-center pt-6 mb-2">
        <div class="w-24 h-24 bg-white rounded-3xl shadow-xl border border-slate-100 p-2.5 flex items-center justify-center">
           <img src="{{ asset('assets/img/CitiisgoLogo.jpeg') }}" alt="CitiisGo Logo" class="h-8 w-auto object-contain">
        </div>
    </div>

    <main class="w-full max-w-md mx-auto bg-white rounded-3xl shadow-2xl p-8 md:p-10 border border-slate-100 my-4">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Selamat Datang</h1>
            <p class="text-slate-500 text-xs font-medium mt-2">Silakan masuk menggunakan akun terdaftar Anda</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border border-red-100 rounded-2xl p-4 text-xs font-semibold text-red-700 mb-5 flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation text-base flex-shrink-0"></i> 
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 text-xs font-semibold text-emerald-700 mb-5 flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-base flex-shrink-0"></i> 
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" id="loginForm">
            @csrf
            
            <div class="mb-5">
                <label class="block text-xs font-bold text-slate-600 mb-2.5" for="email">Alamat Email</label>
                <div class="relative focus-ring-forest rounded-2xl border border-slate-200 bg-slate-50 transition">
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="fa-solid fa-envelope text-sm"></i>
                    </span>
                    <input class="w-full pl-12 pr-4 py-3.5 bg-transparent rounded-2xl text-sm font-medium text-slate-800 focus:outline-none" 
                           id="email" type="email" name="email" placeholder="nama@domain.com" value="{{ old('email') }}" required autocomplete="email">
                </div>
                @error('email')
                    <p class="text-red-600 text-[11px] font-semibold mt-1.5 flex items-center gap-1"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-xs font-bold text-slate-600 mb-2.5" for="pwInput">Kata Sandi</label>
                <div class="relative focus-ring-forest rounded-2xl border border-slate-200 bg-slate-50 transition">
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </span>
                    <input class="w-full pl-12 pr-14 py-3.5 bg-transparent rounded-2xl text-sm font-medium text-slate-800 focus:outline-none" 
                           id="pwInput" type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                    
                    <button type="button" onclick="togglePw()" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 outline-none w-5 h-5 flex items-center justify-center">
                        <i class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between mb-8 text-xs font-bold">
                <label class="flex items-center gap-2.5 text-slate-600 cursor-pointer">
                    <input class="w-4 h-4 rounded border-slate-300 text-[#0d3d18] focus:ring-[#1a5c28] accent-[#0d3d18]" type="checkbox" name="remember"> 
                    <span>Ingat saya</span>
                </label>
                <a href="#" class="text-[#0d3d18] hover:underline">Lupa password?</a>
            </div>

            <button class="w-full bg-forest-green text-white font-semibold py-3.5 rounded-2xl hover-bg-forest-green transition shadow-xl shadow-emerald-100 flex items-center justify-center gap-3 tracking-wide" 
                    type="submit" id="loginBtn">
                <span class="spinner hidden w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin" id="spinner"></span>
                <span id="btnText">Masuk Aplikasi</span>
            </button>
        </form>

        <div class="mt-6 text-center text-xs font-bold text-slate-500">
            Belum punya akun? <a href="{{ route('register') }}" class="text-accent-orange hover:underline">Daftar sekarang</a>
        </div>
    </main>

    <footer class="w-full max-w-md mx-auto text-center text-[10px] font-semibold text-slate-400 tracking-wider uppercase pb-4">
        Copyright &copy; 2026 CitiisGo
    </footer>

    <script>
        function togglePw() {
            const input = document.getElementById('pwInput');
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            const spinner = document.getElementById('spinner');
            const btnText = document.getElementById('btnText');
            
            btn.disabled = true;
            btn.classList.remove('bg-forest-green', 'hover-bg-forest-green');
            btn.classList.add('bg-slate-500');
            spinner.classList.remove('hidden');
            btnText.textContent = 'Memvalidasi Sesi...';
        });
    </script>
</body>
</html>