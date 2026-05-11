@extends('layouts.main-dashboard')

@section('title', 'Dashboard Admin')

@section('content')

    <div class="welcome-card">
        <div class="welcome-text">
            <h3>Selamat Datang!, {{ Auth::user()->name }}</h3>
            <p>{{ Auth::user()->unit->nama_unit ?? 'Admin Unit' }}</p>
        </div>
        <div class="welcome-icon">
            <i class="fa-solid fa-city" style="color: #0d2d6e;"></i>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-info">
                <h4>Pengaduan Baru</h4>
                <div class="stat-number">{{ $stats['baru'] }}</div>
            </div>
            <div class="stat-icon"><i class="fa-solid fa-envelope"></i></div>
        </div>

        <div class="stat-card orange">
            <div class="stat-info">
                <h4>Sedang Diproses</h4>
                <div class="stat-number">{{ $stats['proses'] }}</div>
            </div>
            <div class="stat-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
        </div>

        <div class="stat-card green">
            <div class="stat-info">
                <h4>Selesai</h4>
                <div class="stat-number">{{ $stats['selesai'] }}</div>
            </div>
            <div class="stat-icon"><i class="fa-solid fa-check-double"></i></div>
        </div>
    </div>

    <div class="table-card">
        <div class="card-title">
            <span>Pengaduan Terbaru</span>
            <a href="{{ route('pengaduan.index') }}" style="font-size: 11px; color: #4a9eff; text-decoration: none; border: 1px solid #4a9eff; padding: 2px 8px; border-radius: 10px;">Lihat Semua</a>
        </div>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            @forelse($pengaduans as $p)
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 10px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <i class="fa-solid fa-file-lines" style="font-size: 20px; color: #0d2d6e;"></i>
                    <div>
                        <div style="font-size: 13px; font-weight: 600;">{{ $p->judul }}</div>
                        <div style="font-size: 11px; color: #94a3b8;">{{ $p->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <a href="{{ route('pengaduan.show', $p->id) }}" style="font-size: 12px; color: #0d428e; text-decoration: none; font-weight: 700;">Detail <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i></a>
            </div>
            @empty
            <p style="text-align: center; color: #94a3b8; font-size: 13px;">Belum ada pengaduan masuk.</p>
            @endforelse
        </div>
    </div>
@endsection