@extends('layouts.main-dashboard')

@section('title', Auth::user()->role === 'mahasiswa' ? 'Daftar Pengaduan Anda' : 'Kelola Pengaduan Masuk')

@push('styles')
<style>
    .page-header {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 25px;
    }

    .header-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .page-title {
        font-size: 20px;
        font-weight: 700;
        color: #1a2340;
    }

    .filter-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-select, .filter-date {
        height: 38px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0 12px;
        font-size: 13px;
        font-family: 'Poppins', sans-serif;
        color: #64748b;
        background: #fff;
        outline: none;
    }

    .search-wrap {
        display: flex;
        align-items: center;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        height: 38px;
        background: #fff;
        padding-left: 15px;
        margin-left: auto;
    }

    .search-wrap input {
        border: none;
        outline: none;
        padding: 0 10px;
        font-size: 13px;
        font-family: 'Poppins', sans-serif;
        width: 200px;
    }

    .search-wrap button {
        background: none;
        border: none;
        padding: 0 15px;
        color: #64748b;
        cursor: pointer;
    }

    .btn-create {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #0d428e;
        color: #fff;
        border: none;
        border-radius: 20px;
        padding: 8px 20px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-create:hover {
        background: #093470;
        transform: translateY(-2px);
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: capitalize;
    }
    .status-menunggu { background: #fef3c7; color: #92400e; }
    .status-proses { background: #dbeafe; color: #1e40af; }
    .status-selesai { background: #dcfce7; color: #166534; }

    .klasifikasi-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: capitalize;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .klasifikasi-pengaduan { background: #fee2e2; color: #991b1b; }
    .klasifikasi-aspirasi { background: #fef3c7; color: #92400e; }
    .klasifikasi-permintaan_informasi { background: #dbeafe; color: #1e40af; }

    .action-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-action {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: none;
        cursor: pointer;
    }

    .btn-detail {
        background: #eff6ff;
        color: #1e40af;
    }
    .btn-detail:hover {
        background: #dbeafe;
        transform: translateY(-1px);
    }

    .btn-salurkan {
        background: #ecfdf5;
        color: #065f46;
    }
    .btn-salurkan:hover {
        background: #d1fae5;
        transform: translateY(-1px);
    }

    .btn-hapus {
        background: #fef2f2;
        color: #991b1b;
    }
    .btn-hapus:hover {
        background: #fee2e2;
        transform: translateY(-1px);
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        gap: 8px;
        align-items: center;
    }

    .pagination li a, .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: 10px;
        background: #fff;
        border: 1.5px solid #e2e8f0;
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .pagination li.active span {
        background: #0d428e;
        color: #fff;
        border-color: #0d428e;
    }

    .pagination li a:hover {
        border-color: #0d428e;
        color: #0d428e;
        background: #f0f7ff;
    }

    .pagination li.disabled span {
        background: #f8fafc;
        color: #cbd5e1;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .header-top {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .btn-create {
            width: 100%;
            justify-content: center;
        }

        .filter-bar {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .filter-select, .filter-date, .search-wrap {
            width: 100% !important;
            margin-left: 0 !important;
        }

        .search-wrap input {
            width: 100%;
        }

        .modal-content {
            width: 90% !important;
            padding: 20px !important;
        }
    }
</style>
@endpush

@section('content')
    <div class="page-header">
        <div class="header-top">
            <h2 class="page-title">{{ Auth::user()->role === 'mahasiswa' ? 'Daftar Pengaduan Anda' : 'Kelola Pengaduan Masuk' }}</h2>
            @if(Auth::user()->role === 'mahasiswa')
            <a href="{{ route('pengaduan.create') }}" class="btn-create">
                <i class="fa-solid fa-plus"></i> Buat Pengaduan
            </a>
            @endif
        </div>

        <form action="{{ route('pengaduan.index') }}" method="GET" class="filter-bar">
            @if(Auth::user()->role !== 'mahasiswa')
            <select name="unit" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Unit</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->nama_unit }}" {{ request('unit') == $unit->nama_unit ? 'selected' : '' }}>
                        {{ $unit->nama_unit }}
                    </option>
                @endforeach
            </select>
            @endif

            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>

            <input type="date" name="date" class="filter-date" value="{{ request('date') }}" onchange="this.form.submit()">

            <div class="search-wrap">
                <input type="text" name="search" placeholder="Cari pengaduan..." value="{{ request('search') }}">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>

            @if(request()->anyFilled(['unit', 'status', 'date', 'search']))
                <a href="{{ route('pengaduan.index') }}" style="font-size: 12px; color: #ef4444; text-decoration: none; font-weight: 600; margin-left: 10px;">
                    <i class="fa-solid fa-xmark"></i> Reset
                </a>
            @endif
        </form>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px 20px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 600;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fef2f2; color: #b91c1c; padding: 12px 20px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 600;">
            <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
        </div>
    @endif

    <div class="table-card" style="overflow-x: auto;">
        <div style="min-width: 800px;">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Judul Aduan</th>
                        @if(Auth::user()->role !== 'mahasiswa')
                        <th>Pengirim</th>
                        @endif
                        <th>Klasifikasi</th>
                        <th>
                            @php
                                $klasifikasi = $p->klasifikasi ?? 'pengaduan';
                                $icons = [
                                    'pengaduan' => 'fa-exclamation-circle',
                                    'aspirasi' => 'fa-lightbulb',
                                    'permintaan_informasi' => 'fa-circle-info'
                                ];
                                $labels = [
                                    'pengaduan' => 'Pengaduan',
                                    'aspirasi' => 'Aspirasi',
                                    'permintaan_informasi' => 'Informasi'
                                ];
                            @endphp
                            <span class="klasifikasi-badge klasifikasi-{{ $klasifikasi }}">
                                <i class="fa-solid {{ $icons[$klasifikasi] }}"></i>
                                {{ $labels[$klasifikasi] }}
                            </span>
                        </td>
                        <td>Unit Tujuan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduans as $index => $p)
                    <tr>
                        <td>{{ ($pengaduans->currentPage() - 1) * $pengaduans->perPage() + $index + 1 }}</td>
                        <td style="font-weight: 600; color: #0d2d6e;">{{ $p->judul }}</td>
                        @if(Auth::user()->role !== 'mahasiswa')
                        <td style="font-size: 12px;">{{ $p->user->name ?? 'Mahasiswa' }}</td>
                        @endif
                        <td>{{ $p->unit_tujuan }}</td>
                        <td style="font-size: 12px;">{{ $p->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($p->status) }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <div class="action-group">
                                <a href="{{ route('pengaduan.show', $p->id) }}" class="btn-action btn-detail">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </a>

                                @if(Auth::user()->role === 'admin_spmi' && $p->status === 'menunggu')
                                    <button type="button" class="btn-action btn-salurkan" onclick="openSalurkanModal({{ $p->id }}, '{{ $p->judul }}')">
                                        <i class="fa-solid fa-share-nodes"></i> Salurkan
                                    </button>
                                @endif

                                @if(Auth::user()->role === 'mahasiswa' && $p->status === 'menunggu')
                                    <a href="{{ route('pengaduan.edit', $p->id) }}" class="btn-action btn-edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <button type="button" class="btn-action btn-hapus" onclick="openDeleteModal({{ $p->id }}, '{{ $p->judul }}')">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                @endif

                                @if(Auth::user()->role === 'mahasiswa' && $p->status === 'selesai')
                                    @if(is_null($p->rating))
                                        <button type="button" class="btn-action" style="background-color: #f59e0b; color: white; border-color: #f59e0b;" onclick="openFeedbackModal({{ $p->id }})">
                                            <i class="fa-solid fa-star"></i> Nilai
                                        </button>
                                    @else
                                        <div style="color: #f59e0b; font-size: 12px; display: flex; gap: 2px; padding: 6px 12px; border: 1px solid #fde68a; border-radius: 8px; background: #fffbeb;" title="Rating: {{ $p->rating }}/5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star" style="color: {{ $i <= $p->rating ? '#f59e0b' : '#fcd34d' }};"></i>
                                            @endfor
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ Auth::user()->role === 'mahasiswa' ? 6 : 7 }}" style="text-align: center; padding: 40px; color: #94a3b8;">
                            <i class="fa-solid fa-folder-open" style="font-size: 30px; display: block; margin-bottom: 10px;"></i>
                            Belum ada data pengaduan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 25px; display: flex; justify-content: center;">
        {{ $pengaduans->links() }}
    </div>

    @if(Auth::user()->role === 'admin_spmi')
    <div id="modalSalurkan" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div class="modal-content" style="background: #fff; width: 400px; padding: 30px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); animation: slideUp 0.3s ease;">
            <h3 style="font-size: 18px; font-weight: 700; color: #0d2d6e; margin-bottom: 10px;">Salurkan Pengaduan</h3>
            <p id="salurkan_text" style="font-size: 13px; color: #64748b; margin-bottom: 25px;"></p>

            <form id="formSalurkan" method="POST">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 8px;">Pilih Unit Layanan</label>
                    <select name="unit_id" required style="width: 100%; height: 42px; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 0 15px; font-family: 'Poppins'; outline: none; background: #f8fafc;">
                        <option value="">-- Pilih Unit --</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="closeSalurkanModal()" style="flex: 1; height: 44px; border: none; border-radius: 10px; background: #f1f5f9; color: #64748b; font-weight: 600; cursor: pointer;">Batal</button>
                    <button type="submit" style="flex: 1; height: 44px; border: none; border-radius: 10px; background: #0d428e; color: #fff; font-weight: 700; cursor: pointer;">Salurkan Sekarang</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if(Auth::user()->role === 'mahasiswa')
    <div id="modalDelete" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div class="modal-content" style="background: #fff; width: 380px; padding: 30px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); animation: slideUp 0.3s ease; text-align: center;">
            <div style="width: 60px; height: 60px; background: #fef2f2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <i class="fa-solid fa-trash-can" style="font-size: 24px; color: #ef4444;"></i>
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #0d2d6e; margin-bottom: 10px;">Hapus Pengaduan?</h3>
            <p id="delete_text" style="font-size: 13px; color: #64748b; margin-bottom: 25px;"></p>

            <form id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="closeDeleteModal()" style="flex: 1; height: 44px; border: none; border-radius: 10px; background: #f1f5f9; color: #64748b; font-weight: 600; cursor: pointer;">Batal</button>
                    <button type="submit" style="flex: 1; height: 44px; border: none; border-radius: 10px; background: #ef4444; color: #fff; font-weight: 700; cursor: pointer;">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if(Auth::user()->role === 'mahasiswa')
    <div id="feedbackModal" class="sidebar-overlay" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div style="background: white; width: 100%; max-width: 500px; border-radius: 16px; padding: 30px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); position: relative; animation: slideUp 0.3s ease;">

            <button type="button" onclick="closeFeedbackModal()" style="position: absolute; top: 20px; right: 20px; background: none; border: none; color: #94a3b8; font-size: 20px; cursor: pointer; transition: color 0.2s;">
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
                    <input type="radio" id="idx_star5" name="rating" value="5" style="display: none;" required/>
                    <label for="idx_star5" class="star-rating"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" id="idx_star4" name="rating" value="4" style="display: none;" />
                    <label for="idx_star4" class="star-rating"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" id="idx_star3" name="rating" value="3" style="display: none;" />
                    <label for="idx_star3" class="star-rating"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" id="idx_star2" name="rating" value="2" style="display: none;" />
                    <label for="idx_star2" class="star-rating"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" id="idx_star1" name="rating" value="1" style="display: none;" />
                    <label for="idx_star1" class="star-rating"><i class="fa-solid fa-star"></i></label>
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
    </style>
    @endif

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

        function openSalurkanModal(id, judul) {
            document.getElementById('salurkan_text').innerHTML = `Salurkan pengaduan <strong>"${judul}"</strong> ke unit yang berwenang untuk ditindaklanjuti.`;
            document.getElementById('formSalurkan').action = `/pengaduan/${id}/salurkan`;
            document.getElementById('modalSalurkan').style.display = 'flex';
        }

        function closeSalurkanModal() {
            document.getElementById('modalSalurkan').style.display = 'none';
        }

        function openDeleteModal(id, judul) {
            document.getElementById('delete_text').innerHTML = `Apakah Anda yakin ingin menghapus aduan <strong>"${judul}"</strong>? Tindakan ini tidak dapat dibatalkan.`;
            document.getElementById('formDelete').action = `/pengaduan/${id}`;
            document.getElementById('modalDelete').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('modalDelete').style.display = 'none';
        }

        window.addEventListener('click', function(event) {
            if (event.target == document.getElementById('modalSalurkan')) {
                closeSalurkanModal();
            }
            if (event.target == document.getElementById('modalDelete')) {
                closeDeleteModal();
            }
            if (event.target == document.getElementById('feedbackModal')) {
                closeFeedbackModal();
            }
        });
    </script>
    <style>
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
    @endpush
@endsection