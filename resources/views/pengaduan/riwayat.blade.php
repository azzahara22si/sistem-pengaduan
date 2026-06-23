@extends('layouts.main-dashboard')

@section('title', 'Riwayat Tanggapan')

@push('styles')
<style>
    .page-header {
        display: flex;
        flex-direction: column;
        gap: clamp(8px, 2vw, 12px);
        margin-bottom: clamp(20px, 4vw, 30px);
    }

    .page-title {
        font-size: clamp(20px, 5vw, 28px);
        font-weight: 700;
        color: #0d2d6e;
        margin: 0;
    }

    .page-subtitle {
        color: #64748b;
        font-size: clamp(12px, 2vw, 14px);
        margin: 0;
    }

    .table-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .table-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    th {
        padding: clamp(12px, 2vw, 16px);
        text-align: left;
        font-weight: 700;
        font-size: clamp(11px, 2vw, 12px);
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    td {
        padding: clamp(14px, 2vw, 18px);
        border-bottom: 1px solid #e2e8f0;
        font-size: clamp(12px, 2vw, 13px);
        color: #334155;
    }

    tbody tr:hover {
        background: #f8fafc;
        transition: background-color 0.2s ease;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    .cell-title {
        font-weight: 700;
        color: #0d2d6e;
    }

    .cell-subtitle {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
    }

    .cell-date {
        font-size: 13px;
        font-weight: 500;
    }

    .cell-time {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 2px;
    }

    .urgency-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        text-align: center;
        min-width: 80px;
    }

    .urgency-tinggi {
        background: #fef2f2;
        color: #ef4444;
    }

    .urgency-sedang {
        background: #fffbeb;
        color: #fbbf24;
    }

    .urgency-rendah {
        background: #f0f9ff;
        color: #3b82f6;
    }

    .status-selesai {
        display: inline-block;
        background: #dcfce7;
        color: #15803d;
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid #bbf7d0;
    }

    .action-cell {
        display: flex;
        gap: clamp(6px, 1vw, 8px);
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn-detail {
        background: #f0f7ff;
        color: #0d428e;
        border-color: #dbeafe;
    }

    .btn-detail:hover {
        background: #dbeafe;
        transform: translateY(-1px);
    }

    .btn-rating {
        background: #fbbf24;
        color: white;
        border: none;
    }

    .btn-rating:hover {
        background: #f59e0b;
        transform: translateY(-1px);
    }

    .rating-display {
        display: flex;
        gap: 2px;
        align-items: center;
    }

    .rating-star {
        color: #fbbf24;
        font-size: 12px;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: clamp(40px, 8vw, 60px) clamp(20px, 5vw, 40px);
        text-align: center;
    }

    .empty-icon {
        font-size: clamp(40px, 10vw, 56px);
        color: #e2e8f0;
        margin-bottom: 16px;
    }

    .empty-title {
        font-weight: 600;
        color: #64748b;
        margin-bottom: 6px;
        font-size: clamp(14px, 2.5vw, 16px);
    }

    .empty-subtitle {
        font-size: clamp(12px, 2vw, 13px);
        color: #94a3b8;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: clamp(20px, 4vw, 30px);
    }

    @media (max-width: 768px) {
        table {
            font-size: 12px;
        }

        th, td {
            padding: 12px 8px;
        }

        .action-cell {
            flex-direction: column;
            gap: 6px;
            width: 100%;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }

    .star-rating {
        font-size: 36px;
        color: #e2e8f0;
        cursor: pointer;
        transition: color 0.2s;
    }

    .star-rating:hover,
    .star-rating:hover ~ .star-rating,
    input[type="radio"]:checked ~ .star-rating {
        color: #fbbf24;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h2 class="page-title">Riwayat Pengaduan</h2>
    <p class="page-subtitle">
        @if(Auth::user()->role === 'admin')
            Daftar semua pengaduan yang telah selesai ditangani oleh unit {{ Auth::user()->unit->nama_unit ?? '' }}.
        @else
            Daftar semua pengaduan Anda yang telah selesai diproses.
        @endif
    </p>
</div>

<div class="table-wrapper">
    <div class="table-card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Judul Aduan</th>
                        <th>Pelapor</th>
                        <th>Tanggal Selesai</th>
                        <th>Urgensi</th>
                        <th>Status</th>
                        <th style="text-align: center; width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduans as $index => $item)
                    <tr>
                        <td style="color: #94a3b8; font-weight: 600;">{{ ($pengaduans->currentPage() - 1) * $pengaduans->perPage() + $index + 1 }}</td>
                        <td>
                            <div class="cell-title">{{ $item->judul }}</div>
                            <div class="cell-subtitle">ID: #ADU-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600;">{{ $item->user->name }}</div>
                            <div class="cell-subtitle">{{ $item->user->email }}</div>
                        </td>
                        <td>
                            <div class="cell-date">{{ $item->updated_at->format('d M Y') }}</div>
                            <div class="cell-time">{{ $item->updated_at->format('H:i') }} WIB</div>
                        </td>
                        <td>
                            <span class="urgency-badge urgency-{{ $item->urgensi }}">
                                {{ ucfirst($item->urgensi) }}
                            </span>
                        </td>
                        <td>
                            <span class="status-selesai">Selesai</span>
                        </td>
                        <td>
                            <div class="action-cell">
                                <a href="{{ route('pengaduan.show', $item->id) }}" class="btn-action btn-detail">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </a>
                                @if(Auth::user()->role === 'mahasiswa')
                                    @if(is_null($item->rating))
                                        <button type="button" onclick="openFeedbackModal({{ $item->id }})" class="btn-action btn-rating">
                                            <i class="fa-solid fa-star"></i> Nilai
                                        </button>
                                    @else
                                        <div class="rating-display" title="Rating: {{ $item->rating }}/5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star rating-star" style="opacity: {{ $i <= $item->rating ? '1' : '0.3' }};"></i>
                                            @endfor
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fa-solid fa-folder-open"></i>
                                </div>
                                <div class="empty-title">Belum ada riwayat pengaduan selesai</div>
                                <div class="empty-subtitle">Hanya pengaduan dengan status 'Selesai' yang akan muncul di sini</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="pagination-wrapper">
    {{ $pengaduans->links() }}
</div>

@if(Auth::user()->role === 'mahasiswa')
<div id="feedbackModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: white; width: 100%; max-width: 500px; border-radius: 16px; padding: 30px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); position: relative; animation: slideUp 0.3s ease; margin: 20px;">
        <button type="button" onclick="closeFeedbackModal()" style="position: absolute; top: 20px; right: 20px; background: none; border: none; color: #94a3b8; font-size: 20px; cursor: pointer; transition: color 0.2s;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div style="text-align: center; margin-bottom: 25px;">
            <div style="width: 60px; height: 60px; background: #fffbeb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                <i class="fa-solid fa-star" style="font-size: 28px; color: #fbbf24;"></i>
            </div>
            <h3 style="font-size: 20px; font-weight: 700; color: #0d2d6e; margin: 0 0 8px 0;">Beri Penilaian</h3>
            <p style="color: #64748b; font-size: 13px; margin: 0;">Seberapa puas Anda dengan penanganan pengaduan ini?</p>
        </div>

        <form id="feedbackForm" method="POST" action="">
            @csrf

            <div style="display: flex; justify-content: center; gap: 10px; margin-bottom: 25px; direction: rtl;">
                <input type="radio" id="star5" name="rating" value="5" style="display: none;" required/>
                <label for="star5" class="star-rating"><i class="fa-solid fa-star"></i></label>
                <input type="radio" id="star4" name="rating" value="4" style="display: none;" />
                <label for="star4" class="star-rating"><i class="fa-solid fa-star"></i></label>
                <input type="radio" id="star3" name="rating" value="3" style="display: none;" />
                <label for="star3" class="star-rating"><i class="fa-solid fa-star"></i></label>
                <input type="radio" id="star2" name="rating" value="2" style="display: none;" />
                <label for="star2" class="star-rating"><i class="fa-solid fa-star"></i></label>
                <input type="radio" id="star1" name="rating" value="1" style="display: none;" />
                <label for="star1" class="star-rating"><i class="fa-solid fa-star"></i></label>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Ulasan (Opsional)</label>
                <textarea name="feedback" rows="4" placeholder="Bagikan pengalaman Anda terkait penanganan ini..." style="width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: 'Poppins', sans-serif; font-size: 13px; color: #334155; resize: vertical; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#0d428e'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
            </div>

            <button type="submit" style="width: 100%; padding: 14px; background: #0d428e; color: white; border: none; border-radius: 12px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fa-solid fa-paper-plane"></i> Kirim Penilaian
            </button>
        </form>
    </div>
</div>

<script>
    function openFeedbackModal(id) {
        document.getElementById('feedbackForm').action = '/pengaduan/' + id + '/feedback';
        const modal = document.getElementById('feedbackModal');
        modal.style.display = 'flex';
        document.getElementById('feedbackForm').reset();
    }

    function closeFeedbackModal() {
        document.getElementById('feedbackModal').style.display = 'none';
    }

    document.getElementById('feedbackModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeFeedbackModal();
        }
    });
</script>
@endif

@endsection
