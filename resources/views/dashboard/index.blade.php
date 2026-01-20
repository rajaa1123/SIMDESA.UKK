@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="pt-3 pb-2 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-0">
                @if(auth()->user()->isAdmin())
                    Dashboard Administrator
                @elseif(auth()->user()->isKepalaDesa())
                    Dashboard Kepala Desa  
                @else
                    Dashboard Warga
                @endif
            </h1>
            <p class="text-muted small mb-0">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="d-none d-md-block">
            <div class="badge bg-white shadow-sm border text-dark px-3 py-2 rounded-pill">
                <i class="fas fa-clock text-success me-2"></i>Sesi Aktif: {{ now()->format('H:i') }}
            </div>
        </div>
    </div>

    <div class="row">
        @if(auth()->user()->isAdmin())
            <!-- Hero Section for Admin -->
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-md-8 p-4 p-lg-5 text-white" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                <h2 class="display-6 fw-bold mb-2">Pusat Kendali Admin 🖥️</h2>
                                <p class="lead mb-4 opacity-75">Sistem Informasi Desa berjalan optimal. Kelola warga dan layanan hari ini.</p>
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="{{ route('permohonan.index') }}" class="btn btn-warning btn-lg px-4 fw-bold shadow-sm rounded-pill">
                                        <i class="fas fa-tasks me-2"></i>Verifikasi
                                        @if($stats['perlu_verifikasi'] > 0)
                                            <span class="badge bg-danger ms-1">{{ $stats['perlu_verifikasi'] }}</span>
                                        @endif
                                    </a>
                                    <a href="{{ route('warga.create') }}" class="btn btn-outline-light btn-lg px-4 rounded-pill">
                                        <i class="fas fa-user-plus me-2"></i>Tambah Warga
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 d-none d-md-flex align-items-center justify-content-center bg-light">
                                <div class="text-center p-4">
                                    <i class="fas fa-server fa-4x text-primary opacity-10 mb-3 d-block"></i>
                                    <div class="badge bg-success rounded-pill px-3 py-2 shadow-sm"><i class="fas fa-check-circle me-1"></i> Sistem Online</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Statistics -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 p-2" style="border-radius: 12px; border-left: 5px solid #4e73df !important;">
                    <div class="card-body">
                        <div class="text-muted small fw-bold text-uppercase mb-1">Total Warga</div>
                        <div class="h3 mb-0 fw-bold text-dark">{{ number_format($stats['total_warga']) }}</div>
                        <i class="fas fa-users text-primary opacity-25 position-absolute" style="right: 20px; bottom: 20px; font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 p-2" style="border-radius: 12px; border-left: 5px solid #1cc88a !important;">
                    <div class="card-body">
                        <div class="text-muted small fw-bold text-uppercase mb-1">Total Permohonan</div>
                        <div class="h3 mb-0 fw-bold text-dark">{{ number_format($stats['total_permohonan']) }}</div>
                        <i class="fas fa-file-alt text-success opacity-25 position-absolute" style="right: 20px; bottom: 20px; font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 p-2" style="border-radius: 12px; border-left: 5px solid #f6c23e !important;">
                    <div class="card-body">
                        <div class="text-muted small fw-bold text-uppercase mb-1">Perlu Verifikasi</div>
                        <div class="h3 mb-0 fw-bold text-dark">{{ number_format($stats['perlu_verifikasi']) }}</div>
                        <i class="fas fa-clipboard-check text-warning opacity-25 position-absolute" style="right: 20px; bottom: 20px; font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 p-2" style="border-radius: 12px; border-left: 5px solid #36b9cc !important;">
                    <div class="card-body">
                        <div class="text-muted small fw-bold text-uppercase mb-1">Saldo Kas</div>
                        <div class="h4 mb-0 fw-bold text-dark">Rp{{ number_format($stats['saldo_keuangan'], 0, ',', '.') }}</div>
                        <i class="fas fa-wallet text-info opacity-25 position-absolute" style="right: 20px; bottom: 20px; font-size: 2rem;"></i>
                    </div>
                </div>
            </div>

        @elseif(auth()->user()->isKepalaDesa())
            <!-- Hero Section for Kades -->
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-md-8 p-4 p-lg-5 text-white" style="background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);">
                                <h2 class="display-6 fw-bold mb-2">Panel Kebijakan Kades 🏛️</h2>
                                <p class="lead mb-4 opacity-75">Bapak Kepala Desa, pantau efisiensi layanan dan berikan persetujuan akhir.</p>
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="{{ route('approval.index') }}" class="btn btn-warning btn-lg px-4 fw-bold shadow-sm rounded-pill">
                                        <i class="fas fa-signature me-2"></i>Persetujuan
                                        @if($stats['menunggu_approval'] > 0)
                                            <span class="badge bg-danger ms-1">{{ $stats['menunggu_approval'] }}</span>
                                        @endif
                                    </a>
                                    <a href="{{ route('reports.index') }}" class="btn btn-outline-light btn-lg px-4 rounded-pill">
                                        <i class="fas fa-chart-pie me-2"></i>Laporan
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 d-none d-md-flex align-items-center justify-content-center bg-success bg-opacity-10">
                                <div class="text-center p-4">
                                    <div class="h6 fw-bold text-muted mb-1 small">PENDAPATAN DESA</div>
                                    <div class="h3 fw-bold text-success mb-0">Rp{{ number_format($stats['saldo_keuangan'], 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kades Statistics -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 p-2" style="border-radius: 12px; border-left: 5px solid #4e73df !important;">
                    <div class="card-body">
                        <div class="text-muted small fw-bold text-uppercase mb-1">Warga Terdaftar</div>
                        <div class="h3 mb-0 fw-bold text-dark">{{ number_format($stats['total_warga']) }}</div>
                        <i class="fas fa-users text-primary opacity-25 position-absolute" style="right: 20px; bottom: 20px; font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 p-2 bg-warning bg-opacity-10" style="border-radius: 12px; border: 1px dashed #ffc107 !important; border-left: 8px solid #ffc107 !important;">
                    <div class="card-body">
                        <div class="text-warning small fw-bold text-uppercase mb-1">Menunggu Approval</div>
                        <div class="h3 mb-0 fw-bold text-dark">{{ number_format($stats['menunggu_approval']) }}</div>
                        <i class="fas fa-user-check text-warning opacity-50 position-absolute" style="right: 20px; bottom: 20px; font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 p-2" style="border-radius: 12px; border-left: 5px solid #1cc88a !important;">
                    <div class="card-body">
                        <div class="text-muted small fw-bold text-uppercase mb-1">Volume Layanan</div>
                        <div class="h3 mb-0 fw-bold text-dark">{{ number_format($stats['total_permohonan']) }}</div>
                        <i class="fas fa-file-invoice text-success opacity-25 position-absolute" style="right: 20px; bottom: 20px; font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 p-2" style="border-radius: 12px; border-left: 5px solid #36b9cc !important;">
                    <div class="card-body">
                        <div class="text-muted small fw-bold text-uppercase mb-1">Layanan Aktif</div>
                        <div class="h3 mb-0 fw-bold text-dark">{{ number_format($stats['total_layanan']) }}</div>
                        <i class="fas fa-concierge-bell text-info opacity-25 position-absolute" style="right: 20px; bottom: 20px; font-size: 2rem;"></i>
                    </div>
                </div>
            </div>

            <!-- Kades Charts -->
            <div class="col-xl-8 col-lg-7 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="m-0 fw-bold text-dark">Analitik Tren Layanan</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area" style="height: 300px;">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="m-0 fw-bold text-dark">Distribusi Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2" style="height: 250px;">
                            <canvas id="myPieChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2"><i class="fas fa-circle text-warning"></i> Pending</span>
                            <span class="mr-2 ms-2"><i class="fas fa-circle text-primary"></i> Proses</span>
                            <span class="mr-2 ms-2"><i class="fas fa-circle text-success"></i> Selesai</span>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <!-- Hero Section for Warga -->
            <div class="col-lg-11 mx-auto mb-4">
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-md-8 p-4 p-lg-5 text-white" style="background: linear-gradient(135deg, #2d7d3e 0%, #1b5e20 100%);">
                                <h2 class="display-6 fw-bold mb-2">Halo, {{ auth()->user()->name }}! 👋</h2>
                                <p class="lead mb-4 opacity-75">Gunakan layanan mandiri desa untuk pengurusan bermacam surat lebih cepat.</p>
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="{{ route('permohonan.create') }}" class="btn btn-warning btn-lg px-4 fw-bold shadow-sm rounded-pill">
                                        <i class="fas fa-plus-circle me-2"></i>Ajukan Surat
                                    </a>
                                    <a href="{{ route('permohonan.index') }}" class="btn btn-outline-light btn-lg px-4 rounded-pill">
                                        <i class="fas fa-history me-2"></i>Cek Riwayat
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 d-none d-md-flex align-items-center justify-content-center bg-white">
                                <div class="text-center p-4">
                                    <div class="h5 text-muted mb-1 small fw-bold">TOTAL PENGAJUAN</div>
                                    <div class="h1 fw-bold text-success mb-0">{{ number_format($stats['total_permohonan']) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warga Stats -->
            <div class="row mb-4 g-3 col-lg-11 mx-auto">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 p-1" style="border-radius: 12px; border-left: 5px solid #ffc107 !important;">
                        <div class="card-body">
                            <h6 class="text-muted mb-1 small fw-bold">Sedang Diproses</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['permohonan_pending'] + $stats['permohonan_diproses']) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 p-1" style="border-radius: 12px; border-left: 5px solid #198754 !important;">
                        <div class="card-body">
                            <h6 class="text-muted mb-1 small fw-bold">Surat Selesai</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['permohonan_selesai']) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 p-1" style="border-radius: 12px; border-left: 5px solid #0dcaf0 !important;">
                        <div class="card-body">
                            <h6 class="text-muted mb-1 small fw-bold">Jenis Layanan</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['total_layanan']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Actions for Dashboard Admin/Kades -->
    @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
    <div class="mb-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-bolt text-warning me-2"></i>Aksi Cepat</h5>
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="{{ route('layanan.index') }}" class="btn btn-white shadow-sm w-100 py-3 rounded-3 border-0 hover-lift text-dark">
                    <i class="fas fa-concierge-bell d-block mb-2 text-primary fa-lg"></i>
                    <span class="small fw-bold">Atur Layanan</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('warga.index') }}" class="btn btn-white shadow-sm w-100 py-3 rounded-3 border-0 hover-lift text-dark">
                    <i class="fas fa-users d-block mb-2 text-success fa-lg"></i>
                    <span class="small fw-bold">Data Warga</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('keuangan.index') }}" class="btn btn-white shadow-sm w-100 py-3 rounded-3 border-0 hover-lift text-dark">
                    <i class="fas fa-wallet d-block mb-2 text-info fa-lg"></i>
                    <span class="small fw-bold">Cek Kas</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('reports.index') }}" class="btn btn-white shadow-sm w-100 py-3 rounded-3 border-0 hover-lift text-dark">
                    <i class="fas fa-file-invoice d-block mb-2 text-danger fa-lg"></i>
                    <span class="small fw-bold">Laporan</span>
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Activity Section (Shared) -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark">
                <i class="fas fa-history me-2 text-muted"></i>
                {{ auth()->user()->isWarga() ? 'Riwayat Pengajuan Saya' : 'Aktivitas Layanan Terbaru' }}
            </h6>
            <a href="{{ route('permohonan.index') }}" class="btn btn-sm btn-link text-decoration-none">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
            @if($recent_permohonan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Jenis Layanan</th>
                                @if(!auth()->user()->isWarga()) <th>Nama Warga</th> @endif
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th class="text-end pe-4">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_permohonan as $permohonan)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $permohonan->layanan->nama_layanan }}</div>
                                    <div class="small text-muted">{{ $permohonan->nomor_resi }}</div>
                                </td>
                                @if(!auth()->user()->isWarga())
                                <td>
                                    <div class="fw-bold text-dark small">{{ $permohonan->user->name }}</div>
                                </td>
                                @endif
                                <td>
                                    @php
                                        $statusCode = optional($permohonan->status)->code;
                                        $statusClass = [
                                            'pending' => 'bg-warning text-dark',
                                            'menunggu_persetujuan_kades' => 'bg-info text-white',
                                            'ditolak' => 'bg-danger text-white', 
                                            'selesai' => 'bg-success text-white'
                                        ][$statusCode] ?? 'bg-secondary text-white';
                                    @endphp
                                    <span class="badge {{ $statusClass }} rounded-pill px-3 py-2" style="font-size: 0.7rem;">
                                        {{ strtoupper(optional($permohonan->status)->name ?? 'UNKNOWN') }}
                                    </span>
                                </td>
                                <td><small>{{ $permohonan->tanggal_pengajuan ? $permohonan->tanggal_pengajuan->diffForHumans() : '-' }}</small></td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('permohonan.show', $permohonan->id) }}" class="btn btn-sm btn-light border rounded-pill px-3">
                                        Buka <i class="fas fa-chevron-right ms-1 small"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-muted mb-0">Belum ada aktivitas layanan saat ini.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- News Section (If available) -->
    @if(auth()->user()->isWarga() && isset($latestBerita) && $latestBerita->count() > 0)
    <h5 class="fw-bold mb-3 mt-5"><i class="fas fa-newspaper text-primary me-2"></i>Berita & Informasi Desa</h5>
    <div class="row g-3 mb-5">
        @foreach($latestBerita as $news)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 hover-lift" style="border-radius: 12px; overflow: hidden;">
                @if($news->gambar)
                    <img src="{{ asset('storage/' . $news->gambar) }}" class="card-img-top" style="height: 160px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 160px;">
                        <i class="fas fa-image fa-3x text-muted opacity-25"></i>
                    </div>
                @endif
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-success bg-opacity-10 text-success small">{{ $news->kategori }}</span>
                        <small class="text-muted">{{ $news->published_at->format('d M') }}</small>
                    </div>
                    <h6 class="fw-bold text-dark mb-2 text-truncate-2">{{ $news->judul }}</h6>
                    <a href="{{ route('berita.show', $news->slug) }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<style>
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer; }
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .btn-white { background: #fff; }
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .pulse-badge { animation: pulse 2s infinite; }
    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
</style>

@if(auth()->user()->isKepalaDesa() && isset($chartData))
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Area Chart
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: "Jumlah Permohonan",
                    lineTension: 0.3,
                    backgroundColor: "rgba(40, 167, 69, 0.05)",
                    borderColor: "rgba(40, 167, 69, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(40, 167, 69, 1)",
                    pointBorderColor: "rgba(40, 167, 69, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(40, 167, 69, 1)",
                    pointHoverBorderColor: "rgba(40, 167, 69, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: @json($chartData['permohonan']),
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { ticks: { stepSize: 1 } }
                }
            }
        });

        // Pie Chart
        var ctx2 = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ["Pending", "Proses", "Selesai"],
                datasets: [{
                    data: [{{ $statusBreakdown['pending'] }}, {{ $statusBreakdown['proses'] }}, {{ $statusBreakdown['selesai'] }}],
                    backgroundColor: ['#ffc107', '#007bff', '#28a745'],
                    hoverBackgroundColor: ['#e0a800', '#0069d9', '#218838'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false }
                }
            },
        });
    </script>
    @endpush
@endif
@endsection