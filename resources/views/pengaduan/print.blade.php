<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Kelola Pengaduan</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; color:#222; padding:20px }
        .title { text-align:center; font-weight:bold; font-size:18px; margin-bottom:6px }
        .subtitle { text-align:center; margin-bottom:12px; color:#555 }
        table{border-collapse:collapse;width:100%}
        th,td{border:1px solid #ddd;padding:8px;text-align:left;font-size:13px}
        th{background:#0d428e;color:#fff}
        .actions { margin-bottom:12px }
        .btn { display:inline-block;padding:8px 12px;background:#0d428e;color:#fff;text-decoration:none;border-radius:6px }
    </style>
</head>
<body>
    <div class="title">LAPORAN KELOLA PENGADUAN</div>
    <div class="subtitle">Dicetak pada {{ now()->format('d/m/Y H:i') }} WIB</div>

    <div class="actions">
        <a href="#" onclick="window.print();return false;" class="btn">Cetak</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Judul</th>
                <th>Unit Tujuan</th>
                <th>Unit Penanganan</th>
                <th>Pelapor</th>
                <th>Urgensi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengaduans as $pengaduan)
                <tr>
                    <td>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $pengaduan->judul }}</td>
                    <td>{{ $pengaduan->unit_tujuan_awal ?: $pengaduan->unit_tujuan }}</td>
                    <td>{{ $pengaduan->unit_id ? $pengaduan->unit_tujuan : 'Belum ditetapkan' }}</td>
                    <td>{{ $pengaduan->getReporterName() }}</td>
                    <td>{{ ucfirst($pengaduan->urgensi) }}</td>
                    <td>{{ ucfirst($pengaduan->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:16px;color:#666">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
