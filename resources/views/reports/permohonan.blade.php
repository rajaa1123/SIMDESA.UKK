@extends('layouts.app')

@section('title', 'Laporan Permohonan')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-file-alt me-2"></i>Laporan Permohonan</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Laporan</a></li>
                    <li class="breadcrumb-item active">Laporan Permohonan</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Filter Panel -->
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('reports.permohonan') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status_id" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                            {{ ucfirst($status->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Layanan</label>
                <select name="layanan_id" class="form-select">
                    <option value="">Semua Layanan</option>
                    @foreach($layanans as $layanan)
                        <option value="{{ $layanan->id }}" {{ request('layanan_id') == $layanan->id ? 'selected' : '' }}>
                            {{ $layanan->nama_layanan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
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
    <div class="col-md">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary mb-0">{{ number_format($stats['total']) }}</h3>
                <p class="text-muted mb-0">Total</p>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning mb-0">{{ number_format($stats['pending']) }}</h3>
                <p class="text-muted mb-0">Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info mb-0">{{ number_format($stats['diproses']) }}</h3>
                <p class="text-muted mb-0">Diproses</p>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success mb-0">{{ number_format($stats['selesai']) }}</h3>
                <p class="text-muted mb-0">Selesai</p>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-danger mb-0">{{ number_format($stats['ditolak']) }}</h3>
                <p class="text-muted mb-0">Ditolak</p>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Distribusi Status Permohonan</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Permohonan per Layanan</h5>
            </div>
            <div class="card-body">
                <canvas id="layananChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Detail Permohonan</h5>
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
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permohonans as $index => $permohonan)
                    <tr>
                        <td>{{ $permohonans->firstItem() + $index }}</td>
                        <td><strong>{{ $permohonan->nomor_permohonan }}</strong></td>
                        <td>{{ $permohonan->user->name }}</td>
                        <td>{{ $permohonan->layanan->nama_layanan }}</td>
                        <td>
                            <span class="badge bg-{{ $permohonan->status->code == 'selesai' ? 'success' : ($permohonan->status->code == 'ditolak' ? 'danger' : ($permohonan->status->code == 'diproses' ? 'info' : 'warning')) }}">
                                {{ ucfirst($permohonan->status->name) }}
                            </span>
                        </td>
                        <td>{{ $permohonan->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data permohonan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $permohonans->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Status Chart (Pie)
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: ['Pending', 'Diproses', 'Selesai', 'Ditolak'],
            datasets: [{
                data: [
                    {{ $stats['pending'] }},
                    {{ $stats['diproses'] }},
                    {{ $stats['selesai'] }},
                    {{ $stats['ditolak'] }}
                ],
                backgroundColor: [
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(13, 202, 240, 0.8)',
                    'rgba(25, 135, 84, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    
    // Layanan Chart (Bar)
    const layananCtx = document.getElementById('layananChart').getContext('2d');
    new Chart(layananCtx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($perLayanan as $item)
                    '{{ $item->layanan->nama_layanan }}',
                @endforeach
            ],
            datasets: [{
                label: 'Jumlah Permohonan',
                data: [
                    @foreach($perLayanan as $item)
                        {{ $item->total }},
                    @endforeach
                ],
                backgroundColor: 'rgba(13, 110, 253, 0.8)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush
