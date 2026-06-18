@extends('layouts.main-dashboard')

@section('title', 'Dashboard Mahasiswa')

@push('styles')
<style>
    .activity-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #edf2f7;
        transition: all 0.2s;
    }

    .activity-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d2d6e;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        flex-shrink: 0;
    }

    .activity-title {
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .activity-meta {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 2px;
    }

    .activity-btn {
        font-size: 12px;
        color: #0d428e;
        text-decoration: none;
        font-weight: 700;
        background: #fff;
        padding: 8px 16px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        white-space: nowrap;
        border: 1px solid #e2e8f0;
    }

    @media (max-width: 600px) {
        .activity-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .activity-btn {
            width: 100%;
            text-align: center;
        }

        .activity-title {
            -webkit-line-clamp: 2;
        }
    }
</style>
@endpush

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
                <h4>Diajukan</h4>
                <div class="stat-number">{{ $stats['diajukan'] }}</div>
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
            <div class="activity-item">
                <div class="activity-info">
                    <div class="activity-icon">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <div>
                        <div class="activity-title">{{ $p->judul }}</div>
                        <div class="activity-meta">
                            <span style="color: {{ $p->status === 'selesai' ? '#10b981' : ($p->status === 'proses' ? '#f59e0b' : '#94a3b8') }}; font-weight: 700; text-transform: capitalize;">{{ $p->status }}</span> 
                            • {{ $p->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <a href="{{ route('pengaduan.show', $p->id) }}" class="activity-btn">
                    Detail <i class="fa-solid fa-chevron-right" style="font-size: 10px; margin-left: 5px;"></i>
                </a>
            </div>
            @empty
            <div style="text-align: center; padding: 30px 0;">
                <img src="{{ asset('images/empty-state.png') }}" alt="Empty" style="width: 120px; margin-bottom: 15px; opacity: 0.8;">
                <p style="color: #94a3b8; font-size: 13px;">Anda belum pernah membuat pengaduan.</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection
