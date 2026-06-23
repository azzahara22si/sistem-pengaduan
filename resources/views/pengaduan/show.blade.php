@extends('layouts.main-dashboard')

@section('title', 'Detail Pengaduan')

@push('styles')
<style>
    .detail-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
    }

    .detail-card {
        background: #fff;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 20px;
    }

    .detail-title {
        font-size: clamp(18px, 5vw, 22px);
        color: #0d2d6e;
        font-weight: 700;
        line-height: 1.35;
        overflow-wrap: anywhere;
    }

    .badge-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: capitalize;
    }
    .status-diajukan { background: #fef3c7; color: #92400e; }
    .status-proses { background: #fff7ed; color: #f97316; }
    .status-selesai { background: #dcfce7; color: #166534; }

    .klasifikasi-badge-detail {
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .klasifikasi-pengaduan { background: #fee2e2; color: #991b1b; }
    .klasifikasi-aspirasi { background: #fef3c7; color: #92400e; }
    .klasifikasi-permintaan_informasi { background: #dbeafe; color: #1e40af; }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-item label {
        display: block;
        font-size: 12px;
        color: #94a3b8;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .info-item p {
        font-size: 14px;
        color: #1e293b;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .description-box {
        background: #f8fafc;
        border-radius: 15px;
        padding: 20px;
        line-height: 1.8;
        color: #475569;
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .image-preview {
        width: 100%;
        border-radius: 15px;
        margin-top: 20px;
        border: 1px solid #e2e8f0;
    }

    .tanggapan-section {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid #f1f5f9;
    }

    .tanggapan-card {
        background: #f0f9ff;
        border-left: 4px solid #0d428e;
        padding: 20px;
        border-radius: 0 15px 15px 0;
        margin-bottom: 15px;
    }

    .tanggapan-meta {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }

    .status-choice-grid {
        display: flex;
        gap: 15px;
    }

    .feedback-modal-card {
        background: white;
        width: calc(100vw - 30px);
        max-width: 500px;
        border-radius: 16px;
        padding: clamp(18px, 5vw, 30px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        position: relative;
        animation: slideUp 0.3s ease;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 20px;
        transition: color 0.2s;
    }

    .btn-back:hover { color: #0d428e; }

    .action-panel {
        margin-top: 35px;
        padding: 25px 20px;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 18px;
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        align-items: center;
    }

    .action-panel p {
        margin: 0;
        color: #475569;
        font-size: 13px;
        flex: 1 1 100%;
        line-height: 1.6;
    }

    .action-panel-item {
        flex: 1 1 220px;
        min-width: 220px;
    }

    .action-panel-item form {
        margin: 0;
        display: block;
        height: 100%;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 22px;
        border-radius: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        width: 100%;
        white-space: nowrap;
        border: none;
        font-family: inherit;
        font-size: 14px;
        cursor: pointer;
        line-height: 1.5;
        box-sizing: border-box;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
    }

    .btn-edit {
        background: #0d428e;
        color: #fff;
    }

    .btn-delete {
        background: #ef4444;
        color: #fff;
    }

    @media (max-width: 992px) {
        .detail-container {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .detail-card {
            padding: 20px;
        }
        .detail-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .info-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        .action-panel {
            flex-direction: column;
            align-items: stretch;
            padding: 20px 15px;
        }
        .action-panel-item {
            width: 100%;
            min-width: 0;
        }

        .status-choice-grid {
            gap: 10px;
        }
    }

    @media (max-width: 480px) {
        .detail-container {
            gap: 14px;
        }

        .detail-card {
            border-radius: 14px;
            padding: 16px;
        }

        .detail-header {
            margin-bottom: 20px;
            padding-bottom: 16px;
        }

        .badge-group,
        .status-badge,
        .klasifikasi-badge-detail {
            width: 100%;
        }

        .status-badge,
        .klasifikasi-badge-detail {
            display: inline-flex;
            justify-content: center;
            min-height: 34px;
            align-items: center;
        }

        .description-box,
        .tanggapan-card {
            padding: 14px;
            border-radius: 12px;
        }

        .tanggapan-meta {
            flex-direction: column;
        }

        .tanggapan-meta span {
            white-space: normal !important;
        }

        .status-choice-grid {
            flex-direction: column;
        }

        .feedback-modal-card {
            width: calc(100vw - 24px);
            max-height: calc(100vh - 24px);
            overflow-y: auto;
        }
    }
</style>
@endpush

@section('content')
<a href="{{ route('pengaduan.index') }}" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
</a>

<div class="detail-container">

    <div class="detail-card">
        <div class="detail-header">
            <div>
                <h2 class="detail-title">{{ $pengaduan->judul }}</h2>
                <p style="font-size: 13px; color: #94a3b8; margin-top: 5px;">ID Pengaduan: #ADU-{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="badge-group">
                <span class="status-badge status-{{ strtolower($pengaduan->status) }}">
                    {{ $pengaduan->status }}
                </span>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <label>Klasifikasi</label>
                <p>
                    @php
                        $klasifikasi = $pengaduan->klasifikasi ?? 'pengaduan';
                        $icons = [
                            'pengaduan' => 'fa-exclamation-circle',
                            'aspirasi' => 'fa-lightbulb',
                            'permintaan_informasi' => 'fa-circle-info'
                        ];
                        $labels = [
                            'pengaduan' => 'Pengaduan',
                            'aspirasi' => 'Aspirasi',
                            'permintaan_informasi' => 'Permintaan Informasi'
                        ];
                    @endphp
                    <span class="klasifikasi-badge-detail klasifikasi-{{ $klasifikasi }}">
                        <i class="fa-solid {{ $icons[$klasifikasi] }}"></i>
                        {{ $labels[$klasifikasi] }}
                    </span>
                </p>
            </div>
            <div class="info-item">
                <label>Unit Tujuan</label>
                <p>{{ $pengaduan->unit_tujuan }}</p>
            </div>
            <div class="info-item">
                <label>Tingkat Urgensi</label>
                <p style="color: {{ $pengaduan->urgensi === 'tinggi' ? '#ef4444' : ($pengaduan->urgensi === 'sedang' ? '#fbbf24' : '#64748b') }}">
                    <i class="fa-solid fa-circle" style="font-size: 8px; margin-right: 5px;"></i>
                    {{ ucfirst($pengaduan->urgensi) }}
                </p>
            </div>
            <div class="info-item">
                <label>Tanggal Pengaduan</label>
                <p>{{ $pengaduan->created_at->format('d F Y, H:i') }}</p>
            </div>
            <div class="info-item">
                <label>Pelapor</label>
                <p>{{ $pengaduan->user->name }} ({{ ucfirst($pengaduan->user->role) }})</p>
            </div>
        </div>

        <div class="form-group">
            <label style="display: block; font-size: 12px; color: #94a3b8; margin-bottom: 10px; font-weight: 600;">Deskripsi Pengaduan</label>
            <div class="description-box">
                {{ $pengaduan->description ?? $pengaduan->deskripsi }}
            </div>
        </div>

        @if($pengaduan->foto)
        <div style="margin-top: 30px;">
            <label style="display: block; font-size: 12px; color: #94a3b8; margin-bottom: 10px; font-weight: 600;">Bukti Foto</label>
            <img src="{{ route('pengaduan.foto', $pengaduan->id) }}" alt="Bukti Foto" class="image-preview">
        </div>
        @endif

        @if(Auth::user()->role === 'mahasiswa' && $pengaduan->status === 'diajukan')
        <div class="action-panel">
            <p>Pengaduan dengan status <strong>Diajukan</strong> masih bisa diedit atau dihapus.</p>
            <div class="action-panel-item">
                <a href="{{ route('pengaduan.edit', $pengaduan->id) }}" class="action-btn btn-edit">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Pengaduan
                </a>
            </div>
            <div class="action-panel-item">
                <form action="{{ route('pengaduan.destroy', $pengaduan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn btn-delete delete">
                        <i class="fa-solid fa-trash"></i> Hapus Pengaduan
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="detail-card">
        <h3 style="font-size: 18px; color: #0d2d6e; font-weight: 700; margin-bottom: 20px;">Tanggapan</h3>

        <div class="tanggapan-list">
            @forelse($pengaduan->tanggapan as $t)
            <div class="tanggapan-card">
                <p style="font-size: 13px; color: #334155; line-height: 1.6;">{{ $t->isi_tanggapan }}</p>
                <div style="margin-top: 12px;">
                    <div class="tanggapan-meta">
                        <div>
                            <div style="font-size: 11px; font-weight: 700; color: #0d428e; margin-bottom: 4px;">
                                <i class="fa-solid fa-user-tie" style="margin-right: 4px;"></i> {{ $t->user->name ?? 'Admin' }} 
                                <span style="color: #64748b; font-weight: normal;">({{ $t->user && $t->user->role === 'admin_spmi' ? 'Admin SPMI' : 'Admin Unit' }})</span>
                            </div>
                            @if($t->user)
                                <div style="font-size: 10px; color: #64748b; margin-left: 16px; margin-bottom: 2px;">
                                    <i class="fa-solid fa-envelope" style="margin-right: 4px;"></i> Email Pribadi: {{ $t->user->email }}
                                </div>
                                @if($t->user->role === 'admin' && $t->user->unit)
                                    <div style="font-size: 10px; color: #64748b; margin-left: 16px;">
                                        <i class="fa-solid fa-building" style="margin-right: 4px;"></i> Email Unit: {{ $t->user->unit->email_unit ?? '-' }}
                                    </div>
                                @endif
                            @endif
                        </div>
                        <span style="font-size: 11px; color: #94a3b8; white-space: nowrap;">{{ $t->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 30px 0;">
                <i class="fa-solid fa-comments" style="font-size: 40px; color: #e2e8f0; margin-bottom: 15px; display: block;"></i>
                <p style="font-size: 13px; color: #94a3b8;">Belum ada tanggapan.</p>
            </div>
            @endforelse
        </div>

        @if(Auth::user()->role !== 'mahasiswa' && $pengaduan->status !== 'selesai')
        <div class="tanggapan-section">
            <h4 style="font-size: 15px; font-weight: 700; color: #0d2d6e; margin-bottom: 20px;">
                <i class="fa-solid fa-reply-all" style="margin-right: 8px;"></i> Berikan Tanggapan & Update Status
            </h4>

            <form action="{{ route('tanggapan.store', $pengaduan->id) }}" method="POST">
                @csrf
                <input type="hidden" name="pengaduan_id" value="{{ $pengaduan->id }}">

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 10px;">Update Status Pengaduan:</label>
                    <div class="status-choice-grid">
                        <label style="flex: 1; cursor: pointer;">
                            <input type="radio" name="status" value="proses" {{ $pengaduan->status === 'proses' ? 'checked' : '' }} style="display: none;" onchange="updateStatusStyle(this)">
                            <div class="status-option {{ $pengaduan->status === 'proses' ? 'active-proses' : '' }}" style="padding: 12px; border: 1.5px solid #e2e8f0; border-radius: 12px; text-align: center; font-size: 13px; font-weight: 600; color: #64748b; transition: all 0.2s;">
                                <i class="fa-solid fa-spinner"></i> Proses
                            </div>
                        </label>
                        <label style="flex: 1; cursor: pointer;">
                            <input type="radio" name="status" value="selesai" {{ $pengaduan->status === 'selesai' ? 'checked' : '' }} style="display: none;" onchange="updateStatusStyle(this)">
                            <div class="status-option" style="padding: 12px; border: 1.5px solid #e2e8f0; border-radius: 12px; text-align: center; font-size: 13px; font-weight: 600; color: #64748b; transition: all 0.2s;">
                                <i class="fa-solid fa-check-double"></i> Selesai
                            </div>
                        </label>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 10px;">Isi Tanggapan/Solusi:</label>
                    <textarea name="isi_tanggapan" style="width: 100%; min-height: 120px; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 15px; font-family: 'Poppins'; font-size: 13.5px; outline: none; transition: all 0.2s; background: #f8fafc;" placeholder="Tuliskan tanggapan atau solusi untuk pengaduan ini..." required></textarea>
                </div>

                <button type="submit" style="width: 100%; background: #0d428e; color: #fff; border: none; border-radius: 14px; height: 50px; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 6px -1px rgba(13, 66, 142, 0.2);">
                    <i class="fa-solid fa-paper-plane" style="margin-right: 8px;"></i> Simpan & Kirim Tanggapan
                </button>
            </form>
        </div>

        @push('scripts')
        <script>
            function updateStatusStyle(input) {

                const options = document.querySelectorAll('.status-option');
                options.forEach(opt => {
                    opt.style.borderColor = '#e2e8f0';
                    opt.style.background = 'transparent';
                    opt.style.color = '#64748b';
                });

                const target = input.nextElementSibling;
                if (input.value === 'proses') {
                    target.style.borderColor = '#f97316';
                    target.style.background = '#fff7ed';
                    target.style.color = '#b45309';
                } else if (input.value === 'selesai') {
                    target.style.borderColor = '#10b981';
                    target.style.background = '#ecfdf5';
                    target.style.color = '#065f46';
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                const checked = document.querySelector('input[name="status"]:checked');
                if (checked) updateStatusStyle(checked);
            });
        </script>
        @endpush
        @endif

        @if(Auth::user()->role === 'mahasiswa' && $pengaduan->status === 'selesai' && is_null($pengaduan->rating))
        <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #f1f5f9; text-align: center;">
            <p style="font-size: 13px; color: #64748b; margin-bottom: 15px;">Pengaduan ini telah selesai. Silakan berikan penilaian Anda terhadap layanan kami.</p>
            <button onclick="openFeedbackModal({{ $pengaduan->id }})" style="padding: 12px 24px; background: #fbbf24; color: white; border-radius: 12px; font-size: 14px; font-weight: 700; border: none; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-star"></i> Beri Penilaian
            </button>
        </div>
        @endif

        @if(!is_null($pengaduan->rating))
        <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #f1f5f9;">
            <h4 style="font-size: 15px; font-weight: 700; color: #0d2d6e; margin-bottom: 20px;">
                <i class="fa-solid fa-star" style="color: #fbbf24; margin-right: 8px;"></i> Penilaian & Ulasan Mahasiswa
            </h4>

            <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 14px; padding: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                    <div style="display: flex; gap: 4px; font-size: 18px;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star" style="color: {{ $i <= $pengaduan->rating ? '#fbbf24' : '#fef3c7' }};"></i>
                        @endfor
                    </div>
                    <span style="font-size: 11px; color: #92400e; font-weight: 600;">
                        Dinilai pada: {{ $pengaduan->updated_at->format('d M Y') }}
                    </span>
                </div>

                @if($pengaduan->feedback)
                    <p style="font-size: 13.5px; color: #92400e; line-height: 1.6; font-style: italic;">
                        "{{ $pengaduan->feedback }}"
                    </p>
                @else
                    <p style="font-size: 13px; color: #d97706; font-style: italic;">Tidak ada ulasan tambahan.</p>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

@if(Auth::user()->role === 'mahasiswa')
<div id="feedbackModal" class="sidebar-overlay" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div class="feedback-modal-card">

        <button type="button" onclick="closeFeedbackModal()" style="position: absolute; top: 20px; right: 20px; background: none; border: none; color: #94a3b8; font-size: 20px; cursor: pointer; transition: color 0.2s;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div style="text-align: center; margin-bottom: 25px;">
            <div style="width: 60px; height: 60px; background: #fffbeb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                <i class="fa-solid fa-star" style="font-size: 28px; color: #fbbf24;"></i>
            </div>
            <h3 style="font-size: 20px; font-weight: 700; color: #0d2d6e; margin-bottom: 5px;">Beri Penilaian</h3>
            <p style="color: #64748b; font-size: 13px;">Seberapa puas Anda dengan penanganan pengaduan ini?</p>
        </div>

        <form id="feedbackForm" method="POST" action="">
            @csrf

            <div style="display: flex; justify-content: center; gap: 10px; margin-bottom: 25px; direction: rtl;">
                <input type="radio" id="show_star5" name="rating" value="5" style="display: none;" required/>
                <label for="show_star5" class="star-rating"><i class="fa-solid fa-star"></i></label>
                <input type="radio" id="show_star4" name="rating" value="4" style="display: none;" />
                <label for="show_star4" class="star-rating"><i class="fa-solid fa-star"></i></label>
                <input type="radio" id="show_star3" name="rating" value="3" style="display: none;" />
                <label for="show_star3" class="star-rating"><i class="fa-solid fa-star"></i></label>
                <input type="radio" id="show_star2" name="rating" value="2" style="display: none;" />
                <label for="show_star2" class="star-rating"><i class="fa-solid fa-star"></i></label>
                <input type="radio" id="show_star1" name="rating" value="1" style="display: none;" />
                <label for="show_star1" class="star-rating"><i class="fa-solid fa-star"></i></label>
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

@push('styles')
<style>
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

@push('scripts')
<script>

    function openFeedbackModal(id) {
        document.getElementById('feedbackForm').action = '/pengaduan/' + id + '/feedback';
        document.getElementById('feedbackModal').style.display = 'flex';
        document.getElementById('feedbackForm').reset();
    }

    function closeFeedbackModal() {
        document.getElementById('feedbackModal').style.display = 'none';
    }

    window.addEventListener('click', function(event) {
        if (event.target == document.getElementById('feedbackModal')) {
            closeFeedbackModal();
        }
    });
</script>
@endpush
@endif

@endsection
