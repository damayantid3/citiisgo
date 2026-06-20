<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CitiisGo — Pendaftaran Akun Baru</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #0D3D18;
            --primary-light: #1A5C28;
            --accent: #F47A20;
            --t1: #0F172A;
            --t2: #475569;
            --tm: #94A3B8;
            --border: #E2E8F0;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #F8FAFC;
            overflow-x: hidden;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        /* HEADER LOGO */
        .brand-header {
            margin-bottom: 32px;
            display: flex;
            justify-content: center;
        }
        .brand-logo-box {
            width: 96px;
            height: 96px;
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
        }
        .brand-logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 20px;
        }

        /* KARTU FORM UTAMA */
        .main-card {
            width: 100%;
            max-width: 460px;
            background: #ffffff;
            border-radius: 32px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.04);
            border: 1px solid var(--border);
        }

        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .form-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: var(--t1);
            letter-spacing: -0.5px;
        }
        .form-header p {
            color: var(--t2);
            font-size: 13.5px;
            margin-top: 8px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--t2);
            margin-bottom: 8px;
        }
        .input-wrapper {
            position: relative;
        }
        /* ICONS MENGGUNAKAN KELAS FONT AWESOME SEPERTI PADA HALAMAN LOGIN */
        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: var(--tm);
        }
        .form-input {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 16px;
            padding: 14px 16px 14px 52px;
            font-size: 14px;
            color: var(--t1);
            font-family: inherit;
            font-weight: 500;
            outline: none;
            transition: all 0.2s;
            background: #F8FAFC;
        }
        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(13, 61, 24, 0.06);
            background: #ffffff;
        }
        .form-input.error {
            border-color: #EF4444;
            background: #FEF2F2;
        }

        .error-msg {
            font-size: 11.5px;
            color: #EF4444;
            margin-top: 6px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* TOMBOL DAFTAR */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 16px;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 6px 15px rgba(13, 61, 24, 0.15);
            margin-top: 8px;
        }
        .btn-submit:hover {
            background: var(--primary-light);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(13, 61, 24, 0.25);
        }

        .login-prompt {
            margin-top: 28px;
            text-align: center;
            font-size: 13.5px;
            color: var(--t2);
            font-weight: 500;
        }
        .login-link {
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
            margin-left: 2px;
        }
        .login-link:hover {
            text-decoration: underline;
        }

        .footer-credits {
            margin-top: 32px;
            text-align: center;
            font-size: 11px;
            color: var(--tm);
            font-weight: 500;
        }

        .btn-submit .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, .3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .6s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>

    <div class="brand-header">
        <div class="brand-logo-box">
            <img src="{{ asset('assets/img/CitiisgoLogo.jpeg') }}" alt="Logo CitiisGo" class="brand-logo">
        </div>
    </div>

    <main class="main-card">
        <div class="form-header">
            <h2>Mulai Petualangan Baru</h2>
            <p>Daftarkan akun Anda untuk kemudahan eksplorasi</p>
        </div>

        {{-- Alert Eror dari Laravel Validation Backend --}}
        @if($errors->any())
            <div style="background:#FFEBEE;border:1px solid #FFCDD2;border-radius:14px;padding:14px 16px;
                font-size:12.5px;color:#C62828;margin-bottom:20px;display:flex;align-items:center;gap:8px;font-weight:500">
                ✕ {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" id="regForm">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input type="text" name="nama" class="form-input {{ $errors->has('nama') ? 'error' : '' }}"
                        placeholder="Nama lengkap Anda" value="{{ old('nama') }}" required>
                </div>
                @error('nama')
                    <div class="error-msg">⚠️ {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Alamat Email</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                        placeholder="nama@domain.com" value="{{ old('email') }}" required>
                </div>
                @error('email')
                    <div class="error-msg">⚠️ {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Kata Sandi</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" name="password" class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                        placeholder="Minimal 8 karakter" required>
                </div>
                @error('password')
                    <div class="error-msg">⚠️ {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Kata Sandi</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-shield-halved input-icon"></i>
                    <input type="password" name="password_confirmation" class="form-input"
                        placeholder="Ulangi kata sandi Anda" required>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="regBtn">
                <span class="spinner" id="spinner"></span>
                <span id="btnText">Daftar Sekarang</span>
            </button>
        </form>

        <div class="login-prompt">
            Sudah punya akun? <a href="{{ route('login') }}" class="login-link">Masuk Sekarang</a>
        </div>

        <div class="footer-credits">
            Copyright © 2026 CitiisGo — All West Java, Indonesia.
        </div>
    </main>

<script>
document.getElementById('regForm').addEventListener('submit', function() {
    document.getElementById('regBtn').disabled = true;
    document.getElementById('spinner').style.display = 'block';
    document.getElementById('btnText').textContent = 'Mendaftarkan...';
});
</script>
</body>
</html>