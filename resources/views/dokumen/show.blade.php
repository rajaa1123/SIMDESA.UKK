@extends('layouts.app')

@section('title', $dokumen->nama_dokumen)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Dokumen</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('dokumen.edit', $dokumen->id) }}" class="btn btn-warning btn-sm me-2">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <a href="{{ route('dokumen.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- Informasi Dokumen -->
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-primary">
                    <i class="fas fa-file me-1"></i>Informasi Dokumen
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th width="30%">Nama Dokumen</th>
                        <td><strong>{{ $dokumen->nama_dokumen }}</strong></td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>
                            @if($dokumen->deskripsi)
                                {{ $dokumen->deskripsi }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Digunakan di Layanan</th>
                        <td>
                            @if($dokumen->persyaratan_count > 0)
                                <span class="badge bg-primary">{{ $dokumen->persyaratan_count }} Layanan</span>
                            @else
                                <span class="badge bg-secondary">Belum digunakan</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Dibuat</th>
                        <td>{{ $dokumen->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Diupdate</th>
                        <td>{{ $dokumen->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Layanan yang Menggunakan Dokumen Ini -->
        <div class="card shadow-sm">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-info">
                    <i class="fas fa-concierge-bell me-1"></i>Layanan yang Menggunakan Dokumen Ini
                </h6>
            </div>
            <div class="card-body">
                @if($dokumen->persyaratan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Layanan</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dokumen->persyaratan as $persyaratan)
                                <tr>
                                    <td>
                                        <a href="{{ route('layanan.show', $persyaratan->layanan_id) }}" class="text-decoration-none">
                                            {{ $persyaratan->layanan->nama_layanan }}
                                        </a>
                                    </td>
                                    <td>{{ $persyaratan->layanan->kategori }}</td>
                                    <td>
                                        @if($persyaratan->wajib)
                                            <span class="badge bg-danger">Wajib</span>
                                        @else
                                            <span class="badge bg-secondary">Opsional</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($persyaratan->catatan)
                                            <small class="text-muted">{{ $persyaratan->catatan }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-concierge-bell fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-2">Dokumen ini belum digunakan di layanan manapun.</p>
                        <a href="{{ route('layanan.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus me-1"></i>Tambahkan ke Layanan
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar Actions -->
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-success">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('dokumen.edit', $dokumen->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit Dokumen
                    </a>
                    <a href="{{ route('layanan.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>Tambahkan ke Layanan
                    </a>
                    <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST" 
                          onsubmit="return confirm('Hapus dokumen {{ $dokumen->nama_dokumen }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash me-1"></i>Hapus Dokumen
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-info">Statistik</h6>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-concierge-bell fa-2x text-primary mb-2"></i>
                    <h4>{{ $dokumen->persyaratan_count }}</h4>
                    <small class="text-muted">Layanan Menggunakan</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection