@extends('layouts.app')

@section('title', $layanan->nama_layanan)

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ $layanan->nama_layanan }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            @if(auth()->user()->isWarga())
                <a href="{{ route('permohonan.create') }}?layanan_id={{ $layanan->id }}" class="btn btn-success btn-sm me-2">
                    <i class="fas fa-file-alt me-1"></i>Ajukan Permohonan
                </a>
            @endif

            <div class="d-flex gap-2"></div>
            @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                <a href="{{ route('layanan.edit', $layanan->id) }}" class="btn btn-warning btn-sm me-2">
                    <i class="fas fa-edit me-1"></i>Edit
                </a>
            @endif

            <a href="{{ route('layanan.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informasi Layanan -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-1"></i>Informasi Layanan
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama Layanan</th>
                            <td><strong>{{ $layanan->nama_layanan }}</strong></td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>
                                <span class="badge bg-info">{{ $layanan->kategori }}</span>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-file-alt me-1"></i>Persyaratan
                    </h6>
                </div>
                <div class="card-body">
                    @if($layanan->persyaratan->count() > 0)
                        <div class="list-group">
                            @foreach($layanan->persyaratan as $persyaratan)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $persyaratan->dokumen->nama_dokumen }}</h6>
                                            <p class="mb-1 small text-muted">{{ $persyaratan->dokumen->deskripsi }}</p>
                                            @if($persyaratan->catatan)
                                                <small class="text-warning"><i
                                                        class="fas fa-exclamation-circle me-1"></i>{{ $persyaratan->catatan }}</small>
                                            @endif
                                        </div>
                                        <div>
                                            @if($persyaratan->wajib)
                                                <span class="badge bg-danger">Wajib</span>
                                            @else
                                                <span class="badge bg-secondary">Opsional</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-invoice fa-2x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada persyaratan yang ditentukan.</p>
                            @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                                <a href="{{ route('layanan.edit', $layanan->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-plus me-1"></i>Tambah Persyaratan
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            @if(auth()->user()->isWarga())
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Ajukan Permohonan</h6>
                    </div>
                    <div class="card-body text-center">
                        <p class="card-text small">Klik tombol di bawah untuk mengajukan permohonan layanan ini.</p>
                        <a href="{{ route('permohonan.create') }}?layanan_id={{ $layanan->id }}" class="btn btn-success">
                            <i class="fas fa-file-alt me-2"></i>Ajukan Sekarang
                        </a>
                    </div>
                </div>
            @endif

            <!-- Statistik -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                            <h4>{{ $layanan->permohonan_count ?? 0 }}</h4>
                            <small class="text-muted">Total Permohonan</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
    </div>
@endsection