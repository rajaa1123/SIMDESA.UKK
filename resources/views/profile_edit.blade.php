@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2"><i class="fas fa-user-edit me-2 text-success"></i>Pengaturan Akun</h1>
    <a href="{{ route('profile') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form action="{{ route('profile.update') }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-lg-6 mb-4">
            <!-- Account Information -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success text-uppercase small">Informasi Akun</h6>
                    @if(!$user->isAdmin())
                        <span class="badge bg-light text-muted border small-8">Read Only</span>
                    @endif
                </div>
                <div class="card-body p-4">
                    @if(!$user->isAdmin())
                        <div class="alert alert-warning border-0 shadow-xs py-3 small mb-4 d-flex align-items-center">
                            <i class="fas fa-lock fa-2x me-3 opacity-50 text-warning"></i>
                            <div>
                                <strong class="d-block mb-1">Data Akun Terkunci</strong>
                                Username, Email, dan No. Telepon dikunci untuk keamanan identitas. Hubungi Admin jika diperlukan perubahan.
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label small fw-bold text-muted text-uppercase">Username / Nama Display</label>
                        <div class="input-group shadow-xs">
                            <span class="input-group-text bg-white border-end-0 text-success"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control bg-light @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required {{ !$user->isAdmin() ? 'readonly' : '' }}>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold text-muted text-uppercase">Alamat Email</label>
                        <div class="input-group shadow-xs">
                            <span class="input-group-text bg-white border-end-0 text-success"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control bg-light @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required {{ !$user->isAdmin() ? 'readonly' : '' }}>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="form-label small fw-bold text-muted text-uppercase">No. Telepon/WA</label>
                        <div class="input-group shadow-xs">
                            <span class="input-group-text bg-white border-end-0 text-success"><i class="fas fa-phone"></i></span>
                            <input type="text" class="form-control bg-light @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" {{ !$user->isAdmin() ? 'readonly' : '' }}>
                        </div>
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="p-4 rounded-4 border bg-light shadow-xs border-success border-opacity-10">
                        <h6 class="font-weight-bold text-dark mb-3 d-flex align-items-center">
                            <span class="bg-success bg-opacity-10 p-2 rounded-3 me-2 text-success">
                                <i class="fas fa-shield-alt"></i>
                            </span>
                            Keamanan Akun
                        </h6>
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-bold text-muted">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Min. 6 karakter">
                            <div class="form-text small opacity-75 mt-2"><i class="fas fa-info-circle me-1"></i> Kosongkan jika tidak ingin mengubah password</div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-0">
                            <label for="password_confirmation" class="form-label small fw-bold text-muted">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($user->warga)
        <div class="col-lg-6 mb-4">
            <!-- Biodata Information -->
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success text-uppercase small">Biodata Kependudukan</h6>
                    @if(!$user->isAdmin())
                        <span class="badge bg-light text-muted border small-8 font-weight-bold">Read Only</span>
                    @endif
                </div>
                <div class="card-body p-4">
                    @if(!$user->isAdmin())
                        <div class="alert alert-info border-0 shadow-xs py-2 small mb-4 bg-info bg-opacity-10 text-info font-weight-bold">
                            <i class="fas fa-info-circle me-1"></i> Identitas diverifikasi oleh Admin Desa.
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="nik" class="form-label small fw-bold text-muted">NIK (16 DIGIT)</label>
                        <input type="text" class="form-control shadow-xs @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $user->warga->nik) }}" required maxlength="16" {{ !$user->isAdmin() ? 'readonly' : '' }}>
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label small fw-bold text-muted">NAMA LENGKAP PENDUDUK</label>
                        <input type="text" class="form-control shadow-xs @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->warga->nama_lengkap) }}" required {{ !$user->isAdmin() ? 'readonly' : '' }}>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="tempat_lahir" class="form-label small fw-bold text-muted">TEMPAT LAHIR</label>
                            <input type="text" class="form-control shadow-xs @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $user->warga->tempat_lahir) }}" required {{ !$user->isAdmin() ? 'readonly' : '' }}>
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_lahir" class="form-label small fw-bold text-muted">TANGGAL LAHIR</label>
                            <input type="date" class="form-control shadow-xs @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->warga->tanggal_lahir?->format('Y-m-d')) }}" required {{ !$user->isAdmin() ? 'readonly' : '' }}>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kelamin" class="form-label small fw-bold text-muted">JENIS KELAMIN</label>
                            @if($user->isAdmin())
                                <select class="form-select shadow-xs @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $user->warga->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $user->warga->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            @else
                                <input type="text" class="form-control bg-light border-0 shadow-xs" value="{{ $user->warga->jenis_kelamin }}" readonly>
                                <input type="hidden" name="jenis_kelamin" value="{{ $user->warga->jenis_kelamin }}">
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="agama" class="form-label small fw-bold text-muted">AGAMA</label>
                            @if($user->isAdmin())
                                <select class="form-select shadow-xs @error('agama') is-invalid @enderror" id="agama" name="agama">
                                    <option value="">Pilih Agama</option>
                                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agm)
                                        <option value="{{ $agm }}" {{ old('agama', $user->warga->agama) == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" class="form-control bg-light border-0 shadow-xs" value="{{ $user->warga->agama ?? '-' }}" readonly>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="pendidikan" class="form-label small fw-bold text-muted">PENDIDIKAN TERAKHIR</label>
                        <input type="text" class="form-control shadow-xs @error('pendidikan') is-invalid @enderror" id="pendidikan" name="pendidikan" value="{{ old('pendidikan', $user->warga->pendidikan) }}" {{ !$user->isAdmin() ? 'readonly' : '' }}>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_pekerjaan" class="form-label small fw-bold text-muted">PEKERJAAN UTAMA</label>
                        <input type="text" class="form-control shadow-xs @error('jenis_pekerjaan') is-invalid @enderror" id="jenis_pekerjaan" name="jenis_pekerjaan" value="{{ old('jenis_pekerjaan', $user->warga->jenis_pekerjaan) }}" {{ !$user->isAdmin() ? 'readonly' : '' }}>
                    </div>

                    <div class="mb-0">
                        <label for="alamat" class="form-label small fw-bold text-muted">ALAMAT SESUAI KTP</label>
                        <textarea class="form-control shadow-xs @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2" {{ !$user->isAdmin() ? 'readonly' : '' }}>{{ old('alamat', $user->warga->alamat) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="text-end mb-5">
        <button type="submit" class="btn btn-success btn-lg px-5 shadow hover-elevate">
            <i class="fas fa-save me-2"></i>Simpan Perubahan
        </button>
    </div>
</form>

<style>
    .small-8 { font-size: 0.75rem; }
    .shadow-xs { box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05); }
    .hover-elevate:hover { transform: translateY(-2px); transition: 0.3s; box-shadow: 0 0.5rem 1rem rgba(45, 125, 62, 0.15) !important; }
    .form-control:focus { border-color: #2d7d3e; box-shadow: 0 0 0 0.2rem rgba(45, 125, 62, 0.1); }
    .bg-opacity-10 { --bs-bg-opacity: 0.1; }
    .border-opacity-10 { --bs-border-opacity: 0.1; }
    .text-success { color: #2d7d3e !important; }
</style>
@endsection
