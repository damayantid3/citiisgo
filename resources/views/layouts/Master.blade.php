<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CitiisGo') - @yield('role_title', 'Dashboard')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            /* CitiisGo Brand Colors */
            --primary: #1a6b2e;
            --primary-light: #2d9e47;
            --primary-lighter: #e8f5ec;
            --secondary: #f97316;
            --secondary-light: #fdba74;
            --secondary-lighter: #fff7ed;
            --dark: #0f1f15;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --white: #ffffff;
            --sidebar-width: 260px;
            --header-height: 70px;
            --radius: 12px;
            --shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            min-height: 100vh;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            left: 0; top: 0; bottom: 0;
            width: var(--sidebar-width);
            background: var(--dark);
            background: linear-gradient(160deg, #0f1f15 0%, #1a3a23 100%);
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 2px; }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand img {
            width: 40px;
            height: 40px;
            border-radius: 10px;
        }

        .sidebar-brand-text { display: flex; flex-direction: column; }
        .sidebar-brand-name {
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.3px;
        }
        .sidebar-brand-name span { color: var(--secondary); }
        .sidebar-brand-role {
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-nav { padding: 16px 12px; }

        .nav-label {
            font-size: 10px;
            font-weight: 700;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 12px 8px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 2px;
            position: relative;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .nav-item.active {
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: #fff;
            box-shadow: 0 4px 12px rgba(26,107,46,0.4);
        }

        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--secondary);
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
        }

        /* ========== MAIN CONTENT ========== */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ========== HEADER ========== */
        .header {
            position: sticky;
            top: 0;
            z-index: 900;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            height: var(--header-height);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
        }

        .header-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-900);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1.5px solid var(--gray-200);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            color: var(--gray-600);
            font-size: 15px;
            transition: all 0.2s;
        }

        .header-btn:hover { border-color: var(--primary); color: var(--primary); }

        .notif-dot {
            position: absolute;
            top: 6px; right: 6px;
            width: 8px; height: 8px;
            background: var(--secondary);
            border-radius: 50%;
            border: 2px solid white;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px 6px 6px;
            border-radius: 12px;
            border: 1.5px solid var(--gray-200);
            background: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-menu:hover { border-color: var(--primary); }

        .user-avatar {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: 700;
        }

        .user-info { display: flex; flex-direction: column; }
        .user-name { font-size: 13px; font-weight: 600; color: var(--gray-800); }
        .user-role { font-size: 11px; color: var(--gray-400); }

        /* ========== PAGE CONTENT ========== */
        .page-content {
            flex: 1;
            padding: 28px;
        }

        /* ========== CARDS ========== */
        .card {
            background: white;
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow);
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--gray-900);
        }

        .card-body { padding: 24px; }

        /* ========== STAT CARDS ========== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: white;
            border-radius: var(--radius);
            padding: 24px;
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }

        .stat-card.green::before { background: linear-gradient(90deg, var(--primary), var(--primary-light)); }
        .stat-card.orange::before { background: linear-gradient(90deg, var(--secondary), #fbbf24); }
        .stat-card.blue::before { background: linear-gradient(90deg, var(--info), #60a5fa); }
        .stat-card.red::before { background: linear-gradient(90deg, var(--danger), #f87171); }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .stat-icon.green { background: var(--primary-lighter); color: var(--primary); }
        .stat-icon.orange { background: #fff7ed; color: var(--secondary); }
        .stat-icon.blue { background: #eff6ff; color: var(--info); }
        .stat-icon.red { background: #fef2f2; color: var(--danger); }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--gray-900);
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--gray-500);
            font-weight: 500;
        }

        .stat-change {
            margin-top: 12px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stat-change.up { color: var(--success); }
        .stat-change.down { color: var(--danger); }

        /* ========== TABLE ========== */
        .table-wrapper { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead th {
            background: var(--gray-50);
            color: var(--gray-500);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        tbody tr {
            border-bottom: 1px solid var(--gray-100);
            transition: background 0.15s;
        }

        tbody tr:hover { background: var(--gray-50); }
        tbody tr:last-child { border-bottom: none; }

        tbody td {
            padding: 14px 16px;
            color: var(--gray-700);
        }

        /* ========== BADGES ========== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .badge-secondary { background: var(--gray-100); color: var(--gray-600); }
        .badge-primary { background: var(--primary-lighter); color: var(--primary); }

        /* ========== BUTTONS ========== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            box-shadow: 0 4px 12px rgba(26,107,46,0.3);
        }

        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(26,107,46,0.4); }

        .btn-secondary {
            background: var(--secondary);
            color: white;
        }

        .btn-secondary:hover { background: #ea6c00; }

        .btn-outline {
            background: white;
            border: 1.5px solid var(--gray-200);
            color: var(--gray-700);
        }

        .btn-outline:hover { border-color: var(--primary); color: var(--primary); }

        .btn-danger { background: var(--danger); color: white; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .btn-icon { padding: 8px; }

        /* ========== FORMS ========== */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--gray-200);
            border-radius: 9px;
            font-size: 14px;
            font-family: inherit;
            color: var(--gray-800);
            background: white;
            transition: border-color 0.2s;
            outline: none;
        }

        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(26,107,46,0.1); }

        select.form-control { cursor: pointer; }

        /* ========== ALERTS ========== */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .alert-info { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }

        /* ========== PAGINATION ========== */
        .pagination {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 16px 24px;
            border-top: 1px solid var(--gray-100);
        }

        .page-link {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-600);
            text-decoration: none;
            border: 1.5px solid transparent;
            transition: all 0.2s;
        }

        .page-link:hover { border-color: var(--primary); color: var(--primary); }
        .page-link.active { background: var(--primary); color: white; border-color: var(--primary); }

        /* ========== UTILITIES ========== */
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .gap-4 { gap: 16px; }
        .mt-4 { margin-top: 16px; }
        .mb-4 { margin-bottom: 16px; }
        .text-sm { font-size: 13px; }
        .text-gray { color: var(--gray-500); }
        .text-primary { color: var(--primary); }
        .font-bold { font-weight: 700; }
        .rounded-full { border-radius: 50%; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
        }

        /* ========== SCROLLBAR ========== */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--gray-100); }
        ::-webkit-scrollbar-thumb { background: var(--gray-300); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gray-400); }

        /* ========== LOADING ========== */
        .spinner {
            width: 20px; height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ========== MAP MARKER ========== */
        .wisata-marker {
            width: 36px; height: 36px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--gray-200);
            overflow: hidden;
        }

        .wisata-marker img { width: 100%; height: 100%; object-fit: cover; }

        /* Sidebar user info */
        .sidebar-user {
            padding: 12px 16px;
            margin: 8px 12px;
            border-radius: 10px;
            background: rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-user-avatar {
            width: 36px; height: 36px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--primary-light), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 15px;
            flex-shrink: 0;
        }

        .sidebar-user-name { font-size: 13px; font-weight: 600; color: white; }
        .sidebar-user-email { font-size: 11px; color: rgba(255,255,255,0.4); }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--gray-400);
            margin-bottom: 20px;
        }
        .breadcrumb a { color: var(--gray-400); text-decoration: none; }
        .breadcrumb a:hover { color: var(--primary); }
        .breadcrumb-current { color: var(--gray-700); font-weight: 600; }
    </style>

    @stack('styles')
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#1a6b2e,#2d9e47);display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-map-location-dot" style="color:white;font-size:18px;"></i>
        </div>
        <div class="sidebar-brand-text">
            <div class="sidebar-brand-name">Citiis<span>Go</span></div>
            <div class="sidebar-brand-role">@yield('sidebar_role', 'Admin Panel')</div>
        </div>
    </div>

    @auth
    <div class="sidebar-user">
        <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}</div>
        <div>
            <div class="sidebar-user-name">{{ auth()->user()->nama }}</div>
            <div class="sidebar-user-email">{{ auth()->user()->email }}</div>
        </div>
    </div>
    @endauth

    <nav class="sidebar-nav">
        @yield('sidebar_menu')
    </nav>
