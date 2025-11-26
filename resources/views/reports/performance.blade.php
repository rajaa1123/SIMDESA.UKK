@extends('layouts.app')

@section('title', 'Laporan Kinerja')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-tachometer-alt me-2"></i>Laporan Kinerja</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Laporan</a></li>
                    <li class="breadcrumb-item active">Laporan Kinerja</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white text-center">
            <div class="card-body">
                <i class="fas fa-concierge-bell fa-3x mb-2"></i>
                <h3 class="mb-0">{{ number_format($stats['total_layanan']) }}</h3>
                <p class="mb-0">Total Layanan</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <i class="fas fa-file-alt fa-3x mb-2"></i>
                <h3 class="mb-0">{{ number_format($stats['total_permohonan']) }}</h3>
                <p class="mb-0">Total Permohonan</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <i class="fas fa-percentage fa-3x mb-2"></i>
                <h3 class="mb-0">{{ number_format($stats['avg_success_rate'], 1) }}%</h3>
                <p class="mb-0">Rata-rata Success Rate</p>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Permohonan per Layanan</h5>
            </div>
            <div class="card-body">
                <canvas id="permohonanChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Success Rate per Layanan</h5>
            </div>
            <div class="card-body">
                <canvas id="successRateChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Performance Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Detail Kinerja Layanan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Layanan</th>
                        <th>Total Permohonan</th>
                        <th>Selesai</th>
                        <th>Success Rate</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($layanans as $index => $layanan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $layanan->nama_layanan }}</strong></td>
                        <td>{{ number_format($layanan->permohonan_count) }}</td>
                        <td>{{ number_format($layanan->selesai) }}</td>
                        <td>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-{{ $layanan->success_rate >= 75 ? 'success' : ($layanan->success_rate >= 50 ? 'warning' : 'danger') }}" 
                                     role="progressbar" 
                                     style="width: {{ $layanan->success_rate }}%"
                                     aria-valuenow="{{ $layanan->success_rate }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ number_format($layanan->success_rate, 1) }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($layanan->success_rate >= 75)
                                <span class="badge bg-success">Excellent</span>
                            @elseif($layanan->success_rate >= 50)
                                <span class="badge bg-warning">Good</span>
                            @else
                                <span class="badge bg-danger">Need Improvement</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data layanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Permohonan Chart (Bar)
    const permohonanCtx = document.getElementById('permohonanChart').getContext('2d');
    new Chart(permohonanCtx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($layanans as $layanan)
                    '{{ $layanan->nama_layanan }}',
                @endforeach
            ],
            datasets: [{
                label: 'Total Permohonan',
                data: [
                    @foreach($layanans as $layanan)
                        {{ $layanan->permohonan_count }},
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
    
    // Success Rate Chart (Bar)
    const successRateCtx = document.getElementById('successRateChart').getContext('2d');
    new Chart(successRateCtx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($layanans as $layanan)
                    '{{ $layanan->nama_layanan }}',
                @endforeach
            ],
            datasets: [{
                label: 'Success Rate (%)',
                data: [
                    @foreach($layanans as $layanan)
                        {{ number_format($layanan->success_rate, 2) }},
                    @endforeach
                ],
                backgroundColor: function(context) {
                    const value = context.parsed.y;
                    if (value >= 75) return 'rgba(25, 135, 84, 0.8)';
                    if (value >= 50) return 'rgba(255, 193, 7, 0.8)';
                    return 'rgba(220, 53, 69, 0.8)';
                },
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Success Rate: ' + context.parsed.y.toFixed(1) + '%';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
