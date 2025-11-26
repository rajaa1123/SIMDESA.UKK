@extends('layouts.app')

@section('title', 'Tambah Dokumen')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Dokumen Persyaratan</h1>
    <a href="{{ route('dokumen.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-primary">Form Tambah Dokumen</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('dokumen.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama_dokumen" class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_dokumen') is-invalid @enderror" 
                               id="nama_dokumen" name="nama_dokumen" value="{{ old('nama_dokumen') }}" 
                               placeholder="Contoh: KTP Asli, Kartu Keluarga, Surat Pengantar RT/RW" required>
                        @error('nama_dokumen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="4" 
                                  placeholder="Jelaskan detail dokumen, format yang diterima, dan informasi tambahan...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info py-2">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            Dokumen ini nantinya bisa ditambahkan sebagai persyaratan untuk layanan tertentu.
                        </small>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-1"></i>Simpan Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-info">Contoh Dokumen</h6>
            </div>
            <div class="card-body">
                <div class="small text-muted">
                    <strong>Contoh nama dokumen:</strong>
                    <ul class="mt-2">
                        <li>KTP Asli</li>
                        <li>KTP Fotocopy</li>
                        <li>Kartu Keluarga</li>
                        <li>Surat Pengantar RT/RW</li>
                        <li>Pas Foto 3x4</li>
                        <li>Surat Keterangan Kerja</li>
                        <li>Izin Usaha</li>
                        <li>Akta Kelahiran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection