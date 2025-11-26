@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="mb-4">
    <h2>Edit User</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Manajemen User</a></li>
            <li class="breadcrumb-item active">Edit User</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
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
                                    <option value="{{ $role->id }}" 
                                        {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
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
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="warga_id" class="form-label">Data Warga (Opsional)</label>
                        <select class="form-select @error('warga_id') is-invalid @enderror" 
                                id="warga_id" name="warga_id">
                            <option value="">Tidak terhubung dengan data warga</option>
                            @foreach($wargas as $warga)
                                <option value="{{ $warga->id }}" 
                                    {{ old('warga_id', $user->warga_id) == $warga->id ? 'selected' : '' }}>
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
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
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
                            <i class="fas fa-save me-2"></i>Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                     class="rounded-circle mb-3" width="150" height="150">
                <h5>{{ $user->name }}</h5>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                <span class="badge bg-{{ $user->status == 'active' ? 'success' : ($user->status == 'inactive' ? 'secondary' : 'danger') }}">
                    {{ ucfirst($user->status) }}
                </span>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title">Informasi Tambahan</h6>
                <hr>
                <p class="small mb-1"><strong>Created:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
                <p class="small mb-1"><strong>Last Update:</strong> {{ $user->updated_at->format('d M Y H:i') }}</p>
                <p class="small mb-0"><strong>Last Login:</strong> {{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : 'Never' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
