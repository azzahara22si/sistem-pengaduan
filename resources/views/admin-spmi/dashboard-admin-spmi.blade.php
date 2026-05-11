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

    <div class="table-card" style="overflow-x: auto;">
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
                        <a href="{{ route('pengaduan.show', $item->id) }}" style="color: #0d2d6e; font-weight: 600; font-size: 11px;">Detail</a>
                        @if($item->status !== 'selesai')
                        <a href="#" style="color: #0d2d6e; font-weight: 600; font-size: 11px; margin-left: 10px;">Salurkan</a>
                        @endif
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

    <div style="margin-top: 25px; display: flex; justify-content: center;">
        {{ $pengaduans->links() }}
    </div>

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
                backgroundColor: ['#f5a623', '#4caf50', '#ef4444', '#4a9eff']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endpush
@endsection
