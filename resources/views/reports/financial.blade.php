@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-dollar-sign me-2"></i>Laporan Keuangan</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Laporan</a></li>
                    <li class="breadcrumb-item active">Laporan Keuangan</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Filter Panel -->
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('reports.financial') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <i class="fas fa-money-bill-wave fa-3x mb-2"></i>
                <h3 class="mb-0">Rp {{ number_format($stats['total'], 0, ',', '.') }}</h3>
                <p class="mb-0">Total Pendapatan</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <i class="fas fa-calendar-day fa-3x mb-2"></i>
                <h3 class="mb-0">Rp {{ number_format($stats['bulan_ini'], 0, ',', '.') }}</h3>
                <p class="mb-0">Pendapatan Bulan Ini</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white text-center">
            <div class="card-body">
                <i class="fas fa-chart-line fa-3x mb-2"></i>
                <h3 class="mb-0">Rp {{ number_format($stats['rata_rata'], 0, ',', '.') }}</h3>
                <p class="mb-0">Rata-rata per Permohonan</p>
            </div>
        </div>
    </div>
</div>

<!-- Trend Chart -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Trend Pendapatan (6 Bulan Terakhir)</h5>
    </div>
    <div class="card-body">
        <canvas id="trendChart" height="80"></canvas>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Detail Transaksi</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Permohonan</th>
                        <th>Pemohon</th>
                        <th>Layanan</th>
                        <th>Biaya Admin</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($financials as $index => $finance)
                    <tr>
                        <td>{{ $financials->firstItem() + $index }}</td>
                        <td><strong>{{ $finance->nomor_permohonan }}</strong></td>
                        <td>{{ $finance->user->name }}</td>
                        <td>{{ $finance->layanan->nama_layanan }}</td>
                        <td><strong class="text-success">Rp {{ number_format($finance->biaya_admin, 0, ',', '.') }}</strong></td>
                        <td>{{ $finance->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $financials->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Trend Chart (Line)
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    
    const bulanNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: [
                @foreach($pendapatanPerBulan as $item)
                    '{{ $bulanNames[$item->bulan - 1] }} {{ $item->tahun }}',
                @endforeach
            ],
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: [
                    @foreach($pendapatanPerBulan as $item)
                        {{ $item->total }},
                    @endforeach
                ],
                borderColor: 'rgba(25, 135, 84, 1)',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
