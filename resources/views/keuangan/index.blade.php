@extends('layouts.app')

@section('title', 'Manajemen Kas Desa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-book me-2"></i>Buku Kas Umum Desa</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('keuangan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i>Catat Transaksi
        </a>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title opacity-75">Total Pemasukan</h6>
                <h2 class="mb-0">Rp {{ number_format($summary['total_masuk'], 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h6 class="card-title opacity-75">Total Pengeluaran</h6>
                <h2 class="mb-0">Rp {{ number_format($summary['total_keluar'], 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card {{ $summary['saldo'] >= 0 ? 'bg-info' : 'bg-warning' }} text-white">
            <div class="card-body">
                <h6 class="card-title opacity-75">Saldo Kas Saat Ini</h6>
                <h2 class="mb-0">Rp {{ number_format($summary['saldo'], 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Search -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('keuangan.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="small text-muted">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
            </div>
            <div class="col-md-3">
                <label class="small text-muted">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
            </div>
            <div class="col-md-2">
                <label class="small text-muted">Tipe</label>
                <select name="tipe" class="form-control">
                    <option value="">Semua</option>
                    <option value="masuk" {{ request('tipe') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                    <option value="keluar" {{ request('tipe') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
                <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Ledger Table -->
<div class="card shadow">
    <div class="card-header py-3 bg-light">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi Kas</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Tanggal</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th class="text-end">Pemasukan</th>
                        <th class="text-end">Pengeluaran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td class="ps-3 text-muted small">{{ $item->tanggal->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $item->tipe == 'masuk' ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }}">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td>
                            <div>{{ $item->keterangan ?? '-' }}</div>
                            @if($item->permohonan_id)
                                <small class="text-muted">
                                    <i class="fas fa-link me-1"></i>Resi: {{ $item->permohonan->nomor_resi }}
                                </small>
                            @endif
                        </td>
                        <td class="text-end text-success">
                            {{ $item->tipe == 'masuk' ? 'Rp ' . number_format($item->jumlah, 0, ',', '.') : '-' }}
                        </td>
                        <td class="text-end text-danger">
                            {{ $item->tipe == 'keluar' ? 'Rp ' . number_format($item->jumlah, 0, ',', '.') : '-' }}
                        </td>
                        <td class="text-center">
                            @if(!$item->permohonan_id)
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('keuangan.edit', $item->id) }}" class="btn btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('keuangan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @else
                                <span class="badge bg-secondary-soft text-secondary small">System</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                            <p>Belum ada catatan transaksi kas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $items->links() }}
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.1); }
</style>
@endsection
