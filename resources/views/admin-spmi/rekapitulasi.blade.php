@extends('layouts.main-dashboard')

@section('title', 'Rekapitulasi Pengaduan')

@section('content')

<div class="print-header" style="display: none; text-align: center; margin-bottom: 30px; border-bottom: 3px double #000; padding-bottom: 20px;">
    <div style="display: flex; align-items: center; justify-content: center; gap: 20px;">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 80px;">
        <div style="text-align: center;">
            <h1 style="margin: 0; font-size: 20px; text-transform: uppercase;">Sistem Pengaduan Mahasiswa Berbasis Web</h1>
            <h2 style="margin: 5px 0; font-size: 18px;">Politeknik Caltex Riau</h2>
            <p style="margin: 0; font-size: 12px; color: #334155;">Jalan Umban Sari (Paus) No. 1, Rumbai, Kota Pekanbaru, Provinsi Riau</p>
        </div>
    </div>
</div>

<div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 15px;" class="no-print">
    <div>
        <h2 style="font-size: 24px; font-weight: 700; color: #0d2d6e; margin-bottom: 5px;">Rekapitulasi Pengaduan</h2>
        <p style="color: #64748b; font-size: 14px;">Ringkasan kinerja penanganan pengaduan untuk {{ $labelPeriode }}.</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #fff; border: 1.5px solid #e2e8f0; border-radius: 12px; color: #64748b; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-print"></i> Cetak Laporan
        </button>
    </div>
</div>

<form method="GET" action="{{ route('rekapitulasi') }}" class="no-print" style="display: flex; align-items: end; flex-wrap: wrap; gap: 12px; background: #fff; border: 1px solid #eef2f7; padding: 16px; border-radius: 12px; margin-bottom: 24px;">
    <div>
        <label style="display: block; color: #64748b; font-size: 11px; font-weight: 700; margin-bottom: 6px;">PERIODE</label>
        <select name="periode" onchange="this.form.submit()" style="height: 38px; min-width: 170px; border: 1px solid #dbe3ef; border-radius: 8px; padding: 0 10px; color: #334155; background: #fff;">
            <option value="today" {{ $periode === 'today' ? 'selected' : '' }}>Hari ini</option>
            <option value="7days" {{ $periode === '7days' ? 'selected' : '' }}>7 hari terakhir</option>
            <option value="monthly" {{ $periode === 'monthly' ? 'selected' : '' }}>Pilih bulan</option>
            <option value="year" {{ $periode === 'year' ? 'selected' : '' }}>Tahun ini</option>
            <option value="custom" {{ $periode === 'custom' ? 'selected' : '' }}>Rentang tanggal</option>
        </select>
    </div>
    @if($periode === 'custom')
        <div>
            <label style="display: block; color: #64748b; font-size: 11px; font-weight: 700; margin-bottom: 6px;">MULAI</label>
            <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai', $tanggalMulai->toDateString()) }}" style="height: 38px; border: 1px solid #dbe3ef; border-radius: 8px; padding: 0 10px; color: #334155;">
        </div>
        <div>
            <label style="display: block; color: #64748b; font-size: 11px; font-weight: 700; margin-bottom: 6px;">SELESAI</label>
            <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai', $tanggalSelesai->toDateString()) }}" style="height: 38px; border: 1px solid #dbe3ef; border-radius: 8px; padding: 0 10px; color: #334155;">
        </div>
        <button type="submit" style="height: 38px; padding: 0 14px; background: #0d428e; color: #fff; border: 0; border-radius: 8px; font-weight: 700; cursor: pointer;">Terapkan</button>
    @elseif($periode === 'monthly')
        <div>
            <label style="display: block; color: #64748b; font-size: 11px; font-weight: 700; margin-bottom: 6px;">BULAN</label>
            <input type="month" name="bulan" value="{{ request('bulan', $tanggalMulai->format('Y-m')) }}" style="height: 38px; border: 1px solid #dbe3ef; border-radius: 8px; padding: 0 10px; color: #334155;">
        </div>
        <button type="submit" style="height: 38px; padding: 0 14px; background: #0d428e; color: #fff; border: 0; border-radius: 8px; font-weight: 700; cursor: pointer;">Terapkan</button>
    @endif
