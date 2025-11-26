@extends('layouts.app')

@section('title', 'Edit Dokumen - ' . $dokumen->nama_dokumen)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Dokumen</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('dokumen.show', $dokumen->id) }}" class="btn btn-info btn-sm me-2">
            <i class="fas fa-eye me-1"></i>Detail
        </a>
        <a href="{{ route('dokumen.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-primary">Form Edit Dokumen</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('dokumen.update', $dokumen->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama_dokumen" class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_dokumen') is-invalid @enderror" 
                               id="nama_dokumen" name="nama_dokumen" 
                               value="{{ old('nama_dokumen', $dokumen->nama_dokumen) }}" 
                               placeholder="Contoh: KTP Asli, Kartu Keluarga, Surat Pengantar RT/RW" required>
                        @error('nama_dokumen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="4" 
                                  placeholder="Jelaskan detail dokumen, format yang diterima, dan informasi tambahan...">{{ old('deskripsi', $dokumen->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-warning py-2">
                        <small>
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            <strong>Perhatian:</strong> Mengubah nama dokumen akan mempengaruhi semua layanan yang menggunakan dokumen ini.
                        </small>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('dokumen.show', $dokumen->id) }}" class="btn btn-secondary btn-sm me-2">Batal</a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-1"></i>Update Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Informasi Dokumen Saat Ini -->
        <div class="card shadow-sm mb-3">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-info">Data Saat Ini</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th width="40%">Nama Dokumen</th>
                        <td>{{ $dokumen->nama_dokumen }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>
                            @if($dokumen->deskripsi)
                                {{ Str::limit($dokumen->deskripsi, 100) }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Digunakan di</th>
                        <td>
                            @if($dokumen->persyaratan_count > 0)
                                <span class="badge bg-primary">{{ $dokumen->persyaratan_count }} Layanan</span>
                            @else
                                <span class="badge bg-secondary">Belum digunakan</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $dokumen->created_at->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Layanan yang Menggunakan -->
        <div class="card shadow-sm">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-warning">
                    <i class="fas fa-concierge-bell me-1"></i>Layanan Terkait
                </h6>
            </div>
            <div class="card-body">
                @if($dokumen->persyaratan->count() > 0)
                    <div class="small">
                        @foreach($dokumen->persyaratan as $persyaratan)
                        <div class="mb-1">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            {{ $persyaratan->layanan->nama_layanan }}
                            @if($persyaratan->wajib)
                                <span class="badge bg-danger ms-1">Wajib</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-2">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p class="small mb-0">Belum digunakan di layanan apapun</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection