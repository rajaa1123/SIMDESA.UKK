@extends('layouts.app')

@section('title', 'Manajemen Aset & Inventaris Desa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Aset & Inventaris</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('assets.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Aset Baru
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow-sm border-0">
            <div class="card-body">
                <h6 class="card-title opacity-75">Total Aset</h6>
                <h3 class="fw-bold mb-0 text-white">{{ $asets->total() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white shadow-sm border-0">
            <div class="card-body">
                <h6 class="card-title opacity-75">Kondisi Baik</h6>
                <h3 class="fw-bold mb-0 text-white">{{ \App\Models\Asset::where('kondisi', 'Baik')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark shadow-sm border-0">
            <div class="card-body">
                <h6 class="card-title opacity-75">Total Nilai Aset</h6>
                <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format(\App\Models\Asset::sum('nilai_perolehan'), 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode Aset</th>
                        <th>Nama Aset</th>
                        <th>Kategori</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Nilai Perolehan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asets as $asset)
                    <tr>
                        <td><code class="text-primary fw-bold">{{ $asset->kode_aset }}</code></td>
                        <td><span class="fw-bold">{{ $asset->nama_aset }}</span></td>
                        <td>{{ $asset->kategori }}</td>
                        <td>
                            @php
                                $badge = [
                                    'Baik' => 'bg-success',
                                    'Rusak Ringan' => 'bg-warning',
                                    'Rusak Berat' => 'bg-danger'
                                ][$asset->kondisi] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $badge }}">{{ $asset->kondisi }}</span>
                        </td>
                        <td>{{ $asset->lokasi ?? '-' }}</td>
                        <td>Rp {{ number_format($asset->nilai_perolehan, 0, ',', '.') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('assets.show', $asset->id) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus aset ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Belum ada aset terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $asets->links() }}
        </div>
    </div>
</div>
@endsection
