@extends('layouts.app')

@section('title', 'Detail Aset - ' . $asset->nama_aset)

@section('content')
<div class="container text-start">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Aset</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus aset ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 text-center py-4">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-boxes fa-4x text-primary opacity-25"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $asset->nama_aset }}</h4>
                    <p class="text-muted small mb-3">{{ $asset->kategori }}</p>
                    <code class="d-block bg-light p-2 rounded fw-bold mb-3">{{ $asset->kode_aset }}</code>
                    
                    @php
                        $badge = [
                            'Baik' => 'bg-success',
                            'Rusak Ringan' => 'bg-warning',
                            'Rusak Berat' => 'bg-danger'
                        ][$asset->kondisi] ?? 'bg-secondary';
                    @endphp
                    <span class="badge {{ $badge }} px-3 py-2">Kondisi: {{ $asset->kondisi }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Lengkap Aset</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Tanggal Perolehan</div>
                        <div class="col-sm-8 fw-bold">{{ $asset->tanggal_perolehan ? $asset->tanggal_perolehan->format('d M Y') : '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Nilai Perolehan</div>
                        <div class="col-sm-8 fw-bold text-success">Rp {{ number_format($asset->nilai_perolehan, 0, ',', '.') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Lokasi Penyimpanan</div>
                        <div class="col-sm-8">{{ $asset->lokasi ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Keterangan / Deskripsi</div>
                        <div class="col-sm-8">
                            <p class="mb-0">{{ $asset->keterangan ?? 'Tidak ada keterangan tambahan.' }}</p>
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col-sm-4 text-muted">Dicatatkan Pada</div>
                        <div class="col-sm-8 small text-muted">{{ $asset->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
