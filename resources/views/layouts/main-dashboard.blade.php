<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Pengaduan Mahasiswa</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 200px;
            background-color: #0d2d6e;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
        }

        .sidebar-logo {
            padding: 25px 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-pill {
            background-color: #ffffff;
            padding: 8px 15px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .logo-pill img {
            width: 130px;
            height: auto;
        }

        .sidebar-nav {
            flex: 1;
            padding: 10px 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            color: #a8bce0;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .nav-item:hover,
        .nav-item.active {
            background-color: rgba(255,255,255,0.08);
            color: #fff;
            border-left: 4px solid #4a9eff;
        }

        .nav-item .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar-footer {
            padding: 30px 20px;
        }

        .logout-btn {
            display: block;
            width: 100%;
            background-color: transparent;
            color: #fff;
            border: 1.5px solid #fff;
            border-radius: 20px;
            padding: 8px 0;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background-color: #fff;
            color: #0d2d6e;
        }

        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            margin-left: 200px;
        }

        .topbar {
            background-color: #0d2d6e;
            display: flex;
            align-items: center;
            padding: 0 24px;
            height: 52px;
            gap: 15px;
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-hamburger {
            width: 24px;
            height: 18px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
        }

        .topbar-hamburger span {
            display: block;
            height: 2px;
            background: #fff;
            border-radius: 2px;
        }

        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .content {
            flex: 1;
            padding: clamp(15px, 5vw, 40px);
        }

        .welcome-card {
            background-color: #b0c4de;
            border-radius: clamp(10px, 2vw, 15px);
            padding: clamp(15px, 3vw, 35px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: clamp(20px, 5vw, 40px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            flex-wrap: wrap;
            gap: 15px;
        }

        .welcome-text h3 {
            font-size: clamp(16px, 4vw, 18px);
            font-weight: 700;
            color: #1a2340;
        }

        .welcome-text p {
            font-size: clamp(12px, 2vw, 14px);
            color: #3a4a6b;
            margin-top: 5px;
        }

        .welcome-icon {
            font-size: clamp(35px, 10vw, 50px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(180px, 100%), 1fr));
            gap: clamp(12px, 3vw, 25px);
            margin-bottom: clamp(20px, 5vw, 40px);
        }

        .stat-card {
            border-radius: clamp(10px, 2vw, 15px);
            padding: clamp(16px, 2vw, 22px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            cursor: pointer;
            gap: 16px;
            min-height: 118px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card.blue { background: #4a9eff; }
        .stat-card.purple { background: #7c3aed; }
        .stat-card.light-blue { background: #60a5fa; }
        .stat-card.yellow { background: #f59e0b; }
        .stat-card.orange { background: #f97316; }
        .stat-card.green { background: #22c55e; }
        .stat-card.gray { background: #94a3b8; }

        .stat-info { flex: 1; }
        .stat-info h4 { font-size: clamp(11px, 2vw, 14px); margin-bottom: 8px; font-weight: 500; text-align: left; }
        .stat-info .stat-number { font-size: clamp(24px, 4vw, 32px); font-weight: 700; text-align: left; }
        .stat-icon { font-size: clamp(32px, 5vw, 44px); opacity: 0.8; flex-shrink: 0; }

        .table-card {
            background: white;
            border-radius: clamp(10px, 2vw, 15px);
            padding: clamp(15px, 3vw, 25px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: clamp(15px, 3vw, 25px);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .card-title {
            font-size: clamp(14px, 3vw, 16px);
            font-weight: 700;
            color: #0d2d6e;
            margin-bottom: clamp(12px, 3vw, 20px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        table { width: 100%; border-collapse: collapse; min-width: 100%; }
        th { text-align: left; padding: clamp(8px, 2vw, 12px); border-bottom: 2px solid #f1f5f9; color: #64748b; font-size: clamp(10px, 1.8vw, 12px); }
        td { padding: clamp(8px, 2vw, 12px); border-bottom: 1px solid #f1f5f9; font-size: clamp(11px, 2vw, 13px); color: #1e293b; }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 15px;
            border-radius: 12px;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            gap: clamp(4px, 1vw, 8px);
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
        }

        .pagination li a, .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: clamp(28px, 6vw, 36px);
            height: clamp(28px, 6vw, 36px);
            padding: 0 clamp(4px, 1vw, 10px);
            border-radius: clamp(6px, 1vw, 10px);
            background: #fff;
            border: 1.5px solid #e2e8f0;
            color: #64748b;
            text-decoration: none;
            font-size: clamp(11px, 2vw, 13px);
            font-weight: 600;
            transition: all 0.3s;
        }

        .pagination li.active span {
            background: #0d428e;
            color: #fff;
            border-color: #0d428e;
        }

        .pagination li a:hover {
            border-color: #0d428e;
            color: #0d428e;
            background: #f0f7ff;
        }

        .pagination li.disabled span {
            background: #f8fafc;
            color: #cbd5e1;
            cursor: not-allowed;
        }

        nav[role="navigation"] > div:first-child {
            display: none !important;
        }

        .sidebar {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar.collapsed .sidebar-logo, 
        .sidebar.collapsed .nav-item span:not(.nav-icon), 
        .sidebar.collapsed .sidebar-footer {
            display: none;
        }

        .main-wrapper {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @media (max-width: 992px) {
            .content { padding: clamp(15px, 4vw, 25px); }
            .topbar-title { font-size: clamp(12px, 2vw, 13px); }
            .stat-card { flex-direction: row; }
            .stat-info h4 { text-align: left; }
            .stat-number { text-align: left; }
        }

        @media (max-width: 768px) {
            body { position: relative; }
            .sidebar { 
                position: fixed;
                left: -240px;
                z-index: 2000;
                width: 240px !important;
                height: 100vh;
                transition: left 0.3s ease;
            }
            .sidebar.active {
                left: 0;
            }
            .sidebar.collapsed {
                left: -240px;
            }
            .main-wrapper {
                width: 100%;
                margin-left: 0 !important;
            }
            .topbar {
                justify-content: space-between;
                padding: 0 clamp(10px, 2vw, 15px);
                height: clamp(44px, 10vh, 52px);
            }
            .content { padding: clamp(12px, 3vw, 15px); }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1500;
                backdrop-filter: blur(2px);
            }
            .sidebar-overlay.active {
                display: block;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: clamp(10px, 2vw, 12px);
            }

            .stat-card {
                padding: clamp(10px, 2vw, 15px);
                flex-direction: column;
            }

            .stat-info h4 { font-size: clamp(10px, 1.8vw, 11px); }
            .stat-number { font-size: clamp(16px, 4vw, 18px); }
            .stat-icon { font-size: clamp(24px, 6vw, 30px); }
            
            .table-card {
                padding: clamp(12px, 2vw, 15px);
            }
            
            table { font-size: clamp(10px, 1.8vw, 12px); }
            th, td { padding: clamp(6px, 1.5vw, 10px); }
        }

        @media (max-width: 640px) {
            .topbar-title { display: none; }
            .topbar::after {
                content: 'SPM WEB';
                font-size: clamp(10px, 2vw, 11px);
                font-weight: 800;
                letter-spacing: 0.5px;
                color: #fff;
            }
            .welcome-card {
                flex-direction: column;
                text-align: center;
                gap: clamp(10px, 2vw, 15px);
                padding: clamp(12px, 2vw, 20px);
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .content {
                padding: clamp(10px, 2vw, 12px);
            }
            
            .stat-card {
                flex-direction: row;
                padding: clamp(10px, 2vw, 15px);
            }
            
            .stat-info { flex: 1; text-align: left; }
            .stat-info h4 { text-align: left; }
            .stat-number { text-align: left; }
            
            .card-title {
                font-size: clamp(13px, 2.5vw, 14px);
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 90vw !important;
                max-width: 240px;
            }
            
            .sidebar-logo img {
                width: clamp(100px, 20vw, 130px);
            }
            
            .content {
                padding: clamp(8px, 2vw, 10px);
            }
            
            .welcome-icon {
                font-size: clamp(30px, 8vw, 40px);
            }
            
            table { font-size: 10px; }
            th, td { padding: 4px; }
            
            .stat-card {
                flex-direction: column;
                gap: 5px;
            }
            
            .stat-info h4 { 
                font-size: 9px;
                text-align: center;
            }
            .stat-number { 
                font-size: clamp(14px, 3vw, 16px);
                text-align: center;
            }
            .stat-icon { 
                font-size: clamp(20px, 5vw, 24px);
            }
        }
            .table-card {
                padding: 15px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="logo-pill">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-table-columns"></i></span>
                <span>Dashboard</span>
            </a>

            @if(Auth::user()->role === 'mahasiswa')
                <a href="{{ route('pengaduan.index') }}" class="nav-item {{ request()->routeIs('pengaduan.*') && !request()->routeIs('riwayat.tanggapan') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-paper-plane"></i></span>
                    <span>Pengaduan</span>
                </a>
                <a href="{{ route('riwayat.tanggapan') }}" class="nav-item {{ request()->routeIs('riwayat.tanggapan') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                    <span>Riwayat</span>
                </a>
            @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('pengaduan.index') }}" class="nav-item {{ request()->routeIs('pengaduan.*') && !request()->routeIs('riwayat.tanggapan') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-inbox"></i></span>
                    <span>Pengaduan Masuk</span>
                </a>
                <a href="{{ route('riwayat.tanggapan') }}" class="nav-item {{ request()->routeIs('riwayat.tanggapan') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-reply-all"></i></span>
                    <span>Riwayat Tanggapan</span>
                </a>
            @elseif(Auth::user()->role === 'admin_spmi')
                <a href="{{ route('pengaduan.index') }}" class="nav-item {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-list-check"></i></span>
                    <span>Kelola Pengaduan</span>
                </a>
                <a href="{{ route('rekapitulasi') }}" class="nav-item {{ request()->routeIs('rekapitulasi') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-file-contract"></i></span>
                    <span>Rekapitulasi</span>
                </a>
                <a href="{{ route('user.index') }}" class="nav-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-users-gear"></i></span>
                    <span>Kelola User</span>
                </a>
                <a href="{{ route('unit.index') }}" class="nav-item {{ request()->routeIs('unit.index') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-building-circle-check"></i></span>
                    <span>Kelola Unit</span>
                </a>
            @endif
        </nav>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </aside>

    <div class="main-wrapper">
        <div class="topbar">
            <div class="topbar-hamburger" id="sidebarToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <span class="topbar-title">Sistem Pengaduan Mahasiswa Berbasis Web</span>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggle = document.getElementById('sidebarToggle');

            if (toggle && sidebar && overlay) {
                toggle.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.toggle('active');
                        overlay.classList.toggle('active');
                    } else {
                        sidebar.classList.toggle('collapsed');
                    }
                });

                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
