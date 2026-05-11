@extends('layouts.main-dashboard')

@section('title', 'Riwayat Tanggapan')

@section('content')
<div style="margin-bottom: 30px;">
    <h2 style="font-size: 24px; font-weight: 700; color: #0d2d6e; margin-bottom: 5px;">Riwayat Pengaduan</h2>
    <p style="color: #64748b; font-size: 14px;">
        @if(Auth::user()->role === 'admin')
            Daftar semua pengaduan yang telah selesai ditangani oleh unit {{ Auth::user()->unit->nama_unit ?? '' }}.
        @else
            Daftar semua pengaduan Anda yang telah selesai diproses.
        @endif
    </p>
</div>

<div class="table-card" style="overflow-x: auto;">
    <div style="min-width: 900px;">
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Judul Aduan</th>
                    <th>Pelapor</th>
                    <th>Tanggal Selesai</th>
                    <th>Urgensi</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengaduans as $index => $item)
                <tr>
                    <td style="color: #94a3b8; font-weight: 600;">{{ ($pengaduans->currentPage() - 1) * $pengaduans->perPage() + $index + 1 }}</td>
                    <td>
                        <div style="font-weight: 700; color: #0d2d6e;">{{ $item->judul }}</div>
                        <div style="font-size: 11px; color: #94a3b8;">ID: #ADU-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 600;">{{ $item->user->name }}</div>
                        <div style="font-size: 11px; color: #94a3b8;">{{ $item->user->email }}</div>
                    </td>
                    <td>
                        <div style="font-size: 13px;">{{ $item->updated_at->format('d M Y') }}</div>
                        <div style="font-size: 11px; color: #94a3b8;">{{ $item->updated_at->format('H:i') }} WIB</div>
                    </td>
                    <td>
                        <span style="padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; 
                                     background: {{ $item->urgensi === 'tinggi' ? '#fef2f2' : ($item->urgensi === 'sedang' ? '#fffbeb' : '#f0f9ff') }};
                                     color: {{ $item->urgensi === 'tinggi' ? '#ef4444' : ($item->urgensi === 'sedang' ? '#f59e0b' : '#3b82f6') }};">
                            {{ ucfirst($item->urgensi) }}
                        </span>
                    </td>
                    <td>
                        <span style="background: #dcfce7; color: #15803d; padding: 5px 12px; border-radius: 10px; font-size: 11px; font-weight: 700; text-transform: uppercase; border: 1px solid #bbf7d0;">
                            Selesai
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                            <a href="{{ route('pengaduan.show', $item->id) }}" style="padding: 6px 12px; background: #f0f7ff; color: #0d428e; border-radius: 8px; font-size: 11px; font-weight: 700; text-decoration: none; border: 1px solid #dbeafe; transition: all 0.2s;">
                                <i class="fa-solid fa-eye" style="margin-right: 4px;"></i> Detail
                            </a>
                            @if(Auth::user()->role === 'mahasiswa')
                                @if(is_null($item->rating))
                                    <button onclick="openFeedbackModal({{ $item->id }})" style="padding: 6px 12px; background: #f59e0b; color: white; border-radius: 8px; font-size: 11px; font-weight: 700; text-decoration: none; border: none; cursor: pointer; transition: all 0.2s;">
                                        <i class="fa-solid fa-star" style="margin-right: 4px;"></i> Nilai
                                    </button>
                                @else
                                    <div style="color: #f59e0b; font-size: 12px; display: flex; gap: 2px;" title="Rating: {{ $item->rating }}/5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star" style="color: {{ $i <= $item->rating ? '#f59e0b' : '#e2e8f0' }};"></i>
                                        @endfor
                                    </div>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 50px 0;">
                        <div style="margin-bottom: 15px;">
                            <i class="fa-solid fa-folder-open" style="font-size: 48px; color: #e2e8f0;"></i>
                        </div>
                        <div style="color: #64748b; font-weight: 600;">Belum ada riwayat pengaduan selesai.</div>
                        <div style="font-size: 12px; color: #94a3b8;">Hanya pengaduan dengan status 'Selesai' yang akan muncul di sini.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 30px; display: flex; justify-content: center;">
    {{ $pengaduans->links() }}
</div>

<div id="feedbackModal" class="sidebar-overlay" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: white; width: 100%; max-width: 500px; border-radius: 16px; padding: 30px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); position: relative; animation: slideUp 0.3s ease;">

        <button onclick="closeFeedbackModal()" style="position: absolute; top: 20px; right: 20px; background: none; border: none; color: #94a3b8; font-size: 20px; cursor: pointer; transition: color 0.2s;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div style="text-align: center; margin-bottom: 25px;">
            <div style="width: 60px; height: 60px; background: #fffbeb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                <i class="fa-solid fa-star" style="font-size: 28px; color: #f59e0b;"></i>
            </div>
            <h3 style="font-size: 20px; font-weight: 700; color: #0d2d6e; margin-bottom: 5px;">Beri Penilaian</h3>
            <p style="color: #64748b; font-size: 13px;">Seberapa puas Anda dengan penanganan pengaduan ini?</p>
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
        color: #f59e0b;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

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

@endsection
