@extends('layouts.app')

@section('title', 'Laporan Keuangan Terpadu')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-chart-line me-2"></i>Laporan Keuangan Terpadu</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Laporan</a></li>
                    <li class="breadcrumb-item active">Keuangan</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h6 class="card-title opacity-75 small">Total Pemasukan (Global)</h6>
                <h3 class="mb-0">Rp {{ number_format($stats['total_masuk'], 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white shadow">
            <div class="card-body">
                <h6 class="card-title opacity-75 small">Total Pengeluaran (Global)</h6>
                <h3 class="mb-0">Rp {{ number_format($stats['total_keluar'], 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card {{ $stats['saldo'] >= 0 ? 'bg-primary' : 'bg-warning' }} text-white shadow">
            <div class="card-body">
                <h6 class="card-title opacity-75 small">Saldo Kas (Current)</h6>
                <h3 class="mb-0">Rp {{ number_format($stats['saldo'], 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <h6 class="card-title opacity-75 small">Pemasukan Bulan Ini</h6>
                <h3 class="mb-0">Rp {{ number_format($stats['bulan_ini'], 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Trend Chart -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Trend Arus Kas (6 Bulan Terakhir)</h6>
            </div>
            <div class="card-body">
                <div class="chart-area" style="height: 300px;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Panel -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('reports.financial') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Tipe Transaksi</label>
                        <select name="tipe" class="form-control">
                            <option value="">Semua</option>
                            <option value="masuk" {{ request('tipe') == 'masuk' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="keluar" {{ request('tipe') == 'keluar' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-sync-alt me-2"></i>Perbarui Data
                    </button>
                    <a href="{{ route('reports.financial') }}" class="btn btn-outline-secondary w-100 mt-2">Reset</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Ledger Table -->
<div class="card shadow mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi Ledger</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light text-muted small">
                    <tr>
                        <th class="ps-3">TGL</th>
                        <th>KATEGORI</th>
                        <th>KETERANGAN</th>
                        <th class="text-end">MASUK</th>
                        <th class="text-end">KELUAR</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse($financials as $finance)
                    <tr>
                        <td class="ps-3">{{ $finance->tanggal->format('d/m/y') }}</td>
                        <td>
                            <span class="badge {{ $finance->tipe == 'masuk' ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }}">
                                {{ $finance->kategori }}
                            </span>
                        </td>
                        <td class="text-truncate" style="max-width: 250px;">
                            {{ $finance->keterangan }}
                        </td>
                        <td class="text-end text-success font-weight-bold">
                            {{ $finance->tipe == 'masuk' ? number_format($finance->jumlah, 0, ',', '.') : '-' }}
                        </td>
                        <td class="text-end text-danger font-weight-bold">
                            {{ $finance->tipe == 'keluar' ? number_format($finance->jumlah, 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Data tidak ditemukan untuk periode ini.</td>
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

<style>
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('trendChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($monthlyData as $data)
                    '{{ $bulanNames[$data->bulan - 1] }} {{ $data->tahun }}',
                @endforeach
            ],
            datasets: [
                {
                    label: 'Pemasukan',
                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                    borderColor: 'rgb(40, 167, 69)',
                    data: [
                        @foreach($monthlyData as $data) {{ $data->total_masuk }}, @endforeach
                    ]
                },
                {
                    label: 'Pengeluaran',
                    backgroundColor: 'rgba(220, 53, 69, 0.8)',
                    borderColor: 'rgb(220, 53, 69)',
                    data: [
                        @foreach($monthlyData as $data) {{ $data->total_keluar }}, @endforeach
                    ]
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
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
                            return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
