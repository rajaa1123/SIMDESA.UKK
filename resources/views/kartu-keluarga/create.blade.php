@extends('layouts.app')

@section('title', 'Tambah Kartu Keluarga')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Kartu Keluarga</h1>
    <a href="{{ route('kartu-keluarga.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Data Kartu Keluarga</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('kartu-keluarga.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="no_kk" class="form-label">No. Kartu Keluarga <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_kk') is-invalid @enderror" 
                                   id="no_kk" name="no_kk" value="{{ old('no_kk') }}" required 
                                   placeholder="Contoh: 3321123456789001" maxlength="16">
                            @error('no_kk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kepala_keluarga" class="form-label">Nama Kepala Keluarga <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kepala_keluarga') is-invalid @enderror" 
                                   id="kepala_keluarga" name="kepala_keluarga" value="{{ old('kepala_keluarga') }}" required>
                            @error('kepala_keluarga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="4" required placeholder="Alamat lengkap termasuk RT/RW">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status KK <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                <option value="Pindah" {{ old('status') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="reset" class="btn btn-secondary me-md-2">Reset</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Informasi</h6>
            </div>
            <div class="card-body">
                <h6>Keterangan:</h6>
                <ul class="small text-muted">
                    <li>Field bertanda <span class="text-danger">*</span> wajib diisi</li>
                    <li>No. KK harus 16 digit dan unik</li>
                    <li>Kepala keluarga adalah pemegang KK</li>
                    <li>Status aktif untuk KK yang masih berlaku</li>
                </ul>
                
                <h6 class="mt-3">Tips:</h6>
                <ul class="small text-muted">
                    <li>Gunakan No. KK asli dari Dukcapil</li>
                    <li>Pastikan alamat lengkap dan jelas</li>
                    <li>Periksa kembali sebelum menyimpan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection