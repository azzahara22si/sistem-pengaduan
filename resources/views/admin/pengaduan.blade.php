<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengaduan - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

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

        .logout-btn:hover { background-color: #2458c8; }

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

        .page-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a2340;
            margin-bottom: 18px;
        }

        /* Filter Bar */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .filter-bar select,
        .filter-bar input[type="date"] {
            height: 32px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            padding: 0 10px;
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
            color: #555;
            background: #fff;
            outline: none;
        }

        .filter-bar select { width: 110px; }
        .filter-bar input[type="date"] { width: 130px; }

        .filter-spacer { flex: 1; }

        .search-wrap {
            display: flex;
            align-items: center;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            overflow: hidden;
            height: 32px;
            background: #fff;
        }

        .search-wrap input {
            border: none;
            outline: none;
            padding: 0 10px;
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
            width: 160px;
            height: 100%;
        }

        .search-wrap button {
            background: #fff;
            border: none;
            border-left: 1px solid #cbd5e1;
            padding: 0 10px;
            cursor: pointer;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .search-wrap button svg {
            width: 13px;
            height: 13px;
            fill: #888;
        }

        /* Table Card */
        .table-card {
            background: #fff;
            border-radius: 10px;
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

        .aduan-table tbody tr:last-child { border-bottom: none; }

        .aduan-table tbody tr:hover { background-color: #f7f9fd; }

        .aduan-table tbody td {
            padding: 12px 16px;
            color: #334060;
            font-size: 12px;
        }

        .badge-proses {
            color: #e07800;
            font-size: 11.5px;
            font-weight: 500;
        }

        .badge-selesai {
            color: #1a9a4a;
            font-size: 11.5px;
            font-weight: 500;
        }

        .link-detail {
            color: #1a47a0;
            text-decoration: underline;
            font-size: 11.5px;
            cursor: pointer;
            margin-right: 6px;
        }

        .link-salurkan {
            color: #1a47a0;
            text-decoration: underline;
            font-size: 11.5px;
            cursor: pointer;
        }

        .empty-row td {
            text-align: center;
            padding: 30px;
            color: #aaa;
            font-size: 12px;
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
        <a href="#" class="nav-item">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            </span>
            Dashboard
        </a>

        <a href="#" class="nav-item active">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
            </span>
            Kelola<br>Pengaduan
        </a>

        <a href="#" class="nav-item">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/></svg>
            </span>
            Rekapitulasi
        </a>

        <a href="#" class="nav-item">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            </span>
            Kelola User
        </a>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="#">
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
            <span></span><span></span><span></span>
        </div>
        <span class="topbar-title">Sistem Pengaduan Mahasiswa Berbasis Web</span>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="page-title">Kelola pengaduan masuk</div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <select name="kategori">
                <option value="">Kategori</option>
                <option>Sarana dan prasarana</option>
                <option>Akademik</option>
                <option>Kemahasiswaan</option>
            </select>

            <select name="status">
                <option value="">Status</option>
                <option>Proses</option>
                <option>Selesai</option>
            </select>

            <input type="date" name="tanggal">

            <div class="filter-spacer"></div>

            <div class="search-wrap">
                <input type="text" placeholder="Search">
                <button type="button">
                    <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0016 9.5 6.5 6.5 0 109.5 16a6.47 6.47 0 004.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0A4.5 4.5 0 115 9.5 4.5 4.5 0 019.5 14z"/></svg>
                </button>
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
                    @forelse ($pengaduans ?? [] as $index => $item)
                    <tr>
                        <td>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/ m/ Y') }}</td>
                        <td><span class="link-detail">Detail</span></td>
                        <td>
                            <span class="{{ $item->status === 'Selesai' ? 'badge-selesai' : 'badge-proses' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>
                            <span class="link-detail">Detail</span>
                            @if ($item->status !== 'Selesai')
                                <span class="link-salurkan">Salurkan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="7">Belum ada pengaduan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>