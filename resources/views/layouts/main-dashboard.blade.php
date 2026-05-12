<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Pengaduan Mahasiswa</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            padding: 35px 40px;
        }

        .welcome-card {
            background-color: #b0c4de;
            border-radius: 15px;
            padding: 25px 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .welcome-text h3 {
            font-size: 18px;
            font-weight: 700;
            color: #1a2340;
        }

        .welcome-text p {
            font-size: 14px;
            color: #3a4a6b;
            margin-top: 5px;
        }

        .welcome-icon {
            font-size: 50px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            border-radius: 15px;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            cursor: pointer;
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

        .stat-info h4 { font-size: 14px; margin-bottom: 10px; font-weight: 500; }
        .stat-info .stat-number { font-size: 30px; font-weight: 700; }
        .stat-icon { font-size: 45px; opacity: 0.8; }

        .table-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: #0d2d6e;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px; border-bottom: 2px solid #f1f5f9; color: #64748b; font-size: 13px; }
        td { padding: 15px 12px; border-bottom: 1px solid #f1f5f9; font-size: 13.5px; color: #1e293b; }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 8px;
            align-items: center;
        }

        .pagination li a, .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border-radius: 10px;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            color: #64748b;
            text-decoration: none;
            font-size: 13px;
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
            .content { padding: 25px; }
            .topbar-title { font-size: 13px; }
        }

        @media (max-width: 768px) {
            body { position: relative; }
            .sidebar { 
                position: fixed;
                left: -200px;
                z-index: 2000;
                width: 200px !important;
                height: 100vh;
                transition: left 0.3s ease;
            }
            .sidebar.active {
                left: 0;
            }
            .sidebar.collapsed {
                left: -200px;
            }
            .main-wrapper {
                width: 100%;
            }
            .topbar {
                justify-content: space-between;
                padding: 0 15px;
            }
            .content { padding: 20px 15px; }

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
        }

        @media (max-width: 480px) {
            .topbar-title { display: none; }
            .topbar::after {
                content: 'SPM BERBASIS WEB';
                font-size: 11px;
                font-weight: 800;
                letter-spacing: 0.5px;
                color: #fff;
            }
            .welcome-card {
                flex-direction: column;
                text-align: center;
                gap: 15px;
                padding: 20px;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .content {
                padding: 15px 10px;
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
