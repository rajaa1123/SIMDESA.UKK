@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2"><i class="fas fa-user-circle me-2 text-success"></i>Profil Saya</h1>
    <a href="{{ route('profile.edit') }}" class="btn btn-success shadow-sm hover-elevate">
        <i class="fas fa-edit me-2"></i>Pengaturan Akun
    </a>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <!-- Profile Header Card -->
        <div class="card shadow-sm border-0 overflow-hidden mb-4">
            <div class="bg-success pt-5 pb-4 text-center" style="background: linear-gradient(135deg, #2d7d3e 0%, #4caf50 100%);">
                <div class="position-relative d-inline-block">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ffffff&color=2d7d3e&size=128&bold=true" 
                         class="rounded-circle border border-4 border-white shadow shadow-lg" alt="Profile Picture" width="120">
                    <div class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle p-2" title="Online"></div>
                </div>
                <h4 class="text-white mt-3 mb-0 font-weight-bold">{{ $user->name }}</h4>
                <p class="text-white-50 mb-0 small text-uppercase tracking-wider">{{ $user->role->display_name ?? $user->role->name }}</p>
            </div>
            <div class="card-body px-0 pt-0">
                <div class="list-group list-group-flush border-top">
                    <div class="list-group-item px-4 py-3 border-0 d-flex align-items-center">
                        <div class="bg-light rounded p-2 me-3">
                            <i class="fas fa-id-badge text-success w-20 text-center"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block text-uppercase small-8">Username</small>
                            <span class="font-weight-600 text-dark">{{ $user->name }}</span>
                        </div>
                    </div>
                    <div class="list-group-item px-4 py-3 border-0 d-flex align-items-center">
                        <div class="bg-light rounded p-2 me-3">
                            <i class="fas fa-envelope text-success w-20 text-center"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block text-uppercase small-8">Email Terdaftar</small>
                            <span class="font-weight-600 text-dark">{{ $user->email ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="list-group-item px-4 py-3 border-0 d-flex align-items-center">
                        <div class="bg-light rounded p-2 me-3">
                            <i class="fas fa-calendar-check text-success w-20 text-center"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block text-uppercase small-8">Bergabung Sejak</small>
                            <span class="font-weight-600 text-dark">{{ $user->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Status Card -->
        <div class="card shadow-sm border-0 border-start border-4 border-{{ $user->status == 'active' ? 'success' : 'danger' }}">
            <div class="card-body py-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0 text-dark">Status Akun</h6>
                    <small class="text-muted">Status keanggotaan saat ini</small>
                </div>
                <span class="badge rounded-pill bg-{{ $user->status == 'active' ? 'success' : 'danger' }} px-3">
                    {{ $user->status == 'active' ? 'AKTIF' : 'NON-AKTIF' }}
                </span>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Biodata Card -->
        @if($user->warga)
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                <i class="fas fa-fingerprint text-success me-2 shadow-sm p-1 rounded bg-light"></i>
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">Data Identitas Penduduk</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light shadow-xs h-100">
                            <small class="text-muted d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Nomor Induk Kependudukan (NIK)</small>
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 text-success font-weight-bold letter-spacing-1">{{ $user->warga->nik }}</h5>
                                <i class="fas fa-check-circle text-success ms-2 small" title="Terverifikasi"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-white shadow-xs h-100">
                            <small class="text-muted d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Nama Lengkap</small>
                            <h5 class="mb-0 font-weight-bold text-dark">{{ $user->warga->nama_lengkap }}</h5>
                        </div>
                    </div>
                    
                    <div class="col-12"><hr class="my-1 opacity-5"></div>

                    <div class="col-md-4">
                        <div class="mb-1">
                            <small class="text-muted text-uppercase fw-bold small-8">Jenis Kelamin</small>
                            <p class="mb-0 font-weight-600 text-dark d-flex align-items-center">
                                <i class="fas fa-{{ $user->warga->jenis_kelamin == 'Laki-laki' ? 'mars text-success' : 'venus text-pink' }} me-2"></i>
                                {{ $user->warga->jenis_kelamin }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-1">
                            <small class="text-muted text-uppercase fw-bold small-8">Tempat, Tgl Lahir</small>
                            <p class="mb-0 font-weight-600 text-dark">
                                {{ $user->warga->tempat_lahir }}, <span class="text-muted">{{ \Carbon\Carbon::parse($user->warga->tanggal_lahir)->locale('id')->isoFormat('D MMM Y') }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-1">
                            <small class="text-muted text-uppercase fw-bold small-8">Agama</small>
                            <p class="mb-0 font-weight-600 text-dark">{{ $user->warga->agama }}</p>
                        </div>
                    </div>

                    <div class="col-md-4 mt-4">
                        <div class="mb-1">
                            <small class="text-muted text-uppercase fw-bold small-8">Pekerjaan</small>
                            <p class="mb-0 font-weight-600 text-dark">{{ $user->warga->jenis_pekerjaan ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-8 mt-4">
                        <div class="mb-1">
                            <small class="text-muted text-uppercase fw-bold small-8">Alamat Domisili</small>
                            <p class="mb-0 font-weight-600 text-dark d-flex align-items-start">
                                <i class="fas fa-map-marker-alt text-danger me-2 mt-1"></i>
                                {{ $user->warga->alamat }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-0 py-3 text-center">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i> Perubahan data identitas penduduk hanya dapat dilakukan oleh Petugas Administrasi Desa.
                </small>
            </div>
        </div>
        @else
        <div class="card shadow-sm border-0 bg-warning bg-opacity-10 border-start border-4 border-warning">
            <div class="card-body p-4 d-flex">
                <div class="me-4 d-none d-md-block">
                    <i class="fas fa-user-shield fa-3x text-warning"></i>
                </div>
                <div>
                    <h5 class="text-warning-emphasis font-weight-bold">Verifikasi Identitas Diperlukan</h5>
                    <p class="text-dark mb-3 opacity-75">Data akun Anda belum terhubung dengan Manajemen Data Penduduk Desa. Tanpa ini, Anda tidak dapat mengakses layanan surat digital.</p>
                    <a href="#" class="btn btn-warning btn-sm fw-bold">Hubungi Admin Desa</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .font-weight-600 { font-weight: 600; }
    .small-8 { font-size: 0.75rem; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .text-success { color: #2d7d3e !important; }
    .text-pink { color: #e83e8c; }
    .bg-opacity-10 { --bs-bg-opacity: 0.1; }
    .shadow-xs { box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.04); }
    .tracking-wider { letter-spacing: 0.1em; }
    .hover-elevate:hover { transform: translateY(-2px); transition: 0.3s; }
</style>
@endsection
