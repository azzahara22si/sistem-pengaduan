@extends('layouts.main-dashboard')

@section('title', 'Beranda Admin SPMI')

@section('content')

    <div class="welcome-card">
        <div class="welcome-text">
            <h3>Selamat Datang!, {{ Auth::user()->name }}</h3>
            <p>Admin SPMI</p>
        </div>
        <div class="welcome-icon">
            <i class="fa-solid fa-desktop" style="color: #0d2d6e;"></i>
        </div>
    </div>

    <style>
        .status-badge {
            padding: clamp(4px, 1vw, 6px) clamp(8px, 2vw, 12px);
            border-radius: clamp(8px, 1.5vw, 12px);
            font-size: clamp(9px, 1.8vw, 11px);
            font-weight: 600;
            text-transform: capitalize;
            display: inline-block;
        }
        .status-diajukan { background: #fef3c7; color: #92400e; }
        .status-proses { background: #fff7ed; color: #f97316; }
        .status-selesai { background: #dcfce7; color: #166534; }

        .action-group {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 76px;
            margin: 0 auto;
        }

        .action-group--completed {
            justify-content: flex-start;
        }

        .table-card table th,
        .table-card table td {
            vertical-align: middle !important;
        }

        .table-card table th:last-child,
        .table-card table td:last-child {
            width: 100px;
            text-align: center;
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            background: #eff6ff;
            color: #1e40af;
            padding: 0;
        }
        .btn-action:hover {
            transform: translateY(-1px);
        }

        .btn-detail {
            background: #eff6ff;
            color: #1e40af;
        }
        .btn-salurkan {
            background: #ecfdf5;
            color: #065f46;
        }
        .btn-salurkan:hover {
            background: #d1fae5;
        }
        .btn-ubah-saluran {
            background: #fff7ed;
            color: #c2410c;
        }
        .btn-ubah-saluran:hover {
            background: #ffedd5;
        }
    </style>

    <div class="stats-grid admin-chart-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-bottom: 40px;">
        <div class="table-card">
            <h4 class="card-title">Jumlah pengaduan per unit layanan</h4>
            <div style="height: 250px;">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="table-card">
            <h4 class="card-title">Proporsi pengaduan berdasarkan kategori</h4>
            <div style="height: 250px;">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <div class="admin-table-inner" style="min-width: 800px;">
                <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Aduan</th>
                    <th>Unit Tujuan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengaduans ?? [] as $index => $item)
                <tr>
                    <td>{{ ($pengaduans->currentPage() - 1) * $pengaduans->perPage() + $index + 1 }}</td>
                    <td style="font-weight: 600;">{{ $item->judul }}</td>
                    <td>{{ $item->unit_tujuan }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>
                        @php
                            $statusClass = 'status-diajukan';
                            $statusValue = strtolower($item->status ?? 'diajukan');
                            if ($statusValue === 'proses') {
                                $statusClass = 'status-proses';
                            } elseif ($statusValue === 'selesai') {
                                $statusClass = 'status-selesai';
                            }
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ ucfirst($statusValue) }}</span>
                    </td>
                    <td>
                        <div class="action-group {{ $item->status === 'selesai' ? 'action-group--completed' : '' }}">
                            <a href="{{ route('pengaduan.show', $item->id) }}" class="btn-action btn-detail" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @if($item->canBeReassigned())
                                @php($isInitialDistribution = strtolower($item->status) === 'diajukan')
                                <button type="button" class="btn-action btn-salurkan {{ $isInitialDistribution ? '' : 'btn-ubah-saluran' }}" data-id="{{ $item->id }}" data-judul="{{ $item->judul }}" data-status="{{ strtolower($item->status) }}" title="{{ $isInitialDistribution ? 'Salurkan pengaduan' : 'Ubah saluran pengaduan' }}">
                                    <i class="fa-solid {{ $isInitialDistribution ? 'fa-paper-plane' : 'fa-right-left' }}"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #94a3b8;">Belum ada pengaduan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
            </div>
        </div>
    </div>

    <div style="margin-top: clamp(15px, 3vw, 25px); display: flex; justify-content: center;">
        {{ $pengaduans->links() }}
    </div>

    <div id="modalSalurkan" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: clamp(10px, 2vw, 20px);">
        <div class="modal-content" style="background: #fff; width: calc(100vw - 30px); max-width: 420px; padding: clamp(20px, 3vw, 30px); border-radius: clamp(12px, 2vw, 20px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); animation: slideUp 0.3s ease;">
            <h3 style="font-size: clamp(16px, 4vw, 18px); font-weight: 700; color: #0d2d6e; margin-bottom: 10px;">Salurkan Pengaduan</h3>
            <p id="salurkan_text" style="font-size: clamp(11px, 2vw, 13px); color: #64748b; margin-bottom: clamp(15px, 3vw, 25px);"></p>

            <form id="formSalurkan" method="POST">
                @csrf
                <div style="margin-bottom: clamp(15px, 3vw, 20px);">
                    <label style="display: block; font-size: clamp(11px, 2vw, 12px); font-weight: 600; color: #334155; margin-bottom: 8px;">Unit tujuan untuk pelimpahan</label>
                    <select name="unit_id" required style="width: 100%; height: clamp(36px, 8vh, 42px); border: 1.5px solid #e2e8f0; border-radius: clamp(8px, 1.5vw, 12px); padding: 0 clamp(10px, 2vw, 15px); font-family: 'Poppins'; outline: none; background: #f8fafc; font-size: clamp(11px, 2vw, 13px);">
                        <option value="">-- Pilih Unit --</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                    <p style="margin-top: 10px; color: #475569; font-size: 12px; line-height: 1.5;">Pilih unit yang akan menerima pengaduan ini untuk proses lebih lanjut.</p>
                </div>

                <div style="display: flex; gap: clamp(8px, 2vw, 10px); flex-wrap: wrap;">
                    <button type="button" onclick="closeSalurkanModal()" style="flex: 1; min-width: 100px; height: clamp(36px, 8vh, 44px); border: none; border-radius: clamp(8px, 1.5vw, 10px); background: #f1f5f9; color: #64748b; font-weight: 600; cursor: pointer; font-size: clamp(11px, 2vw, 13px);">Batal</button>
                    <button type="submit" style="flex: 1; min-width: 100px; height: clamp(36px, 8vh, 44px); border: none; border-radius: clamp(8px, 1.5vw, 10px); background: #0d428e; color: #fff; font-weight: 700; cursor: pointer; font-size: clamp(11px, 2vw, 13px);">Salurkan Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            .admin-chart-grid {
                grid-template-columns: minmax(0, 1fr) !important;
                gap: 15px !important;
                margin-bottom: 20px !important;
            }

            .admin-table-inner {
                min-width: 680px !important;
            }
        }

        @media (max-width: 640px) {
            .modal-content {
                width: calc(100vw - 20px) !important;
            }
        }
    </style>

