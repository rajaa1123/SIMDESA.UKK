@extends('layouts.app')

@section('title', 'Edit Warga - ' . $warga->nama_lengkap)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Data Warga</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('warga.show', $warga->id) }}" class="btn btn-info me-2">
            <i class="fas fa-eye me-1"></i>Detail
        </a>
        <a href="{{ route('warga.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Data Warga</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('warga.update', $warga->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                   id="nik" name="nik" value="{{ old('nik', $warga->nik) }}" required maxlength="16">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                   id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $warga->nama_lengkap) }}" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" 
                                    id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                   id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $warga->tempat_lahir) }}" required>
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                   id="tanggal_lahir" name="tanggal_lahir" value="{{ $warga->tanggal_lahir ? \Carbon\Carbon::parse($warga->tanggal_lahir)->format('d-m-Y') : '' }}" required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <select class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama">
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('agama', $warga->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama', $warga->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama', $warga->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama', $warga->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama', $warga->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama', $warga->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pendidikan" class="form-label">Pendidikan</label>
                            <select class="form-control @error('pendidikan') is-invalid @enderror" id="pendidikan" name="pendidikan">
                                <option value="">Pilih Pendidikan</option>
                                <option value="Tidak Sekolah" {{ old('pendidikan', $warga->pendidikan) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                <option value="SD" {{ old('pendidikan', $warga->pendidikan) == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('pendidikan', $warga->pendidikan) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('pendidikan', $warga->pendidikan) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="D1-D3" {{ old('pendidikan', $warga->pendidikan) == 'D1-D3' ? 'selected' : '' }}>D1-D3</option>
                                <option value="S1" {{ old('pendidikan', $warga->pendidikan) == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('pendidikan', $warga->pendidikan) == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('pendidikan', $warga->pendidikan) == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                            @error('pendidikan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jenis_pekerjaan" class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control @error('jenis_pekerjaan') is-invalid @enderror" 
                                   id="jenis_pekerjaan" name="jenis_pekerjaan" value="{{ old('jenis_pekerjaan', $warga->jenis_pekerjaan) }}">
                            @error('jenis_pekerjaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3">{{ old('alamat', $warga->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="kartu_keluarga_id" class="form-label">Kartu Keluarga</label>
                            <select class="form-control @error('kartu_keluarga_id') is-invalid @enderror" 
                                    id="kartu_keluarga_id" name="kartu_keluarga_id">
                                <option value="">Pilih Kartu Keluarga</option>
                                @foreach($kartuKeluargas as $kk)
                                    <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id', $warga->kartu_keluarga_id) == $kk->id ? 'selected' : '' }}>
                                        {{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kartu_keluarga_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="status_hidup" class="form-label">Status Hidup <span class="text-danger">*</span></label>
                            <select class="form-control @error('status_hidup') is-invalid @enderror" 
                                    id="status_hidup" name="status_hidup" required>
                                <option value="Hidup" {{ old('status_hidup', $warga->status_hidup) == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                                <option value="Meninggal" {{ old('status_hidup', $warga->status_hidup) == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                            </select>
                            @error('status_hidup')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="status_domisili" class="form-label">Status Domisili</label>
                            <select class="form-control @error('status_domisili') is-invalid @enderror" 
                                    id="status_domisili" name="status_domisili">
                                <option value="Domisili Tetap" {{ old('status_domisili', $warga->status_domisili) == 'Domisili Tetap' ? 'selected' : '' }}>Domisili Tetap</option>
                                <option value="Domisili Sementara" {{ old('status_domisili', $warga->status_domisili) == 'Domisili Sementara' ? 'selected' : '' }}>Domisili Sementara</option>
                                <option value="Pendatang" {{ old('status_domisili', $warga->status_domisili) == 'Pendatang' ? 'selected' : '' }}>Pendatang</option>
                            </select>
                            @error('status_domisili')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                            <select class="form-control @error('status_perkawinan') is-invalid @enderror" 
                                    id="status_perkawinan" name="status_perkawinan">
                                <option value="">Pilih Status</option>
                                <option value="Belum Menikah" {{ old('status_perkawinan', $warga->status_perkawinan) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="Menikah" {{ old('status_perkawinan', $warga->status_perkawinan) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                <option value="Cerai Hidup" {{ old('status_perkawinan', $warga->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ old('status_perkawinan', $warga->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                            @error('status_perkawinan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('warga.show', $warga->id) }}" class="btn btn-secondary me-md-2">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Data
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
                <h6>Data Saat Ini:</h6>
                <ul class="small">
                    <li><strong>NIK:</strong> {{ $warga->nik }}</li>
                    <li><strong>Nama:</strong> {{ $warga->nama_lengkap }}</li>
                    <li><strong>TTL:</strong> {{ $warga->tempat_lahir }}, {{ optional($warga->tanggal_lahir)->format('d/m/Y') ?: '-' }}</li>
                    <li><strong>Status:</strong> {{ $warga->status_hidup }}</li>
                </ul>
                
                <div class="alert alert-warning mt-3">
                    <small>
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        <strong>Perhatian:</strong> Pastikan data yang diubah sudah benar dan valid.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection