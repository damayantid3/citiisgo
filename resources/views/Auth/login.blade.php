<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>CitiisGo — Login Panel</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{
  --g900:#0D3D18;--g800:#1A5C28;--g700:#1A6B2A;--g600:#2E7D32;
  --o500:#F47A20;--o400:#FF9800;
  --t1:#1A1A2E;--t2:#5A6475;--tm:#9BA3AF;--border:#E2E8F0;
}
body{font-family:'Plus Jakarta Sans',sans-serif;min-height:100vh;display:flex;background:#F0F4F8}

/* ── LEFT HERO ── */
.hero{flex:1.1;background:linear-gradient(145deg,var(--g900) 0%,var(--g800) 40%,var(--g700) 70%,var(--g600) 100%);
  display:flex;flex-direction:column;justify-content:center;align-items:center;
  padding:60px 40px;position:relative;overflow:hidden}
.hero::before{content:'';position:absolute;inset:0;
  background:radial-gradient(circle at 30% 70%, rgba(244,122,32,.2) 0%, transparent 60%),
             radial-gradient(circle at 80% 20%, rgba(255,255,255,.05) 0%, transparent 50%)}

/* floating blobs */
.blob{position:absolute;border-radius:50%;opacity:.1}
.blob-1{width:300px;height:300px;background:var(--o500);top:-80px;right:-60px;animation:float1 8s ease-in-out infinite}
.blob-2{width:200px;height:200px;background:#fff;bottom:40px;left:-40px;animation:float2 6s ease-in-out infinite}
.blob-3{width:120px;height:120px;background:var(--o400);bottom:200px;right:40px;animation:float1 5s ease-in-out infinite reverse}
@keyframes float1{0%,100%{transform:translateY(0) rotate(0deg)}50%{transform:translateY(-20px) rotate(5deg)}}
@keyframes float2{0%,100%{transform:translateY(0)}50%{transform:translateY(15px)}}

.hero-content{position:relative;z-index:1;text-align:center;max-width:400px}
.hero-logo-wrap{display:flex;align-items:center;justify-content:center;gap:14px;margin-bottom:32px}
.hero-logo-icon{width:56px;height:56px;background:var(--o500);border-radius:16px;
  display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:26px;
  box-shadow:0 8px 24px rgba(244,122,32,.4)}
.hero-logo-text{color:#fff;font-size:32px;font-weight:800;letter-spacing:-.5px}
.hero-tagline{color:rgba(255,255,255,.55);font-size:13px;margin-top:-4px;text-align:left}
.hero-title{color:#fff;font-size:28px;font-weight:800;line-height:1.3;margin-bottom:14px}
.hero-title span{color:var(--o400)}
.hero-desc{color:rgba(255,255,255,.6);font-size:14px;line-height:1.7}

.hero-features{display:flex;flex-direction:column;gap:12px;margin-top:32px;text-align:left}
.feature-item{display:flex;align-items:center;gap:12px;color:rgba(255,255,255,.8);font-size:13px}
.feature-icon{width:34px;height:34px;border-radius:9px;background:rgba(255,255,255,.1);
  display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}

.hero-stats{display:flex;gap:20px;margin-top:36px;justify-content:center}
.hero-stat{text-align:center}
.hs-val{color:#fff;font-size:22px;font-weight:800}
.hs-lbl{color:rgba(255,255,255,.5);font-size:11px;margin-top:2px}
.hs-sep{width:1px;background:rgba(255,255,255,.15);margin:0 4px}

/* ── RIGHT FORM ── */
.form-side{width:420px;flex-shrink:0;display:flex;align-items:center;justify-content:center;
  padding:40px 36px;background:#fff;position:relative}
.form-side::before{content:'';position:absolute;left:0;top:10%;height:80%;width:1px;background:var(--border)}

.form-box{width:100%}
.form-box-header{margin-bottom:28px}
.form-box-header h2{font-size:22px;font-weight:800;color:var(--t1)}
.form-box-header p{color:var(--t2);font-size:13px;margin-top:5px}

.form-group{margin-bottom:16px}
.form-label{display:block;font-size:12.5px;font-weight:600;color:var(--t2);margin-bottom:6px}
.input-wrap{position:relative}
.input-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:16px;color:var(--tm)}
.form-input{width:100%;border:1.5px solid var(--border);border-radius:10px;
  padding:11px 13px 11px 38px;font-size:13.5px;color:var(--t1);font-family:inherit;
  outline:none;transition:all .15s;background:#fff}
.form-input:focus{border-color:var(--g600);box-shadow:0 0 0 3px rgba(46,125,50,.08)}
.form-input.error{border-color:#C62828;background:#FFFBFB}

.error-msg{font-size:11.5px;color:#C62828;margin-top:5px;display:flex;align-items:center;gap:4px}

.forgot-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
.remember-check{display:flex;align-items:center;gap:7px;font-size:12.5px;color:var(--t2);cursor:pointer}
.remember-check input{accent-color:var(--g600);width:14px;height:14px}
.forgot-link{font-size:12.5px;color:var(--g700);text-decoration:none;font-weight:600}
.forgot-link:hover{text-decoration:underline}

.btn-login{width:100%;padding:13px;background:linear-gradient(135deg,var(--g700),var(--g600));
  color:#fff;border:none;border-radius:11px;font-size:14px;font-weight:700;font-family:inherit;
  cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px}
.btn-login:hover{background:linear-gradient(135deg,var(--g800),var(--g700));
  box-shadow:0 6px 20px rgba(26,107,42,.35);transform:translateY(-1px)}
.btn-login:active{transform:translateY(0)}

.role-notice{margin-top:20px;background:#F0F4F8;border-radius:10px;padding:14px;
  border:1px solid var(--border)}
.role-notice p{font-size:12px;color:var(--t2);line-height:1.6}
.role-notice strong{color:var(--t1)}

.form-footer{margin-top:24px;text-align:center;font-size:12px;color:var(--tm)}

/* ── Loading ── */
.btn-login .spinner{display:none;width:16px;height:16px;border:2px solid rgba(255,255,255,.3);
  border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}

@media(max-width:768px){
  body{flex-direction:column}
  .hero{min-height:250px;padding:30px 20px}
  .form-side{width:100%;padding:30px 20px}
}
</style>
</head>
<body>

<!-- ── HERO ── -->
<div class="hero">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
  <div class="blob blob-3"></div>

  <div class="hero-content">
    <div class="hero-logo-wrap">
      <div class="hero-logo-icon">C</div>
      <div>
        <div class="hero-logo-text">CitiisGo</div>
        <div class="hero-tagline">Jelajah · Pesan · Nikmati</div>
      </div>
    </div>

    <div class="hero-title">
      Selamat Datang di<br>
      Panel <span>Manajemen</span> CitiisGo
    </div>
    <div class="hero-desc">
      Kelola destinasi wisata, reservasi, booking camping, penginapan, dan sewa peralatan dalam satu platform terintegrasi.
    </div>

    <div class="hero-features">
      <div class="feature-item">
        <div class="feature-icon">🏞️</div>
        Kelola data wisata & galeri foto
      </div>
      <div class="feature-item">
        <div class="feature-icon">🎫</div>
        Monitor reservasi & booking real-time
      </div>
      <div class="feature-item">
        <div class="feature-icon">📊</div>
        Laporan kunjungan & pendapatan lengkap
      </div>
      <div class="feature-item">
        <div class="feature-icon">💳</div>
        Integrasi pembayaran Midtrans otomatis
      </div>
    </div>

    <div class="hero-stats">
      <div class="hero-stat"><div class="hs-val">4.8K+</div><div class="hs-lbl">Wisatawan</div></div>
      <div class="hs-sep"></div>
      <div class="hero-stat"><div class="hs-val">67</div><div class="hs-lbl">Wisata</div></div>
      <div class="hs-sep"></div>
      <div class="hero-stat"><div class="hs-val">Rp48jt</div><div class="hs-lbl">Pendapatan</div></div>
    </div>
  </div>
</div>

<!-- ── FORM ── -->
<div class="form-side">
  <div class="form-box">
    <div class="form-box-header">
      <h2>Masuk ke Panel 🔐</h2>
      <p>Gunakan akun Admin atau Pengelola untuk mengakses panel ini.</p>
    </div>

    @if(session('error'))
      <div style="background:#FFEBEE;border:1px solid #FFCDD2;border-radius:9px;padding:11px 14px;
        font-size:13px;color:#C62828;margin-bottom:16px;display:flex;align-items:center;gap:8px">
        ❌ {{ session('error') }}
      </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST" id="loginForm">
      @csrf
      <div class="form-group">
        <label class="form-label">Email Address</label>
        <div class="input-wrap">
          <span class="input-icon">📧</span>
          <input type="email" name="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}"
            placeholder="admin@citiisgo.id" value="{{ old('email') }}" required autocomplete="email">
        </div>
        @error('email')
          <div class="error-msg">⚠️ {{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label">Password</label>
        <div class="input-wrap">
          <span class="input-icon">🔒</span>
          <input type="password" name="password" id="pwInput" class="form-input"
            placeholder="Masukkan password" required autocomplete="current-password"
            style="padding-right:42px">
          <button type="button" onclick="togglePw()" style="position:absolute;right:12px;top:50%;
            transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:15px;color:var(--tm)">
            👁️
          </button>
        </div>
      </div>

      <div class="forgot-row">
        <label class="remember-check">
          <input type="checkbox" name="remember"> Ingat saya
        </label>
        <a href="#" class="forgot-link">Lupa password?</a>
      </div>

      <button type="submit" class="btn-login" id="loginBtn">
        <span class="spinner" id="spinner"></span>
        <span id="btnText">🚀 Masuk ke Panel</span>
      </button>
    </form>

    <div class="role-notice">
      <p>
        <strong>⚠️ Khusus Admin & Pengelola.</strong><br>
        Panel web ini hanya dapat diakses oleh akun dengan role <strong>Admin</strong> atau <strong>Pengelola Wisata</strong>.<br>
        Wisatawan menggunakan aplikasi mobile CitiisGo.
      </p>
    </div>

    <div class="form-footer">
      © 2025 CitiisGo · Versi 1.0.0
    </div>
  </div>
</div>

<script>
function togglePw() {
  const input = document.getElementById('pwInput');
  input.type = input.type === 'password' ? 'text' : 'password';
}
document.getElementById('loginForm').addEventListener('submit', function() {
  document.getElementById('loginBtn').disabled = true;
  document.getElementById('spinner').style.display = 'block';
  document.getElementById('btnText').textContent = 'Memproses...';
});
</script>
</body>
</html>