<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengaduan - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, sans-serif;
            background: #0a1628;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOP BAR ── */
        .topbar {
            background: #1a3a5c;
            height: 46px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            gap: 14px;
            flex-shrink: 0;
        }

        .topbar-hamburger {
            display: flex;
            flex-direction: column;
            gap: 4px;
            cursor: pointer;
        }

        .topbar-hamburger span {
            display: block;
            width: 18px;
            height: 2px;
            background: #fff;
            border-radius: 2px;
        }

        .topbar-title {
            color: #fff;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.05em;
        }

        /* ── LAYOUT WRAPPER ── */
        .layout {
            display: flex;
            flex: 1;
            border: 2px solid #1e6fd9;
            border-top: none;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 140px;
            background: #1a3a5c;
            display: flex;
            flex-direction: column;
            padding: 10px 0;
            flex-shrink: 0;
        }

        .sidebar-logo {
            padding: 10px 12px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.12);
            margin-bottom: 8px;
        }

        .sidebar-logo img {
            height: 28px;
            display: block;
        }

        /* logo fallback text */
        .sidebar-logo .logo-text {
            font-size: 10px;
            font-weight: bold;
            color: #fff;
            line-height: 1.3;
        }

        .sidebar-menu {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 0 8px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 6px;
            text-decoration: none;
            color: rgba(255,255,255,0.75);
            font-size: 12px;
            font-weight: normal;
            transition: background 0.15s;
            cursor: pointer;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .menu-item.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
            font-weight: bold;
        }

        .menu-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-icon svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        .menu-label { line-height: 1.25; }

        .sidebar-bottom {
            padding: 10px 8px 14px;
        }

        .btn-logout {
            display: block;
            text-align: center;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.35);
            color: rgba(255,255,255,0.8);
            font-size: 12px;
            padding: 6px 0;
            border-radius: 20px;
            text-decoration: none;
            cursor: pointer;
            width: 100%;
        }

        .btn-logout:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        /* ── MAIN CONTENT ── */
        .main {
            flex: 1;
            background: #fff;
            padding: 20px 24px;
            overflow-x: auto;
        }

        .main-title {
            font-size: 17px;
            font-weight: bold;
            color: #1a3a5c;
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
        .filter-bar input[type="text"],
        .filter-bar input[type="date"] {
            height: 30px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0 8px;
            font-size: 12px;
            color: #555;
            background: #fff;
            outline: none;
        }

        .filter-bar select { width: 100px; }
        .filter-bar input[type="date"] { width: 110px; }

        .filter-spacer { flex: 1; }

        .search-wrap {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
            height: 30px;
        }

        .search-wrap input {
            border: none;
            outline: none;
            padding: 0 10px;
            font-size: 12px;
            width: 160px;
            height: 100%;
        }

        .search-wrap button {
            background: #fff;
            border: none;
            border-left: 1px solid #ccc;
            padding: 0 9px;
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

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead tr {
            border-bottom: 1px solid #ddd;
        }

        thead th {
            padding: 8px 10px;
            text-align: left;
            font-size: 12.5px;
            font-weight: bold;
            color: #333;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }

        tbody tr:last-child { border-bottom: none; }

        tbody td {
            padding: 10px 10px;
            color: #333;
            vertical-align: middle;
        }

        .td-no { width: 36px; color: #555; }

        .badge-proses {
            color: #e07800;
            font-size: 12px;
        }

        .badge-selesai {
            color: #1a9a4a;
            font-size: 12px;
        }

        .link-detail {
            color: #1a6bcc;
            font-size: 12px;
            text-decoration: none;
            margin-right: 6px;
        }

        .link-detail:hover { text-decoration: underline; }

        .link-salurkan {
            color: #1a3a5c;
            font-size: 12px;
            text-decoration: none;
            font-weight: bold;
        }

        .link-salurkan:hover { text-decoration: underline; }
    </style>
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <div class="topbar-hamburger">
        <span></span><span></span><span></span>
    </div>
    <div class="topbar-title">SISTEM PENGADUAN MAHASISWA BERBASIS WEB</div>
</div>

<!-- LAYOUT -->
<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Politeknik Caltex Riau">
        </div>

        <nav class="sidebar-menu">

            <a href="{{ route('dashboard') }}" class="menu-item">
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                </span>
                <span class="menu-label">Dashboard</span>
            </a>

            <a href="{{ route('pengaduan.index') }}" class="menu-item active">
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 7V3.5L18.5 9H13zM6 20V4h5v7h7v9H6z"/></svg>
                </span>
                <span class="menu-label">Kelola Pengaduan</span>
            </a>

            <a href="{{ route('pengaduan.pantau') }}" class="menu-item">
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z"/></svg>
                </span>
                <span class="menu-label">Pantau Pengaduan</span>
            </a>

            <a href="{{ route('rekapitulasi') }}" class="menu-item">
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14H7v-2h5v2zm5-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                </span>
                <span class="menu-label">Rekapitulasi</span>
            </a>

            <a href="{{ route('user.index') }}" class="menu-item">
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                </span>
                <span class="menu-label">Kelola User</span>
            </a>

        </nav>

        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
        <div class="main-title">Kelola pengaduan masuk</div>

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

            <input type="date" name="tanggal" placeholder="Tanggal">

            <div class="filter-spacer"></div>

            <div class="search-wrap">
                <input type="text" placeholder="Search">
                <button type="button">
                    <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0016 9.5 6.5 6.5 0 109.5 16a6.47 6.47 0 004.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0A4.5 4.5 0 115 9.5 4.5 4.5 0 019.5 14z"/></svg>
                </button>
            </div>
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th class="td-no">No</th>
                    <th>Judul Aduan</th>
                    <th>Kategori Aduan</th>
                    <th>Tanggal</th>
                    <th>Solusi</th>
                    <th>Status</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengaduans as $index => $item)
                <tr>
                    <td class="td-no">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('pengaduan.detail', $item->id) }}" class="link-detail">Detail</a>
                    </td>
                    <td>
                        <span class="{{ $item->status === 'Selesai' ? 'badge-selesai' : 'badge-proses' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('pengaduan.detail', $item->id) }}" class="link-detail">Detail</a>
                        @if ($item->status !== 'Selesai')
                            <a href="{{ route('pengaduan.salurkan', $item->id) }}" class="link-salurkan">Salurkan</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding: 30px; color: #aaa; font-size: 13px;">
                        Belum ada pengaduan masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </main>
</div>

</body>
</html>