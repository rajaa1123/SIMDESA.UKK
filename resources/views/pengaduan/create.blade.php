@extends('layouts.app')

@section('title', 'Buat Pengaduan Baru')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat Pengaduan Baru</h1>
    <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Pengaduan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" name="judul" value="{{ old('judul') }}" required
                               placeholder="Contoh: Jalan Berlubang di RT 02">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi Kejadian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                               id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required
                               placeholder="Contoh: Depan Balai Desa">
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="isi_laporan" class="form-label">Isi Laporan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('isi_laporan') is-invalid @enderror" 
                                  id="isi_laporan" name="isi_laporan" rows="5" required
                                  placeholder="Jelaskan detail masalah yang Anda temukan...">{{ old('isi_laporan') }}</textarea>
                        @error('isi_laporan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Bukti (Opsional)</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                               id="foto" name="foto" accept="image/*">
                        <div class="form-text">Format: JPG, PNG, JPEG. Maksimal 2MB.</div>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="reset" class="btn btn-secondary me-md-2">Reset</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
