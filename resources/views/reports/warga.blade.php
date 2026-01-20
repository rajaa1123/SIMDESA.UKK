@extends('layouts.app')

@section('title', 'Laporan Warga')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-users me-2"></i>Laporan Warga</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Laporan</a></li>
                    <li class="breadcrumb-item active">Laporan Warga</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white text-center">
            <div class="card-body">
                <i class="fas fa-users fa-3x mb-2"></i>
                <h3 class="mb-0">{{ number_format($stats['total_warga']) }}</h3>
                <p class="mb-0">Total Warga</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <i class="fas fa-address-card fa-3x mb-2"></i>
                <h3 class="mb-0">{{ number_format($stats['total_kk']) }}</h3>
                <p class="mb-0">Kartu Keluarga</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <i class="fas fa-male fa-3x mb-2"></i>
                <h3 class="mb-0">{{ number_format($stats['warga_laki']) }}</h3>
                <p class="mb-0">Laki-laki</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white text-center">
            <div class="card-body">
                <i class="fas fa-female fa-3x mb-2"></i>
                <h3 class="mb-0">{{ number_format($stats['warga_perempuan']) }}</h3>
                <p class="mb-0">Perempuan</p>
            </div>
        </div>
    </div>
</div>

<!-- Chart -->
<div class="row mb-4">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Distribusi Jenis Kelamin</h5>
            </div>
            <div class="card-body">
                <canvas id="genderChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Data Warga</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>No KK</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wargas as $index => $warga)
                    <tr>
                        <td>{{ $wargas->firstItem() + $index }}</td>
                        <td>{{ $warga->nik }}</td>
                        <td><strong>{{ $warga->nama }}</strong></td>
                        <td>
                            @if($warga->jenis_kelamin == 'Laki-laki')
                                <span class="badge bg-primary">
                                    <i class="fas fa-male me-1"></i>Laki-laki
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-female me-1"></i>Perempuan
                                </span>
                            @endif
                        </td>
                        <td>{{ $warga->tempat_lahir }}, {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->format('d M Y') }}</td>
                        <td>{{ $warga->kartuKeluarga->nomor_kk ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data warga</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $wargas->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gender Distribution Chart (Pie)
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'pie',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [
                    {{ $stats['warga_laki'] }},
                    {{ $stats['warga_perempuan'] }}
                ],
                backgroundColor: [
                    'rgba(13, 110, 253, 0.8)',
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
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = {{ $stats['total_warga'] }};
                            const value = context.parsed;
                            const percentage = ((value / total) * 100).toFixed(1);
                            return context.label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