@push('scripts')
<script>

    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($unitStats->pluck('unit_tujuan')) !!},
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: {!! json_encode($unitStats->pluck('total')) !!},
                backgroundColor: '#4a9eff',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });

    const pieCtx = document.getElementById('pieChart').getContext('2d');
    const statusLabels = {!! json_encode($statusStats->pluck('status')) !!};
    const statusTotals = {!! json_encode($statusStats->pluck('total')) !!};
    const statusColorMap = {
        'diajukan': '#fbbf24', // brighter yellow
        'proses': '#f97316',   // orange
        'selesai': '#10b981'   // green
    };
    const pieColors = statusLabels.map(s => statusColorMap[String(s).toLowerCase()] ?? '#4a9eff');

    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusTotals,
                backgroundColor: pieColors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    function openSalurkanModal(id, judul, status) {
        const text = status === 'proses'
            ? `Ubah penyaluran untuk pengaduan <strong>"${judul}"</strong>. Pastikan unit tujuan sudah benar sebelum melanjutkan.`
            : `Salurkan pengaduan <strong>"${judul}"</strong> ke unit yang berwenang untuk ditindaklanjuti.`;
        document.getElementById('salurkan_text').innerHTML = text;
        document.getElementById('formSalurkan').action = `{{ url('pengaduan') }}/${id}/salurkan`;
        document.getElementById('modalSalurkan').style.display = 'flex';
    }

    function closeSalurkanModal() {
        document.getElementById('modalSalurkan').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const salurkanButtons = document.querySelectorAll('.btn-salurkan');
        salurkanButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const judul = this.getAttribute('data-judul');
                const status = this.getAttribute('data-status');
                openSalurkanModal(id, judul, status);
            });
        });
    });

    window.addEventListener('click', function(event) {
        if (event.target == document.getElementById('modalSalurkan')) {
            closeSalurkanModal();
        }
    });
</script>
@endpush
@endsection
