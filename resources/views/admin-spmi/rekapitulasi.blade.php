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
        <p style="color: #64748b; font-size: 14px;">Laporan komprehensif statistik pengaduan mahasiswa.</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #fff; border: 1.5px solid #e2e8f0; border-radius: 12px; color: #64748b; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-print"></i> Cetak Laporan
        </button>
        <button id="btnExport" style="padding: 10px 20px; background: #0d428e; border: none; border-radius: 12px; color: #fff; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-file-excel"></i> Export Excel
        </button>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card" style="background: linear-gradient(135deg, #0d428e, #1e40af); color: #fff; padding: 25px; border-radius: 20px; position: relative;">
        <div style="font-size: 14px; opacity: 0.8; margin-bottom: 10px;">Total Seluruh Pengaduan</div>
        <div style="font-size: 32px; font-weight: 800;">{{ $totalPengaduan }}</div>
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

<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 25px; margin-bottom: 40px;" class="chart-row">

    <div class="table-card" style="background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <h4 style="font-size: 16px; font-weight: 700; color: #0d2d6e; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-chart-simple" style="color: #4a9eff;"></i> Distribusi per Unit Layanan
        </h4>
        <div style="height: 300px;">
            <canvas id="unitChart"></canvas>
        </div>
    </div>

    <div class="table-card" style="background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <h4 style="font-size: 16px; font-weight: 700; color: #0d2d6e; margin-bottom: 20px;">Detail Unit</h4>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            @foreach($units as $unit)
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                <div>
                    <div style="font-size: 14px; font-weight: 600; color: #334155;">{{ $unit->nama_unit }}</div>
                    <div style="font-size: 11px; color: #94a3b8;">{{ $unit->email_unit }}</div>
                </div>
                <div style="background: #f1f5f9; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; color: #0d2d6e;">
                    {{ $unit->pengaduans_count }} Lap
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="table-card" style="background: #fff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
    <div style="padding: 25px 30px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;" class="no-print">
        <h4 style="font-size: 16px; font-weight: 700; color: #0d2d6e;">Data Lengkap Pengaduan</h4>

    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;" id="tableToExport">
            <thead>
                <tr style="background: #f8fafc;">
                    <th style="padding: 18px 24px; text-align: left; font-size: 12px; color: #64748b; text-transform: uppercase;">Waktu</th>
                    <th style="padding: 18px 24px; text-align: left; font-size: 12px; color: #64748b; text-transform: uppercase;">Judul</th>
                    <th style="padding: 18px 24px; text-align: left; font-size: 12px; color: #64748b; text-transform: uppercase;">Unit Tujuan</th>
                    <th style="padding: 18px 24px; text-align: left; font-size: 12px; color: #64748b; text-transform: uppercase;">Pelapor</th>
                    <th style="padding: 18px 24px; text-align: left; font-size: 12px; color: #64748b; text-transform: uppercase;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allPengaduans as $p)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 18px 24px;">
                        <div style="font-size: 13px; font-weight: 600;">{{ $p->created_at->format('d/m/Y') }}</div>
                        <div style="font-size: 11px; color: #94a3b8;" class="no-print">{{ $p->created_at->format('H:i') }} WIB</div>
                    </td>
                    <td style="padding: 18px 24px; font-weight: 600; color: #0d2d6e;">{{ Str::limit($p->judul, 40) }}</td>
                    <td style="padding: 18px 24px; font-size: 13px; color: #64748b;">{{ $p->unit_tujuan }}</td>
                    <td style="padding: 18px 24px; font-size: 13px;">{{ $p->user->name }}</td>
                    <td style="padding: 18px 24px;">
                        <span style="padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; 
                                     background: {{ $p->status === 'selesai' ? '#dcfce7' : ($p->status === 'proses' ? '#fff7ed' : '#fffbeb') }};
                                     color: {{ $p->status === 'selesai' ? '#166534' : ($p->status === 'proses' ? '#f97316' : '#92400e') }};">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="padding: 20px; display: flex; justify-content: center;" class="no-print">
        {{ $allPengaduans->links() }}
    </div>
</div>

<table id="fullTableForExport" style="display: none;">
    <thead>
        <tr>
            <th>Waktu</th>
            <th>Judul Pengaduan</th>
            <th>Deskripsi</th>
            <th>Unit Tujuan</th>
            <th>Pelapor</th>
            <th>Email Pelapor</th>
            <th>Urgensi</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($exportData as $e)
        <tr>
            <td>{{ $e->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $e->judul }}</td>
            <td>{{ $e->deskripsi }}</td>
            <td>{{ $e->unit_tujuan }}</td>
            <td>{{ $e->user->name }}</td>
            <td>{{ $e->user->email }}</td>
            <td>{{ $e->urgensi }}</td>
            <td>{{ $e->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

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

    document.getElementById('btnExport').addEventListener('click', function() {
        const table = document.getElementById('fullTableForExport');
        const total = "{{ $totalPengaduan }}";
        const date = new Date().toLocaleString('id-ID');

        let html = `
            <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
            <head>

                <meta charset="utf-8">
                <style>
                    table { border-collapse: collapse; width: 100%; }
                    th { border: 0.5pt solid #000000; background-color: #0d428e; color: #ffffff; font-weight: bold; padding: 5px; }
                    td { border: 0.5pt solid #000000; padding: 5px; vertical-align: top; }
                    .title { font-size: 18px; font-weight: bold; text-align: center; }
                    .summary { background-color: #f1f5f9; font-weight: bold; }
                </style>
            </head>
            <body>
                <div class="title">LAPORAN REKAPITULASI PENGADUAN MAHASISWA</div>
                <div style="text-align: center;">Politeknik Caltex Riau - Dicetak pada: ${date}</div>
                <br>
                <table>
                    <tr><td colspan="2" class="summary">RINGKASAN STATISTIK</td></tr>
                    <tr><td>Total Pengaduan</td><td>${total}</td></tr>
                    @foreach($statusStats as $stat)
                    <tr><td>Status {{ ucfirst($stat->status) }}</td><td>{{ $stat->total }}</td></tr>
                    @endforeach
                </table>
                <br>
                <table>
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Judul Pengaduan</th>
                            <th>Deskripsi</th>
                            <th>Unit Tujuan</th>
                            <th>Pelapor</th>
                            <th>Email Pelapor</th>
                            <th>Urgensi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${Array.from(table.rows).slice(1).map(row => `
                            <tr>
                                ${Array.from(row.cells).map(cell => `<td>${cell.innerText.trim()}</td>`).join('')}
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </body>
            </html>
        `;

        const blob = new Blob([html], { type: 'application/vnd.ms-excel' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = url;
        link.download = "laporan_rekapitulasi_" + new Date().toISOString().slice(0,10) + ".xls";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    });
</script>
@endpush

<style>
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
