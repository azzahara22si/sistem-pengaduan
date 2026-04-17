<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengaduan Mahasiswa - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            padding: 0;
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
            padding: 12px 18px;
            color: #a8bce0;
            text-decoration: none;
            font-size: 12.5px;
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
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        .sidebar-footer {
            padding: 18px 16px;
        }

        .logout-btn {
            display: block;
            width: 100%;
            background-color: #1a47a0;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 9px 0;
            font-size: 12.5px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            text-align: center;
            transition: background 0.2s;
        }

        .logout-btn:hover {
            background-color: #2458c8;
        }

        /* ===== MAIN AREA ===== */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background-color: #fff;
            display: flex;
            align-items: center;
            padding: 0 24px;
            height: 52px;
            border-bottom: 1px solid #e2e8f0;
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
            background: #333;
            border-radius: 2px;
        }

        .topbar-title {
            font-size: 14px;
            font-weight: 700;
            color: #1a2340;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        /* ===== CONTENT ===== */
        .content {
            flex: 1;
            padding: 24px 28px;
            overflow-y: auto;
        }

        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(90deg, #b8cce8 0%, #d5e4f5 100%);
            border-radius: 10px;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            max-width: 400px;
        }

        .welcome-text h3 {
            font-size: 14px;
            font-weight: 700;
            color: #1a2340;
        }

        .welcome-text p {
            font-size: 12px;
            color: #3a4a6b;
            margin-top: 2px;
        }

        .welcome-icon {
            width: 54px;
            height: 54px;
            background: rgba(255,255,255,0.4);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-icon svg {
            width: 34px;
            height: 34px;
        }

        /* Charts Row */
        .charts-row {
            display: flex;
            gap: 20px;
            margin-bottom: 28px;
        }

        .chart-card {
            background: #fff;
            border-radius: 10px;
            padding: 16px 18px;
            flex: 1;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        }

        .chart-card h4 {
            font-size: 10.5px;
            color: #5a6a8a;
            margin-bottom: 12px;
            font-weight: 500;
        }

        .chart-container {
            height: 160px;
            position: relative;
        }

        /* Table */
        .table-card {
            background: #fff;
            border-radius: 10px;
            padding: 0;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
            overflow: hidden;
        }

        .aduan-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .aduan-table thead tr {
            border-bottom: 2px solid #0d2d6e;
        }

        .aduan-table thead th {
            padding: 13px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #1a2340;
        }

        .aduan-table tbody tr {
            border-bottom: 1px solid #eef1f7;
            transition: background 0.15s;
        }

        .aduan-table tbody tr:last-child {
            border-bottom: none;
        }

        .aduan-table tbody tr:hover {
            background-color: #f7f9fd;
        }

        .aduan-table tbody td {
            padding: 12px 16px;
            color: #334060;
            font-size: 12px;
        }

        .status-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 500;
            color: #334060;
        }

        .link-detail {
            color: #1a47a0;
            text-decoration: underline;
            font-size: 11.5px;
            cursor: pointer;
        }

        .link-salurkan {
            color: #1a47a0;
            text-decoration: underline;
            font-size: 11.5px;
            cursor: pointer;
            margin-left: 6px;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Politeknik Caltex Riau">
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('dashboard.admin') }}" 
   class="nav-item {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                </svg>
            </span>
            Dashboard
        </a>
        <a href="{{ route('pengaduan.index') }}" 
   class="nav-item {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
                </svg>
            </span>
            Kelola<br>Pengaduan
        </a>
        
        </a>
        <a href="#" class="nav-item">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/>
                </svg>
            </span>
            Rekapitulasi
        </a>
        <a href="#" class="nav-item">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
            </span>
            Kelola User
        </a>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="logout-btn">Logout</button>
</form>
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
                <h3>Selamat Datang!, Udin</h3>
                <p>Admin SPMI</p>
            </div>
            <div class="welcome-icon">
                <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="4" y="10" width="40" height="32" rx="3" fill="#2458c8" opacity="0.8"/>
                    <rect x="8" y="14" width="32" height="20" rx="1" fill="#d5e4f5"/>
                    <rect x="10" y="16" width="10" height="7" rx="1" fill="#2458c8" opacity="0.5"/>
                    <rect x="22" y="16" width="14" height="2" rx="1" fill="#2458c8" opacity="0.4"/>
                    <rect x="22" y="20" width="10" height="2" rx="1" fill="#2458c8" opacity="0.3"/>
                    <circle cx="46" cy="38" r="12" fill="#1a47a0"/>
                    <circle cx="46" cy="34" r="4" fill="#a8bce0"/>
                    <path d="M38 46c0-4 3.6-7 8-7s8 3 8 7" fill="#a8bce0"/>
                    <rect x="42" y="26" width="8" height="5" rx="2" fill="#4a9eff" opacity="0.8"/>
                </svg>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-row">
            <div class="chart-card">
                <h4>Jumlah pengaduan per unit layanan</h4>
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h4>Proporsi pengaduan berdasarkan kategori</h4>
                <div class="chart-container">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-card">
            <table class="aduan-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Aduan</th>
                        <th>Kategori Aduan</th>
                        <th>Tanggal</th>
                        <th>Solusi</th>
                        <th>Status</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01</td>
                        <td>AC Rusak</td>
                        <td>Sarana dan prasarana</td>
                        <td>19/ 08/ 2025</td>
                        <td><span class="link-detail">Detail</span></td>
                        <td><span class="status-badge">Proses</span></td>
                        <td>
                            <span class="link-detail">Detail</span>
                            <span class="link-salurkan">Salurkan</span>
                        </td>
                    </tr>
                    <tr>
                        <td>02</td>
                        <td>Monitor rusak</td>
                        <td>Sarana dan prasarana</td>
                        <td>28/ 09/ 2024</td>
                        <td><span class="link-detail">Detail</span></td>
                        <td><span class="status-badge">Selesai</span></td>
                        <td>
                            <span class="link-detail">Detail</span>
                            <span class="link-salurkan">Salurkan</span>
                        </td>
                    </tr>
                    <tr>
                        <td>03</td>
                        <td>WC kurang bersih</td>
                        <td>Sarana dan prasarana</td>
                        <td>08/ 10/ 2024</td>
                        <td><span class="link-detail">Detail</span></td>
                        <td><span class="status-badge">Selesai</span></td>
                        <td>
                            <span class="link-detail">Detail</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div><!-- /content -->
</div><!-- /main-wrapper -->

<script>
    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Unit A', 'Unit B', 'Unit C', 'Unit D'],
            datasets: [{
                data: [65, 42, 75, 28],
                backgroundColor: ['#f5a63d', '#4a9eff', '#f5a63d', '#5ecb6e'],
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10 }, color: '#7a8aaa' }
                },
                y: {
                    grid: { color: '#eef1f7' },
                    ticks: { font: { size: 10 }, color: '#7a8aaa' },
                    beginAtZero: true
                }
            }
        }
    });

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['42%', '14%', '37%', '7%'],
            datasets: [{
                data: [42, 14, 37, 7],
                backgroundColor: ['#8b4513', '#c0392b', '#a0522d', '#cd853f'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: { size: 10 },
                        color: '#334060',
                        boxWidth: 12,
                        padding: 8
                    }
                }
            }
        }
    });
</script>
</body>
 </html>