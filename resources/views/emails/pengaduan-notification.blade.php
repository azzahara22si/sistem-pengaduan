<div style="font-family:Helvetica,Arial,sans-serif;color:#2d3748;line-height:1.5;">
    @php
        $greeting = match($audience ?? 'admin_spmi') {
            'mahasiswa' => 'Halo ' . ($pengaduan->user->name ?? 'Mahasiswa') . ', ada pembaruan pada pengaduan yang Anda ajukan.',
            'admin_unit' => 'Halo Admin Unit ' . $pengaduan->unit_tujuan . ', pengaduan berikut telah diteruskan ke unit Anda dan perlu ditindaklanjuti.',
            default => 'Halo Admin SPMI, pengaduan berikut perlu ditinjau dan disalurkan ke unit terkait.',
        };
    @endphp

    <h2 style="color:#0d428e;margin-bottom:6px;">Notifikasi Pengaduan</h2>
    <p style="margin-top:0;">{{ $greeting }}</p>

    @if($note)
        <p style="color:#475569;margin-top:0;font-weight:600;">{{ $note }}</p>
    @endif

    <p>Judul: <strong>{{ $pengaduan->judul }}</strong></p>

    @if(($audience ?? 'admin_spmi') !== 'mahasiswa')
        <p>Pelapor: <strong>{{ $pengaduan->getReporterName() }}</strong></p>
    @endif

    <p>Unit Tujuan: <strong>{{ $pengaduan->unit_tujuan }}</strong></p>
    <p>Urgensi: <strong>{{ ucfirst($pengaduan->urgensi) }}</strong></p>

    <p>Deskripsi:</p>
    <div style="padding:10px;background:#f8fafc;border-radius:8px;border:1px solid #e2e8f0;">
        <p style="margin:0;color:#334155;">{{ Str::limit($pengaduan->deskripsi, 400) }}</p>
    </div>

    <p style="margin-top:12px;">Lihat detail pengaduan: <a href="{{ url(route('pengaduan.show', $pengaduan->id)) }}">Buka Pengaduan</a></p>

    <p style="color:#94a3b8;font-size:13px;margin-top:14px;">Harap tindak lanjuti segera jika diperlukan.</p>
</div>