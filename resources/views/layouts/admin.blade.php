<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CitiisGo Admin')</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])
</head>
<body>

    <!-- SIDEBAR -->
    <nav class="sidebar">

        <div class="sidebar-logo">
            <div style="display:flex;align-items:center;gap:10px">

                <div style="
                    width:36px;
                    height:36px;
                    background:var(--orange-500);
                    border-radius:10px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    color:#fff;
                    font-weight:800;
                    font-size:16px;
                ">
                    C
                </div>

                <div>
                    <div class="logo-text">CitiisGo</div>
                    <div class="logo-sub">Jelajah · Pesan · Nikmati</div>
                </div>

            </div>
        </div>

        <div style="padding:8px 0">

            <div class="sidebar-section">
                Menu Utama
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-item active">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>

                </svg>

                Dashboard
            </a>

            <a href="#"
               class="sidebar-item">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>

                </svg>

                Manajemen User

                <span class="sidebar-badge">
                    24
                </span>

            </a>

            <a href="#"
               class="sidebar-item">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>

                </svg>

                Data Wisata
            </a>

            <a href="#"
               class="sidebar-item">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <line x1="8" y1="6" x2="21" y2="6"/>
                    <line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/>
                    <line x1="3" y1="6" x2="3.01" y2="6"/>
                    <line x1="3" y1="12" x2="3.01" y2="12"/>
                    <line x1="3" y1="18" x2="3.01" y2="18"/>

                </svg>

                Kategori Wisata
            </a>

            <div class="sidebar-section">
                Transaksi
            </div>

            <a href="#"
               class="sidebar-item">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <rect x="1" y="4"
                          width="22"
                          height="16"
                          rx="2"/>

                    <line x1="1"
                          y1="10"
                          x2="23"
                          y2="10"/>

                </svg>

                Pembayaran

                <span class="sidebar-badge">
                    7
                </span>

            </a>

            <a href="#"
               class="sidebar-item">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>

                </svg>

                Laporan
            </a>

            <div class="sidebar-section">
                Sistem
            </div>

            <a href="#"
               class="sidebar-item">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <circle cx="12" cy="12" r="3"/>

                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>

                </svg>

                Pengaturan
            </a>

        </div>

        <div class="sidebar-bottom">

            <div class="sidebar-user">

                <div class="user-avatar">
                    AD
                </div>

                <div class="user-info">
                    <p>Admin CitiisGo</p>
                    <span>Super Administrator</span>
                </div>

            </div>

        </div>

    </nav>

    <!-- MAIN -->
    <div class="main">

        @yield('content')

    </div>

    @yield('scripts')

</body>
</html>