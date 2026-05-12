@extends('layouts.main-dashboard')

@section('title', 'Dashboard Mahasiswa')

@section('content')

    <div class="welcome-card">
        <div class="welcome-text">
            <h3>Selamat Datang!</h3>
            <p>Halo, {{ Auth::user()->name }}</p>
        </div>
        <div class="welcome-icon">
            <span>😊</span>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-info">
                <h4>Total Pengaduan</h4>
                <div class="stat-number">{{ $stats['total'] }}</div>
            </div>
            <div class="stat-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
        </div>

        <div class="stat-card yellow">
            <div class="stat-info">
                <h4>Menunggu</h4>
                <div class="stat-number">{{ $stats['menunggu'] }}</div>
            </div>
            <div class="stat-icon"><i class="fa-solid fa-hourglass-start"></i></div>
        </div>

        <div class="stat-card orange">
            <div class="stat-info">
                <h4>Sedang Diproses</h4>
                <div class="stat-number">{{ $stats['proses'] }}</div>
            </div>
            <div class="stat-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
        </div>

        <div class="stat-card green">
            <div class="stat-info">
                <h4>Selesai</h4>
                <div class="stat-number">{{ $stats['selesai'] }}</div>
            </div>
            <div class="stat-icon"><i class="fa-solid fa-square-check"></i></div>
        </div>
    </div>

    <div class="table-card">
        <div class="card-title">
            <span>Aktivitas Pengaduan Anda</span>
            <a href="{{ route('pengaduan.index') }}" style="font-size: 11px; color: #4a9eff; text-decoration: none; border: 1px solid #4a9eff; padding: 2px 8px; border-radius: 10px;">Lihat Semua</a>
        </div>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            @forelse($pengaduans as $p)
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 12px; border: 1px solid #edf2f7;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="width: 40px; height: 40px; background: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #0d2d6e; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <div>
                        <div style="font-size: 13.5px; font-weight: 600; color: #1e293b;">{{ $p->judul }}</div>
                        <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">
                            <span style="color: {{ $p->status === 'selesai' ? '#10b981' : ($p->status === 'proses' ? '#f59e0b' : '#94a3b8') }}; font-weight: 700; text-transform: capitalize;">{{ $p->status }}</span> 
                            • {{ $p->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <a href="{{ route('pengaduan.show', $p->id) }}" style="font-size: 12px; color: #0d428e; text-decoration: none; font-weight: 700; background: #fff; padding: 6px 12px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    Detail <i class="fa-solid fa-chevron-right" style="font-size: 10px; margin-left: 5px;"></i>
                </a>
            </div>
            @empty
            <div style="text-align: center; padding: 30px 0;">
                <img src="https://illustrations.popsy.co/gray/box.svg" alt="Empty" style="width: 80px; margin-bottom: 15px; opacity: 0.5;">
                <p style="color: #94a3b8; font-size: 13px;">Anda belum pernah membuat pengaduan.</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection