@extends('layouts.main-dashboard')

@section('title', 'Dashboard Admin SPMI')

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

    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-bottom: 40px;">
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
            <div style="min-width: 800px;">
                <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Aduan</th>
                    <th>Kategori Aduan</th>
                    <th>Tanggal</th>
                    <th>Solusi</th>
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
                    <td><a href="{{ route('pengaduan.show', $item->id) }}" style="color: #0d2d6e; font-weight: 600;">Detail</a></td>
                    <td>
                        <span style="background: {{ $item->status === 'selesai' ? '#dcfce7' : '#e2e8f0' }}; 
                                     color: {{ $item->status === 'selesai' ? '#166534' : '#64748b' }}; 
                                     padding: 4px 10px; border-radius: 10px; font-size: 11px; text-transform: capitalize;">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <a href="{{ route('pengaduan.show', $item->id) }}" style="color: #0d2d6e; font-weight: 600; font-size: 11px;">Detail</a>
                            @if($item->status !== 'selesai')
                            <a href="#" onclick="openSalurkanModal({{ $item->id }}, {!! json_encode($item->judul) !!}); return false;" style="color: #0d2d6e; font-weight: 600; font-size: 11px;">Salurkkan</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #94a3b8;">Belum ada pengaduan masuk.</td>
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
                    <label style="display: block; font-size: clamp(11px, 2vw, 12px); font-weight: 600; color: #334155; margin-bottom: 8px;">Pilih Unit Layanan</label>
                    <select name="unit_id" required style="width: 100%; height: clamp(36px, 8vh, 42px); border: 1.5px solid #e2e8f0; border-radius: clamp(8px, 1.5vw, 12px); padding: 0 clamp(10px, 2vw, 15px); font-family: 'Poppins'; outline: none; background: #f8fafc; font-size: clamp(11px, 2vw, 13px);">
                        <option value="">-- Pilih Unit --</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: flex; gap: clamp(8px, 2vw, 10px); flex-wrap: wrap;">
                    <button type="button" onclick="closeSalurkanModal()" style="flex: 1; min-width: 100px; height: clamp(36px, 8vh, 44px); border: none; border-radius: clamp(8px, 1.5vw, 10px); background: #f1f5f9; color: #64748b; font-weight: 600; cursor: pointer; font-size: clamp(11px, 2vw, 13px);">Batal</button>
                    <button type="submit" style="flex: 1; min-width: 100px; height: clamp(36px, 8vh, 44px); border: none; border-radius: clamp(8px, 1.5vw, 10px); background: #0d428e; color: #fff; font-weight: 700; cursor: pointer; font-size: clamp(11px, 2vw, 13px);">Salurkan Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    <style>
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
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($statusStats->pluck('status')) !!},
            datasets: [{
                data: {!! json_encode($statusStats->pluck('total')) !!},
                backgroundColor: ['#f5a623', '#ef4444', '#4caf50', '#4a9eff']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    function openSalurkanModal(id, judul) {
        document.getElementById('salurkan_text').innerHTML = `Salurkan pengaduan <strong>"${judul}"</strong> ke unit yang berwenang untuk ditindaklanjuti.`;
        document.getElementById('formSalurkan').action = `/pengaduan/${id}/salurkan`;
        document.getElementById('modalSalurkan').style.display = 'flex';
    }

    function closeSalurkanModal() {
        document.getElementById('modalSalurkan').style.display = 'none';
    }

    window.addEventListener('click', function(event) {
        if (event.target == document.getElementById('modalSalurkan')) {
            closeSalurkanModal();
        }
    });
</script>
@endpush
@endsection