</form>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card" style="background: linear-gradient(135deg, #0d428e, #1e40af); color: #fff; padding: 25px; border-radius: 20px; position: relative;">
        <div style="font-size: 14px; opacity: 0.8; margin-bottom: 10px;">Total Seluruh Pengaduan</div>
        <div style="font-size: 32px; font-weight: 800;">{{ $totalPengaduan }}</div>
        @if(!is_null($perubahanPersentase))
            <div style="font-size: 11px; margin-top: 7px; opacity: .85;">{{ $perubahanPersentase >= 0 ? '+' : '' }}{{ $perubahanPersentase }}% dari periode sebelumnya</div>
        @endif
        <i class="fa-solid fa-layer-group" style="position: absolute; right: 25px; bottom: 25px; font-size: 40px; opacity: 0.2;"></i>
    </div>

    @foreach($statusStats as $stat)
    @php
        $icon = 'fa-chart-pie';
        if (strtolower($stat->status) === 'diajukan') { $icon = 'fa-file-arrow-up'; }
        elseif (strtolower($stat->status) === 'proses') { $icon = 'fa-hourglass-half'; }
        elseif (strtolower($stat->status) === 'selesai') { $icon = 'fa-check-double'; }
    @endphp
    <div class="stat-card" style="background: #fff; padding: 25px; border-radius: 20px; border: 1.5px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); position: relative;">
        <div style="font-size: 13px; color: #64748b; margin-bottom: 10px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Status {{ ucfirst($stat->status) }}</div>
        <div style="display: flex; align-items: baseline; gap: 10px;">
            <div style="font-size: 28px; font-weight: 800; color: #0d2d6e;">{{ $stat->total }}</div>
            <div style="font-size: 12px; color: #10b981; font-weight: 600;">{{ number_format(($stat->total / max($totalPengaduan, 1)) * 100, 1) }}%</div>
        </div>
        <i class="fa-solid {{ $icon }}" style="position: absolute; right: 25px; bottom: 25px; font-size: 40px; opacity: 0.08;"></i>
    </div>
    @endforeach
</div>

<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 25px; margin-bottom: 25px;" class="chart-row">

    <div class="table-card" style="background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <h4 style="font-size: 16px; font-weight: 700; color: #0d2d6e; margin-bottom: 6px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-chart-simple" style="color: #4a9eff;"></i> Beban Pengaduan per Unit
        </h4>
        <p style="font-size: 12px; color: #94a3b8; margin-bottom: 20px;">Jumlah pengaduan yang diterima setiap unit penanganan.</p>
        <div style="height: 300px;">
            <canvas id="unitChart"></canvas>
        </div>
    </div>

    <div class="table-card" style="background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <h4 style="font-size: 16px; font-weight: 700; color: #0d2d6e; margin-bottom: 6px;">Kinerja Unit</h4>
        <p style="font-size: 12px; color: #94a3b8; margin-bottom: 20px;">Progres penyelesaian per unit layanan.</p>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            @foreach($units as $unit)
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                <div>
                    <div style="font-size: 14px; font-weight: 600; color: #334155;">{{ $unit->nama_unit }}</div>
                    <div style="font-size: 11px; color: #94a3b8;">{{ $unit->selesai_count }} selesai dari {{ $unit->pengaduans_count }} pengaduan</div>
                </div>
                <div style="background: #ecfdf5; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; color: #047857;">
                    {{ number_format(($unit->selesai_count / max($unit->pengaduans_count, 1)) * 100) }}%
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 25px;" class="metric-row">
    <div class="table-card" style="background: #fff; border: 1px solid #e8eef6; border-radius: 10px; padding: 18px;">
        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Rata-rata Penyelesaian</div>
        <div style="font-size: 23px; color: #0d2d6e; font-weight: 800; margin-top: 7px;">{{ $rataRataPenyelesaianJam }} jam</div>
        <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">Pengaduan berstatus selesai</div>
    </div>
    <div class="table-card" style="background: #fff; border: 1px solid #e8eef6; border-radius: 10px; padding: 18px;">
        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Kepatuhan SLA</div>
        <div style="font-size: 23px; color: #047857; font-weight: 800; margin-top: 7px;">{{ $slaPersentase }}%</div>
        <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">Selesai maksimal 7 hari</div>
    </div>
    <div class="table-card" style="background: #fff; border: 1px solid #e8eef6; border-radius: 10px; padding: 18px;">
        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Perlu Perhatian</div>
        <div style="font-size: 23px; color: #dc2626; font-weight: 800; margin-top: 7px;">{{ $pengaduanTerlambat }}</div>
        <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">Masih proses lebih dari 7 hari</div>
    </div>
    <div class="table-card" style="background: #fff; border: 1px solid #e8eef6; border-radius: 10px; padding: 18px;">
        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Kepuasan Mahasiswa</div>
        <div style="font-size: 23px; color: #b45309; font-weight: 800; margin-top: 7px;">{{ $rataRataRating ?: '-' }} / 5</div>
        <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">{{ $jumlahRating }} penilaian masuk</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px; margin-bottom: 25px;" class="insight-row">
    <div class="table-card" style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <h4 style="font-size: 15px; font-weight: 700; color: #0d2d6e; margin-bottom: 18px;">Status Pengaduan</h4>
        <div style="height: 220px;"><canvas id="statusChart"></canvas></div>
    </div>
    <div class="table-card" style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <h4 style="font-size: 15px; font-weight: 700; color: #0d2d6e; margin-bottom: 18px;">Klasifikasi Pengaduan</h4>
        <div style="height: 220px;"><canvas id="categoryChart"></canvas></div>
    </div>
    <div class="table-card" style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <h4 style="font-size: 15px; font-weight: 700; color: #0d2d6e; margin-bottom: 18px;">Tingkat Urgensi</h4>
        <div style="height: 220px;"><canvas id="urgencyChart"></canvas></div>
    </div>
    <div class="table-card" style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <h4 style="font-size: 15px; font-weight: 700; color: #0d2d6e; margin-bottom: 18px;">Tren Pengaduan Bulanan</h4>
        <div style="height: 220px;"><canvas id="monthlyChart"></canvas></div>
    </div>
</div>

@push('scripts')
<script>
    const unitCtx = document.getElementById('unitChart').getContext('2d');
    new Chart(unitCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($units->pluck('nama_unit')) !!},
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: {!! json_encode($units->pluck('pengaduans_count')) !!},
                backgroundColor: '#0d428e',
                borderRadius: 8,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { font: { family: 'Poppins' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Poppins', size: 11 } }
                }
            }
        }
    });

    const statusLabels = {!! json_encode($statusStats->pluck('status')->map(fn ($status) => ucfirst($status))) !!};
    const statusValues = {!! json_encode($statusStats->pluck('total')) !!};
    const statusColors = {!! json_encode($statusStats->pluck('status')->map(function ($status) {
        return match (strtolower($status)) {
            'selesai' => '#10b981',
            'proses' => '#f97316',
            default => '#fbbf24',
        };
    })) !!};

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{ data: statusValues, backgroundColor: statusColors, borderWidth: 0 }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '62%',
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { family: 'Poppins', size: 11 } } } }
        }
    });

    const categoryLabels = {!! json_encode($categoryStats->pluck('klasifikasi')->map(function ($category) {
        return match ($category) {
            'permintaan_informasi' => 'Informasi',
            default => ucfirst($category ?? 'pengaduan'),
        };
    })) !!};
    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: categoryLabels,
            datasets: [{ data: {!! json_encode($categoryStats->pluck('total')) !!}, backgroundColor: ['#2563eb', '#f59e0b', '#ef4444'], borderRadius: 6, borderSkipped: false }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0, font: { family: 'Poppins', size: 11 } }, grid: { color: '#f1f5f9' } },
                x: { ticks: { font: { family: 'Poppins', size: 10 } }, grid: { display: false } }
            }
        }
    });

    const urgencyLabels = {!! json_encode($urgencyStats->pluck('urgensi')->map(fn ($urgensi) => ucfirst($urgensi))) !!};
    const urgencyValues = {!! json_encode($urgencyStats->pluck('total')) !!};
    const urgencyColors = urgencyLabels.map((label) => {
        const value = label.toLowerCase();
        if (value === 'tinggi') return '#ef4444';
        if (value === 'sedang') return '#f59e0b';
        return '#94a3b8';
    });

    new Chart(document.getElementById('urgencyChart'), {
        type: 'doughnut',
        data: {
            labels: urgencyLabels,
            datasets: [{ data: urgencyValues, backgroundColor: urgencyColors, borderWidth: 0 }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '62%',
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { family: 'Poppins', size: 11 } } } }
        }
    });

    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const monthlyData = Array(12).fill(0);
    {!! json_encode($monthlyStats) !!}.forEach(stat => monthlyData[stat.month - 1] = Number(stat.total));
    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: monthNames,
            datasets: [{ data: monthlyData, borderColor: '#0d428e', backgroundColor: 'rgba(13, 66, 142, 0.10)', fill: true, tension: 0.35, pointRadius: 3, pointBackgroundColor: '#0d428e' }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0, font: { family: 'Poppins', size: 11 } }, grid: { color: '#f1f5f9' } },
                x: { ticks: { font: { family: 'Poppins', size: 10 } }, grid: { display: false } }
            }
        }
    });

</script>
@endpush

<style>
    @media (max-width: 1100px) {
        .chart-row, .insight-row { grid-template-columns: 1fr 1fr !important; }
        .metric-row { grid-template-columns: 1fr 1fr !important; }
    }

    @media (max-width: 700px) {
        .chart-row, .insight-row { grid-template-columns: 1fr !important; }
        .metric-row { grid-template-columns: 1fr !important; }
    }

    @media print {
        .sidebar, .topbar, .sidebar-overlay, .no-print, button, .pagination, .chart-row { display: none !important; }
        .main-wrapper { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
        .content { padding: 0 !important; }
        .table-card { box-shadow: none !important; border: 1px solid #eee !important; border-radius: 0 !important; }
        .print-header { display: block !important; }
        body { background: white !important; }
        table th { background: #f1f5f9 !important; -webkit-print-color-adjust: exact; }
    }
</style>
@endsection
