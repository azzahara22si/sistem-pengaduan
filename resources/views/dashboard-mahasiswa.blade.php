<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengaduan Mahasiswa - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 175px;
            background-color: #0d2d6e;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            min-height: 100vh;
        }

        .sidebar-logo {
            background-color: #1a47a0;
            padding: 14px 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo img {
            width: 130px;
            height: auto;
            object-fit: contain;
        }

        .sidebar-nav {
            flex: 1;
            padding: 18px 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 18px;
            color: #a8bce0;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .nav-item:hover,
        .nav-item.active {
            background-color: rgba(255,255,255,0.08);
            color: #fff;
            border-left: 3px solid #4a9eff;
        }

        .nav-item .nav-icon {
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .nav-item .nav-icon svg {
            width: 19px;
            height: 19px;
            fill: currentColor;
        }

        .sidebar-footer {
            padding: 18px 16px;
        }

        .logout-btn {
            display: block;
            width: 100%;
            background-color: transparent;
            color: #fff;
            border: 1.5px solid #fff;
            border-radius: 20px;
            padding: 7px 0;
            font-size: 12.5px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            text-align: center;
            transition: background 0.2s;
        }

        .logout-btn:hover {
            background-color: rgba(255,255,255,0.1);
        }

        /* ===== MAIN AREA ===== */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background-color: #1a47a0;
            display: flex;
            align-items: center;
            padding: 0 24px;
            height: 52px;
            gap: 14px;
        }

        .topbar-hamburger {
            width: 22px;
            height: 22px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 4px;
            cursor: pointer;
        }

        .topbar-hamburger span {
            display: block;
            height: 2px;
            background: #fff;
            border-radius: 2px;
        }

        .topbar-title {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        /* ===== CONTENT ===== */
        .content {
            flex: 1;
            padding: 28px 32px;
            background-color: #fff;
        }

        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(90deg, #b8cce8 0%, #d5e4f5 100%);
            border-radius: 10px;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
            max-width: 460px;
        }

        .welcome-text h3 {
            font-size: 14px;
            font-weight: 700;
            color: #1a2340;
        }

        .welcome-text p {
            font-size: 12.5px;
            color: #3a4a6b;
            margin-top: 2px;
        }

        .welcome-emoji {
            width: 54px;
            height: 54px;
            background: #f5c842;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            position: relative;
            flex-shrink: 0;
        }

        .welcome-emoji .hello-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #fff;
            color: #1a2340;
            font-size: 7px;
            font-weight: 700;
            padding: 2px 4px;
            border-radius: 3px;
            border: 1px solid #ddd;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            max-width: 460px;
        }

        .stat-card {
            border-radius: 10px;
            padding: 20px 20px 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 100px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
        }

        .stat-card:hover {
            opacity: 0.92;
            transform: translateY(-2px);
        }

        .stat-card.blue {
            background-color: #4a7fd4;
        }

        .stat-card.orange {
            background-color: #f5a63d;
        }

        .stat-card.green {
            background-color: #4caf50;
        }

        .stat-card.gray {
            background-color: #9eaabf;
        }

        .stat-info h4 {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 6px;
        }

        .stat-info .stat-number {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
        }

        .stat-icon {
            width: 62px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        /* Buat Pengaduan card (no icon, centered) */
        .stat-card.new-report {
            justify-content: center;
            gap: 10px;
            flex-direction: row;
            align-items: center;
        }

        .stat-card.new-report .plus-icon {
            width: 28px;
            height: 28px;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-card.new-report .plus-icon svg {
            width: 16px;
            height: 16px;
            fill: #fff;
        }

        .stat-card.new-report span {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="">
    </div>

    <nav class="sidebar-nav">
        <a href="#" class="nav-item active">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                </svg>
            </span>
            Dashboard
        </a>
        <a href="#" class="nav-item">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
                </svg>
            </span>
            Pengaduan
        </a>
        <a href="#" class="nav-item">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/>
                </svg>
            </span>
            Riwayat
        </a>
    </nav>

    <div class="sidebar-footer">
        <button class="logout-btn">Logout</button>
    </div>
</aside>

<!-- MAIN -->
<div class="main-wrapper">
    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <span class="topbar-title">Sistem Pengaduan Mahasiswa Berbasis Web</span>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <!-- Welcome Card -->
        <div class="welcome-card">
            <div class="welcome-text">
                <h3>Selamat Datang!</h3>
                <p>Halo, Udin</p>
            </div>
            <div class="welcome-emoji">
                <span>😊</span>
                <span class="hello-badge">HELLO!</span>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">

            <!-- Pengaduan Baru -->
            <div class="stat-card blue">
                <div class="stat-info">
                    <h4>Pengaduan baru</h4>
                    <div class="stat-number">3</div>
                </div>
                <div class="stat-icon">
                    <!-- Envelope with sad face icon -->
                    <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="6" y="16" width="52" height="36" rx="4" fill="#fff" opacity="0.25"/>
                        <rect x="6" y="16" width="52" height="36" rx="4" stroke="#fff" stroke-width="2.5"/>
                        <path d="M6 20l26 18L58 20" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="32" cy="30" r="10" fill="#e74c3c"/>
                        <circle cx="29" cy="28" r="1.5" fill="#fff"/>
                        <circle cx="35" cy="28" r="1.5" fill="#fff"/>
                        <path d="M29 34c0 0 1.5-2 3-2s3 2 3 2" stroke="#fff" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>

            <!-- Sedang Diproses -->
            <div class="stat-card orange">
                <div class="stat-info">
                    <h4>Sedang Diproses</h4>
                    <div class="stat-number">1</div>
                </div>
                <div class="stat-icon">
                    <!-- Warning/chat icon -->
                    <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="8" y="10" width="36" height="28" rx="4" fill="#fff" opacity="0.25"/>
                        <rect x="8" y="10" width="36" height="28" rx="4" stroke="#fff" stroke-width="2.5"/>
                        <path d="M8 34l8 8V38H8z" fill="#fff" opacity="0.5"/>
                        <circle cx="26" cy="24" r="4" fill="#fff" opacity="0.5"/>
                        <path d="M23 22v5" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="23" cy="28.5" r="1" fill="#fff"/>
                        <!-- second chat bubble -->
                        <rect x="22" y="26" width="30" height="22" rx="4" fill="#fff" opacity="0.2" stroke="#fff" stroke-width="2"/>
                        <path d="M52 44l-8 6v-4h8z" fill="#fff" opacity="0.4"/>
                    </svg>
                </div>
            </div>

            <!-- Selesai -->
            <div class="stat-card green">
                <div class="stat-info">
                    <h4>Selesai</h4>
                    <div class="stat-number">5</div>
                </div>
                <div class="stat-icon">
                    <!-- Checklist icon -->
                    <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="10" y="10" width="40" height="44" rx="4" fill="#fff" opacity="0.2" stroke="#fff" stroke-width="2.5"/>
                        <path d="M18 24h28M18 32h20M18 40h14" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="46" cy="46" r="10" fill="#fff" opacity="0.9"/>
                        <path d="M41 46l3.5 3.5L51 43" stroke="#4caf50" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Buat Pengaduan Baru -->
            <div class="stat-card gray new-report">
                <div class="plus-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                </div>
                <span>Buat Pengaduan Baru</span>
            </div>

        </div>

    </div><!-- /content -->
</div><!-- /main-wrapper -->

</body>
</html>