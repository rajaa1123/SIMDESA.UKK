@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="mb-4">
    <h2>Tambah User Baru</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Manajemen User</a></li>
            <li class="breadcrumb-item active">Tambah User</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                   id="nik" name="nik" value="{{ old('nik') }}" required maxlength="16">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select @error('role_id') is-invalid @enderror" 
                                    id="role_id" name="role_id" required>
                                <option value="">Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            <small class="text-muted">Minimal 6 karakter</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="warga_id" class="form-label">Data Warga (Opsional)</label>
                        <select class="form-select @error('warga_id') is-invalid @enderror" 
                                id="warga_id" name="warga_id">
                            <option value="">Tidak terhubung dengan data warga</option>
                            @foreach($wargas as $warga)
                                <option value="{{ $warga->id }}" {{ old('warga_id') == $warga->id ? 'selected' : '' }}>
                                    {{ $warga->nama }} - NIK: {{ $warga->nik }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih jika user ini adalah warga yang terdaftar</small>
                        @error('warga_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card bg-light">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-info-circle me-2"></i>Informasi</h5>
                <hr>
                <p class="small mb-2"><strong>Role:</strong></p>
                <ul class="small">
                    <li><strong>Admin:</strong> Akses penuh ke semua fitur</li>
                    <li><strong>Kepala Desa:</strong> Dapat approve/reject permohonan</li>
                    <li><strong>Warga:</strong> Hanya dapat mengajukan permohonan</li>
                </ul>
                
                <p class="small mb-2 mt-3"><strong>Status:</strong></p>
                <ul class="small">
                    <li><strong>Active:</strong> User dapat login dan menggunakan sistem</li>
                    <li><strong>Inactive:</strong> User tidak dapat login</li>
                    <li><strong>Suspended:</strong> User dibanned sementara</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