</aside>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
    <!-- HEADER -->
    <header class="header">
        <div class="flex items-center gap-3">
            <button class="header-btn" id="sidebarToggle" style="display:none;">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="header-title">@yield('page_title', 'Dashboard')</h1>
        </div>
        <div class="header-right">
            <a href="{{ route('notifikasi.index') }}" class="header-btn">
                <i class="fas fa-bell"></i>
                @if(isset($unreadNotif) && $unreadNotif > 0)
                <span class="notif-dot"></span>
                @endif
            </a>
            <div class="user-menu" onclick="toggleUserDropdown()">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 1)) }}</div>
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->nama ?? 'User' }}</span>
                    <span class="user-role">{{ ucfirst(auth()->user()->role ?? '') }}</span>
                </div>
                <i class="fas fa-chevron-down" style="font-size:11px;color:var(--gray-400);margin-left:4px;"></i>
            </div>
        </div>
    </header>

    <!-- PAGE CONTENT -->
    <main class="page-content">
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </main>
</div>

<script>
function toggleUserDropdown() {
    // Implement dropdown
}

document.getElementById('sidebarToggle')?.addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('open');
});

// Mobile check
if (window.innerWidth <= 768) {
    document.getElementById('sidebarToggle').style.display = 'flex';
}

// Auto-close alerts
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(a => {
        a.style.opacity = '0';
        a.style.transition = 'opacity 0.5s';
        setTimeout(() => a.remove(), 500);
    });
}, 4000);
</script>

@stack('scripts')
</body>
</html>