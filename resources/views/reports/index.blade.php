@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="mb-4">
    <h2><i class="fas fa-chart-bar me-2"></i>Dashboard Laporan</h2>
    <p class="text-muted">Overview dan akses ke berbagai jenis laporan</p>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Permohonan</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_permohonan']) }}</h2>
                    </div>
                    <i class="fas fa-file-alt fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Pending</h6>
                        <h2 class="mb-0">{{ number_format($stats['permohonan_pending']) }}</h2>
                    </div>
                    <i class="fas fa-clock fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Selesai</h6>
                        <h2 class="mb-0">{{ number_format($stats['permohonan_selesai']) }}</h2>
                    </div>
                    <i class="fas fa-check-circle fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Warga</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_warga']) }}</h2>
                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Cards -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Laporan Permohonan</h5>
            </div>
            <div class="card-body">
                <p class="card-text">Laporan detail permohonan layanan dengan filter tanggal, status, dan layanan. Termasuk statistik dan chart.</p>
                <ul class="small mb-3">
                    <li>Filter by date range, status, layanan</li>
                    <li>Statistik per status</li>
                    <li>Chart permohonan per layanan</li>
                    <li>Data detail lengkap</li>
                </ul>
                <a href="{{ route('reports.permohonan') }}" class="btn btn-primary">
                    <i class="fas fa-chart-bar me-2"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-info">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Laporan Warga</h5>
            </div>
            <div class="card-body">
                <p class="card-text">Laporan statistik data warga dan kartu keluarga dengan breakdown jenis kelamin.</p>
                <ul class="small mb-3">
                    <li>Total warga dan kartu keluarga</li>
                    <li>Breakdown jenis kelamin</li>
                    <li>Chart demografi</li>
                    <li>Data warga lengkap</li>
                </ul>
                <a href="{{ route('reports.warga') }}" class="btn btn-info">
                    <i class="fas fa-chart-pie me-2"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>
    
    @if(auth()->user()->isKepalaDesa() || auth()->user()->isAdmin())
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-success">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Laporan Keuangan</h5>
            </div>
            <div class="card-body">
                <p class="card-text">Laporan pendapatan dari biaya administrasi permohonan dengan analisis trend.</p>
                <ul class="small mb-3">
                    <li>Total pendapatan</li>
                    <li>Pendapatan bulan ini</li>
                    <li>Trend pendapatan 6 bulan</li>
                    <li>Detail transaksi</li>
                </ul>
                <a href="{{ route('reports.financial') }}" class="btn btn-success">
                    <i class="fas fa-chart-line me-2"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-warning">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Laporan Kinerja</h5>
            </div>
            <div class="card-body">
                <p class="card-text">Laporan kinerja dan performa setiap layanan dengan success rate dan metrics.</p>
                <ul class="small mb-3">
                    <li>Total layanan aktif</li>
                    <li>Success rate per layanan</li>
                    <li>Jumlah permohonan per layanan</li>
                    <li>Performance metrics</li>
                </ul>
                <a href="{{ route('reports.performance') }}" class="btn btn-warning">
                    <i class="fas fa-tachometer-alt me-2"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Quick Info -->
<div class="card bg-light">
    <div class="card-body">
        <h6 class="card-title"><i class="fas fa-info-circle me-2"></i>Informasi</h6>
        <div class="row">
            <div class="col-md-6">
                <p class="small mb-1"><strong>Total Layanan:</strong> {{ $stats['total_layanan'] }}</p>
                <p class="small mb-0"><strong>Total Users:</strong> {{ $stats['total_users'] }}</p>
            </div>
            <div class="col-md-6">
                <p class="small mb-1"><strong>Data Update:</strong> Real-time</p>
                <p class="small mb-0"><strong>Terakhir Diakses:</strong> {{ now()->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
