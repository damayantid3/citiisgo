<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','CitiisGo') — Panel {{ ucfirst(session('user_role','')) }}</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{
  --g900:#0D3D18;--g800:#1A5C28;--g700:#1A6B2A;--g600:#2E7D32;--g500:#388E3C;
  --g400:#4CAF50;--g100:#C8E6C9;--g50:#E8F5E9;
  --o700:#E65100;--o500:#F47A20;--o50:#FFF3E0;
  --b700:#1565C0;--b50:#E3F2FD;--p700:#6A1B9A;--p50:#F3E5F5;
  --r700:#C62828;--r50:#FFEBEE;--y600:#F9A825;--y50:#FFFDE7;
  --t1:#1A1A2E;--t2:#5A6475;--tm:#9BA3AF;
  --bg:#F0F4F8;--card:#fff;--border:#E2E8F0;
  --sw:240px;--topbar:60px;
  --trans:all .25s cubic-bezier(.4,0,.2,1);
}
*{margin:0;padding:0;box-sizing:border-box}html,body{height:100%}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:var(--t1);overflow-x:hidden}

/* SIDEBAR */
.sidebar{width:var(--sw);background:linear-gradient(180deg,var(--g900) 0%,var(--g700) 65%,var(--g600) 100%);height:100vh;position:fixed;left:0;top:0;z-index:300;display:flex;flex-direction:column;overflow-y:auto;overflow-x:hidden;transition:var(--trans);scrollbar-width:none}
.sidebar::-webkit-scrollbar{display:none}
.sidebar.pen{background:linear-gradient(180deg,#0A2B14 0%,var(--g800) 55%,var(--g700) 100%)}
.sidebar.collapsed{width:0;overflow:hidden}
.sb-head{padding:0 12px;height:var(--topbar);display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,.08);flex-shrink:0}
.sb-logo{display:flex;align-items:center;gap:9px;text-decoration:none}
.sb-logo-icon{width:32px;height:32px;background:var(--o500);border-radius:9px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:14px;flex-shrink:0;box-shadow:0 3px 8px rgba(244,122,32,.4)}
.sb-logo-name{color:#fff;font-size:16px;font-weight:800;white-space:nowrap}
.sb-logo-sub{color:rgba(255,255,255,.4);font-size:9px;margin-top:1px;white-space:nowrap}
.sb-close-btn{width:28px;height:28px;border-radius:7px;background:rgba(255,255,255,.1);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.7);font-size:15px;flex-shrink:0;transition:var(--trans)}
.sb-close-btn:hover{background:rgba(255,255,255,.2);color:#fff}
.sb-role-chip{margin:8px 10px;background:rgba(255,255,255,.08);border-radius:7px;padding:5px 10px;display:flex;align-items:center;gap:6px;flex-shrink:0}
.sb-role-dot{width:6px;height:6px;border-radius:50%;background:var(--g400);animation:pulse 2s infinite;flex-shrink:0}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.3}}
.sb-role-txt{color:rgba(255,255,255,.75);font-size:11px;font-weight:600;white-space:nowrap}
.sb-sec{padding:12px 14px 3px;font-size:9px;font-weight:700;color:rgba(255,255,255,.28);text-transform:uppercase;letter-spacing:1.5px;white-space:nowrap}
.sb-item{display:flex;align-items:center;gap:8px;padding:8px 12px;margin:1px 6px;border-radius:8px;font-size:12.5px;color:rgba(255,255,255,.65);text-decoration:none;transition:var(--trans);white-space:nowrap;position:relative;overflow:hidden}
.sb-item:hover{background:rgba(255,255,255,.1);color:#fff}
.sb-item.active{background:rgba(255,255,255,.16);color:#fff;font-weight:600}
.sb-item.active::before{content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);width:3px;height:60%;background:var(--o500);border-radius:0 2px 2px 0}
.sb-ico{font-size:15px;width:18px;text-align:center;flex-shrink:0}
.sb-badge{margin-left:auto;background:var(--o500);color:#fff;font-size:9px;padding:1px 6px;border-radius:8px;font-weight:700;flex-shrink:0}
.sb-badge.gr{background:var(--g500)}
.sb-bottom{margin-top:auto;padding:10px;border-top:1px solid rgba(255,255,255,.08);flex-shrink:0}
.sb-user-card{display:flex;align-items:center;gap:8px;background:rgba(255,255,255,.07);border-radius:9px;padding:9px 10px;margin-bottom:7px}
.sb-av{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:11px;flex-shrink:0}
.sb-un{color:#fff;font-size:12px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.sb-ur{color:rgba(255,255,255,.4);font-size:10px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.sb-logout-btn{width:100%;display:flex;align-items:center;gap:7px;padding:8px 10px;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);border-radius:8px;color:rgba(255,160,160,.85);font-size:12px;font-weight:600;cursor:pointer;font-family:inherit;transition:var(--trans)}
.sb-logout-btn:hover{background:rgba(239,68,68,.22);border-color:rgba(239,68,68,.45);color:#fff}

/* TOPBAR */
.topbar{height:var(--topbar);background:#fff;border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 16px 0 0;position:fixed;top:0;left:var(--sw);right:0;z-index:200;box-shadow:0 1px 3px rgba(0,0,0,.04);transition:var(--trans)}
.tb-left{display:flex;align-items:center;gap:10px;flex:1;min-width:0;padding-left:12px}
.tb-menu-btn{width:34px;height:34px;border-radius:8px;border:1px solid var(--border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:17px;color:var(--t2);transition:var(--trans);flex-shrink:0}
.tb-menu-btn:hover{background:var(--bg)}
.tb-title{font-size:14.5px;font-weight:700;color:var(--t1);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;flex:1;min-width:0}
.tb-search{display:flex;align-items:center;gap:6px;background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:0 10px;height:33px;width:200px;flex-shrink:0}
.tb-search input{background:none;border:none;outline:none;font-size:12px;color:var(--t1);width:100%;font-family:inherit}
.tb-right{display:flex;align-items:center;gap:6px;flex-shrink:0}
.icon-btn{width:33px;height:33px;border-radius:8px;border:1px solid var(--border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px;position:relative;transition:var(--trans);text-decoration:none;color:var(--t1)}
.icon-btn:hover{background:var(--bg)}
.notif-dot{position:absolute;top:5px;right:5px;width:7px;height:7px;background:var(--o500);border-radius:50%;border:1.5px solid #fff}

/* USER DROPDOWN */
.user-menu-wrap{position:relative}
.user-chip{display:flex;align-items:center;gap:7px;padding:3px 9px 3px 3px;border-radius:20px;border:1px solid var(--border);background:#fff;cursor:pointer;transition:var(--trans)}
.user-chip:hover{background:var(--bg)}
.uc-av{width:27px;height:27px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:10px;flex-shrink:0}
.uc-name{font-size:11.5px;font-weight:600;color:var(--t1);white-space:nowrap;max-width:80px;overflow:hidden;text-overflow:ellipsis}
.uc-role{font-size:9.5px;color:var(--tm)}
.dropdown-menu{position:absolute;top:calc(100% + 6px);right:0;background:#fff;border-radius:12px;border:1px solid var(--border);box-shadow:0 8px 24px rgba(0,0,0,.1);width:210px;overflow:hidden;z-index:500;display:none;animation:dropIn .15s ease}
.dropdown-menu.show{display:block}
@keyframes dropIn{from{transform:translateY(-8px);opacity:0}to{transform:translateY(0);opacity:1}}
.dd-header{padding:11px 13px;border-bottom:1px solid var(--border);background:var(--g50)}
.dd-name{font-size:12.5px;font-weight:700;color:var(--t1)}
.dd-email{font-size:10.5px;color:var(--tm);margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.dd-item{display:flex;align-items:center;gap:8px;padding:9px 13px;font-size:12.5px;color:var(--t1);text-decoration:none;cursor:pointer;transition:background .12s;border:none;background:none;width:100%;font-family:inherit;text-align:left}
.dd-item:hover{background:var(--bg)}
.dd-item.danger{color:var(--r700)}.dd-item.danger:hover{background:var(--r50)}
.dd-sep{height:1px;background:var(--border);margin:2px 0}
.role-switch{padding:8px 13px;border-bottom:1px solid var(--border)}
.role-switch-label{font-size:10px;color:var(--tm);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px}
.role-switch-btns{display:flex;gap:4px}
.role-btn{flex:1;padding:5px 8px;border-radius:6px;border:1px solid var(--border);background:#fff;font-size:10.5px;font-weight:600;cursor:pointer;font-family:inherit;transition:all .15s;text-align:center}
.role-btn.act{background:var(--g700);color:#fff;border-color:var(--g700)}
.role-btn:hover:not(.act){background:var(--bg)}

/* MAIN */
.main-wrap{margin-left:var(--sw);margin-top:var(--topbar);min-height:calc(100vh - var(--topbar));transition:var(--trans)}
.content-area{padding:20px;max-width:1440px;margin:0 auto}
.sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:299}
.sidebar-overlay.show{display:block}

/* ALERTS */
.alert{padding:10px 14px;border-radius:8px;font-size:12.5px;margin-bottom:12px;display:flex;align-items:center;gap:8px;animation:slideIn .3s ease}
@keyframes slideIn{from{transform:translateY(-6px);opacity:0}to{transform:translateY(0);opacity:1}}
.alert-s{background:var(--g50);color:var(--g700);border:1px solid var(--g100)}
.alert-e{background:var(--r50);color:var(--r700);border:1px solid #FFCDD2}
.alert-w{background:var(--y50);color:var(--y600);border:1px solid #FFE082}

/* BREADCRUMB */
.bc{display:flex;align-items:center;gap:5px;font-size:11.5px;color:var(--tm);margin-bottom:12px;flex-wrap:wrap}
.bc a{color:var(--g700);text-decoration:none;font-weight:500}.bc a:hover{text-decoration:underline}
.bc-sep{color:var(--border);font-size:13px}

/* PAGE HEADER */
.ph{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;gap:10px;flex-wrap:wrap}
.ph h1{font-size:18px;font-weight:800;color:var(--t1)}
.ph p{color:var(--t2);font-size:12.5px;margin-top:2px}
.ph-right{display:flex;gap:7px;flex-shrink:0;flex-wrap:wrap;align-items:center}

/* STAT CARDS */
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:16px}
.sc{background:#fff;border-radius:12px;padding:16px 18px;border:1px solid var(--border);border-top:3px solid var(--ac);position:relative;overflow:hidden;transition:box-shadow .15s}
.sc:hover{box-shadow:0 4px 14px rgba(0,0,0,.07)}
.sc-lbl{font-size:10px;font-weight:600;color:var(--t2);text-transform:uppercase;letter-spacing:.5px}
.sc-val{font-size:23px;font-weight:800;color:var(--t1);margin:4px 0 2px;line-height:1}
.sc-sub{font-size:11px;color:var(--t2)}
.sc-up{color:var(--g600)}.sc-dn{color:var(--r700)}
.sc-ico{position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:28px;opacity:.1}

/* CARD */
.card{background:#fff;border-radius:12px;border:1px solid var(--border);margin-bottom:16px;overflow:hidden}
.card-hd{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid var(--border)}
.card-title{font-size:13px;font-weight:700;color:var(--t1);display:flex;align-items:center;gap:6px}
.card-body{padding:16px}
.card-ft{padding:10px 16px;border-top:1px solid var(--border);background:#FAFBFC;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px}

/* GRID */
.g2{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px}
.g3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:12px}
.g4{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:12px}
.col2{grid-column:span 2}.col3{grid-column:span 3}

/* TABLE */
.tbl-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch}
.tbl{width:100%;border-collapse:collapse;font-size:12px;min-width:500px}
.tbl thead th{padding:8px 13px;text-align:left;color:var(--t2);font-weight:600;border-bottom:2px solid var(--border);font-size:10.5px;text-transform:uppercase;letter-spacing:.4px;white-space:nowrap;background:#FAFBFC}
.tbl tbody td{padding:11px 13px;border-bottom:1px solid var(--border);color:var(--t1);vertical-align:middle}
.tbl tbody tr:last-child td{border-bottom:none}
.tbl tbody tr:hover{background:#FAFBFD}

/* BADGES */
.badge{display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:20px;font-size:10.5px;font-weight:600;white-space:nowrap}
.bg-s{background:var(--g50);color:var(--g700)}.bg-w{background:var(--o50);color:var(--o700)}
.bg-d{background:var(--r50);color:var(--r700)}.bg-i{background:var(--b50);color:var(--b700)}
.bg-p{background:var(--p50);color:var(--p700)}.bg-y{background:var(--y50);color:var(--y600)}

/* BUTTONS */
.btn{display:inline-flex;align-items:center;gap:5px;padding:7px 13px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;border:none;font-family:inherit;transition:var(--trans);text-decoration:none;white-space:nowrap;line-height:1.3}
.btn-g{background:var(--g700);color:#fff}.btn-g:hover{background:var(--g800);color:#fff}
.btn-o{background:var(--o500);color:#fff}.btn-o:hover{background:var(--o700);color:#fff}
.btn-out{background:#fff;color:var(--t1);border:1px solid var(--border)}.btn-out:hover{background:var(--bg)}
.btn-ghost{background:transparent;color:var(--t2);border:1px solid var(--border)}.btn-ghost:hover{background:var(--bg)}
.btn-red{background:var(--r50);color:var(--r700);border:1px solid #FFCDD2}.btn-red:hover{background:#FFCDD2}
.btn-sm{padding:5px 10px;font-size:11px}.btn-xs{padding:3px 8px;font-size:10.5px}

/* FORM */
.fg{margin-bottom:12px}
.fl{display:block;font-size:11.5px;font-weight:600;color:var(--t2);margin-bottom:4px}
.req{color:var(--r700);margin-left:2px}
.fc{width:100%;border:1.5px solid var(--border);border-radius:8px;padding:8px 11px;font-size:12.5px;color:var(--t1);font-family:inherit;outline:none;background:#fff;transition:border-color .15s}
.fc:focus{border-color:var(--g600);box-shadow:0 0 0 3px rgba(46,125,50,.07)}
.fhint{font-size:10.5px;color:var(--tm);margin-top:3px}
.fr{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.fr3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px}

/* FILTER BAR */
.fbar{display:flex;gap:8px;align-items:center;margin-bottom:12px;flex-wrap:wrap}
.si{display:flex;align-items:center;gap:6px;background:#fff;border:1px solid var(--border);border-radius:8px;padding:0 10px;height:33px;min-width:160px;flex:1;max-width:280px}
.si input{background:none;border:none;outline:none;font-size:12px;color:var(--t1);width:100%;font-family:inherit}
.sf{border:1px solid var(--border);border-radius:8px;padding:5px 9px;font-size:12px;color:var(--t1);background:#fff;font-family:inherit;outline:none;cursor:pointer;height:33px}

/* PAGINATION */
.pag{display:flex;align-items:center;justify-content:space-between;font-size:11.5px;color:var(--t2);flex-wrap:wrap;gap:8px}
.pg{display:flex;gap:3px}
.pb{min-width:28px;height:28px;border-radius:6px;border:1px solid var(--border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;font-family:inherit;transition:all .12s;padding:0 6px}
.pb.a{background:var(--g700);color:#fff;border-color:var(--g700)}
.pb:hover:not(.a){background:var(--bg)}

/* MODAL */
.modal-bg{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1000;align-items:center;justify-content:center;padding:14px}
.modal-bg.show{display:flex}
.modal{background:#fff;border-radius:14px;width:520px;max-width:100%;max-height:90vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.2);animation:mi .2s ease}
@keyframes mi{from{transform:translateY(-14px);opacity:0}to{transform:translateY(0);opacity:1}}
.modal-lg{width:660px}.modal-xl{width:840px}
.modal-hd{display:flex;align-items:center;justify-content:space-between;padding:14px 18px;border-bottom:1px solid var(--border);position:sticky;top:0;background:#fff;z-index:1}
.modal-t{font-size:14px;font-weight:700}
.modal-x{width:26px;height:26px;border-radius:6px;border:1px solid var(--border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:13px;color:var(--tm);transition:var(--trans)}
.modal-x:hover{background:var(--r50);color:var(--r700);border-color:#FFCDD2}
.modal-bd{padding:18px}
.modal-ft{padding:11px 18px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:7px;background:#FAFBFC;position:sticky;bottom:0}

/* MISC */
.progress{height:5px;background:var(--border);border-radius:3px;overflow:hidden}
.progress-fill{height:100%;border-radius:3px;transition:width .3s}
.av{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0}
.mono{font-family:monospace;font-size:10.5px;background:var(--bg);padding:2px 6px;border-radius:4px;white-space:nowrap}
.text-muted{color:var(--tm)}.text-sm{font-size:11.5px}.fw7{font-weight:700}
.divider{height:1px;background:var(--border);margin:12px 0}

/* RESPONSIVE */
@media(max-width:1200px){.stats{grid-template-columns:repeat(2,1fr)}.g4{grid-template-columns:repeat(2,1fr)}.tb-search{width:160px}}
@media(max-width:900px){.g2{grid-template-columns:1fr}.g3{grid-template-columns:1fr 1fr}.col2,.col3{grid-column:span 1}}
@media(max-width:768px){
  .sidebar{transform:translateX(-100%)}
  .sidebar.mobile-open{transform:translateX(0);box-shadow:4px 0 20px rgba(0,0,0,.3)}
  .topbar,.main-wrap{transition:none}
  .topbar{left:0!important}.main-wrap{margin-left:0!important}
  .stats{grid-template-columns:1fr 1fr}
  .g3{grid-template-columns:1fr}.fr,.fr3{grid-template-columns:1fr}
  .ph{flex-direction:column}.ph-right{width:100%}
  .content-area{padding:14px}
  .tb-search{display:none}
  .icon-btn:nth-child(-n+1){display:none}
}
@media(max-width:480px){.stats{grid-template-columns:1fr}.g4{grid-template-columns:1fr 1fr}}
</style>
@stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<nav class="sidebar {{ session('user_role')==='pengelola'?'pen':'' }}" id="mainSidebar">
  <div class="sb-head">
    <a href="{{ session('user_role')==='admin'?route('admin.dashboard'):route('pengelola.dashboard') }}" class="sb-logo">
      <div class="sb-logo-icon">C</div>
      <div><div class="sb-logo-name">CitiisGo</div><div class="sb-logo-sub">Jelajah · Pesan · Nikmati</div></div>
    </a>
    <button class="sb-close-btn" onclick="closeSidebar()" title="Tutup sidebar">✕</button>
  </div>
  <div class="sb-role-chip">
    <div class="sb-role-dot"></div>
    <div class="sb-role-txt">{{ session('user_role')==='admin'?'⚡ Administrator':'🏔️ Pengelola Wisata' }}</div>
  </div>
  @if(session('user_role')==='admin')
  <div style="flex:1;padding:4px 0">
    <div class="sb-sec">Menu Utama</div>
    <a href="{{ route('admin.dashboard') }}" class="sb-item {{ request()->routeIs('admin.dashboard')?'active':'' }}"><span class="sb-ico">🏠</span> Dashboard</a>
    <a href="{{ route('admin.users') }}" class="sb-item {{ request()->routeIs('admin.users*')?'active':'' }}"><span class="sb-ico">👥</span> Manajemen User</a>
    <a href="{{ route('admin.wisata') }}" class="sb-item {{ request()->routeIs('admin.wisata*')?'active':'' }}"><span class="sb-ico">🏞️</span> Data Wisata</a>
    <a href="{{ route('admin.kategori') }}" class="sb-item {{ request()->routeIs('admin.kategori*')?'active':'' }}"><span class="sb-ico">🏷️</span> Kategori Wisata</a>
    <div class="sb-sec">Transaksi</div>
    <a href="{{ route('admin.pembayaran') }}" class="sb-item {{ request()->routeIs('admin.pembayaran*')?'active':'' }}"><span class="sb-ico">💳</span> Pembayaran <span class="sb-badge">7</span></a>
    <a href="{{ route('admin.laporan') }}" class="sb-item {{ request()->routeIs('admin.laporan*')?'active':'' }}"><span class="sb-ico">📊</span> Laporan & Analitik</a>
    <div class="sb-sec">Sistem</div>
    <a href="#" class="sb-item"><span class="sb-ico">⚙️</span> Pengaturan</a>
  </div>
  @else
  <div style="flex:1;padding:4px 0">
    <div class="sb-sec">Menu Pengelola</div>
    <a href="{{ route('pengelola.dashboard') }}" class="sb-item {{ request()->routeIs('pengelola.dashboard')?'active':'' }}"><span class="sb-ico">📊</span> Dashboard</a>
    <a href="{{ route('pengelola.wisata') }}" class="sb-item {{ request()->routeIs('pengelola.wisata*')?'active':'' }}"><span class="sb-ico">🏔️</span> Kelola Wisata</a>
    <div class="sb-sec">Layanan</div>
    <a href="{{ route('pengelola.camping') }}" class="sb-item {{ request()->routeIs('pengelola.camping*')?'active':'' }}"><span class="sb-ico">⛺</span> Paket Camping</a>
    <a href="{{ route('pengelola.penginapan') }}" class="sb-item {{ request()->routeIs('pengelola.penginapan*')?'active':'' }}"><span class="sb-ico">🏨</span> Penginapan & Kamar</a>
    <a href="{{ route('pengelola.peralatan') }}" class="sb-item {{ request()->routeIs('pengelola.peralatan*')?'active':'' }}"><span class="sb-ico">🎒</span> Sewa Peralatan</a>
    <div class="sb-sec">Pesanan</div>
    <a href="{{ route('pengelola.reservasi') }}" class="sb-item {{ request()->routeIs('pengelola.reservasi*')?'active':'' }}"><span class="sb-ico">🎫</span> Reservasi & Booking <span class="sb-badge gr">12</span></a>
    <div class="sb-sec">Analitik</div>
    <a href="{{ route('pengelola.laporan') }}" class="sb-item {{ request()->routeIs('pengelola.laporan*')?'active':'' }}"><span class="sb-ico">📈</span> Laporan Kunjungan</a>
    <a href="#" class="sb-item"><span class="sb-ico">⭐</span> Ulasan Wisata</a>
  </div>
  @endif
  <div class="sb-bottom">
    <div class="sb-user-card">
      <div class="sb-av" style="background:{{ session('user_role')==='admin'?'var(--o500)':'var(--g600)' }}">{{ strtoupper(substr(session('user.nama','U'),0,2)) }}</div>
      <div style="min-width:0"><div class="sb-un">{{ session('user.nama','User') }}</div><div class="sb-ur">{{ session('user.email','') }}</div></div>
    </div>
    <form action="{{ route('logout') }}" method="POST" id="logoutFormSb">
      @csrf
      <button type="button" onclick="showLogoutModal()" class="sb-logout-btn">
        <span style="font-size:14px">🚪</span> Keluar dari Panel
      </button>
    </form>
  </div>
</nav>

<header class="topbar" id="mainTopbar">
  <div class="tb-left">
    <button class="tb-menu-btn" onclick="toggleSidebar()" title="Toggle sidebar">☰</button>
    <div class="tb-title">@yield('topbar-title','Dashboard')</div>
    <div class="tb-search"><span style="font-size:13px;color:var(--tm)">🔍</span><input placeholder="Cari..."></div>
  </div>
  <div class="tb-right">
    <a href="#" class="icon-btn">🔔<div class="notif-dot"></div></a>
    <a href="#" class="icon-btn">❓</a>
    <div class="user-menu-wrap">
      <div class="user-chip" onclick="toggleDropdown()">
        <div class="uc-av" style="background:{{ session('user_role')==='admin'?'var(--o500)':'var(--g600)' }}">{{ strtoupper(substr(session('user.nama','U'),0,2)) }}</div>
        <div><div class="uc-name">{{ Str::limit(session('user.nama','User'),14) }}</div><div class="uc-role">{{ ucfirst(session('user_role','')) }}</div></div>
        <span style="font-size:10px;color:var(--tm);margin-left:2px">▾</span>
      </div>
      <div class="dropdown-menu" id="userDropdown">
        <div class="dd-header">
          <div class="dd-name">{{ session('user.nama','User') }}</div>
          <div class="dd-email">{{ session('user.email','') }}</div>
          <span class="badge {{ session('user_role')==='admin'?'bg-w':'bg-s' }}" style="margin-top:4px;font-size:9px">{{ ucfirst(session('user_role','')) }}</span>
        </div>
        <div class="role-switch">
          <div class="role-switch-label">Ganti Panel / Logout</div>
          <div class="role-switch-btns">
            @if(session('user_role')==='admin')
              <div class="role-btn act">⚡ Admin</div>
              <form action="{{ route('logout') }}" method="POST" style="flex:1;margin:0">@csrf<button type="submit" class="role-btn" style="width:100%;cursor:pointer">🔄 Ganti</button></form>
            @else
              <form action="{{ route('logout') }}" method="POST" style="flex:1;margin:0">@csrf<button type="submit" class="role-btn" style="width:100%;cursor:pointer">🔄 Ganti Login</button></form>
            @endif
          </div>
        </div>
        <a href="#" class="dd-item">👤 Profil Saya</a>
        <a href="#" class="dd-item">⚙️ Pengaturan Akun</a>
        <div class="dd-sep"></div>
        <button type="button" onclick="showLogoutModal()" class="dd-item danger">🚪 Keluar dari Panel</button>
      </div>
    </div>
  </div>
</header>

<div class="main-wrap" id="mainWrap">
  <div class="content-area">
    @if(session('success'))<div class="alert alert-s">✅ {{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-e">❌ {{ session('error') }}</div>@endif
    @if($errors->any())<div class="alert alert-e">❌ {{ $errors->first() }}</div>@endif
    @yield('content')
  </div>
</div>

<div class="modal-bg" id="logoutModal">
  <div class="modal" style="width:360px">
    <div style="padding:28px 22px;text-align:center">
      <div style="width:58px;height:58px;border-radius:50%;background:var(--r50);display:flex;align-items:center;justify-content:center;font-size:26px;margin:0 auto 12px">🚪</div>
      <div style="font-size:15px;font-weight:800;color:var(--t1);margin-bottom:7px">Keluar dari Panel?</div>
      <div style="font-size:12.5px;color:var(--t2);line-height:1.6">Anda akan keluar dan diarahkan ke halaman login.<br>Sesi aktif akan diakhiri.</div>
      <div style="display:flex;gap:10px;margin-top:20px;justify-content:center">
        <button class="btn btn-out" onclick="closeModal('logoutModal')" style="padding:9px 20px">Batal</button>
        <form action="{{ route('logout') }}" method="POST" style="margin:0">
          @csrf
          <button type="submit" style="padding:9px 20px;background:var(--r700);color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;font-family:inherit">🚪 Ya, Keluar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
var sidebarOpen=true,isMobile=()=>window.innerWidth<=768;
function toggleSidebar(){
  var sb=document.getElementById('mainSidebar'),mw=document.getElementById('mainWrap'),tb=document.getElementById('mainTopbar');
  if(isMobile()){sb.classList.toggle('mobile-open');document.getElementById('sidebarOverlay').classList.toggle('show');return}
  sidebarOpen=!sidebarOpen;
  if(sidebarOpen){sb.classList.remove('collapsed');tb.style.left='var(--sw)';mw.style.marginLeft='var(--sw)'}
  else{sb.classList.add('collapsed');tb.style.left='0';mw.style.marginLeft='0'}
  localStorage.setItem('sb',sidebarOpen);
}
function closeSidebar(){
  if(isMobile()){document.getElementById('mainSidebar').classList.remove('mobile-open');document.getElementById('sidebarOverlay').classList.remove('show');}
}
(function(){var s=localStorage.getItem('sb');if(s==='false'&&!isMobile()){var sb=document.getElementById('mainSidebar'),mw=document.getElementById('mainWrap'),tb=document.getElementById('mainTopbar');sb.classList.add('collapsed');tb.style.left='0';mw.style.marginLeft='0';sidebarOpen=false;}})();
window.addEventListener('resize',function(){if(!isMobile()){document.getElementById('mainSidebar').classList.remove('mobile-open');document.getElementById('sidebarOverlay').classList.remove('show');}});
function toggleDropdown(){document.getElementById('userDropdown').classList.toggle('show')}
document.addEventListener('click',function(e){var w=document.querySelector('.user-menu-wrap');if(w&&!w.contains(e.target))document.getElementById('userDropdown').classList.remove('show')});
function openModal(id){document.getElementById(id).classList.add('show')}
function closeModal(id){document.getElementById(id).classList.remove('show')}
function showLogoutModal(){document.getElementById('userDropdown').classList.remove('show');openModal('logoutModal')}
document.querySelectorAll('.modal-bg').forEach(function(m){m.addEventListener('click',function(e){if(e.target===m)m.classList.remove('show')})});
document.querySelectorAll('.alert').forEach(function(el){setTimeout(function(){el.style.transition='opacity .5s';el.style.opacity='0';setTimeout(function(){el.remove()},500)},4500)});
document.addEventListener('keydown',function(e){if(e.key==='Escape'){document.querySelectorAll('.modal-bg.show').forEach(function(m){m.classList.remove('show')});document.getElementById('userDropdown').classList.remove('show');closeSidebar()}});
</script>
@stack('scripts')
</body>
</html>