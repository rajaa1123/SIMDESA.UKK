@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2>Detail User</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Manajemen User</a></li>
                    <li class="breadcrumb-item active">Detail User</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit User
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                     class="rounded-circle mb-3" width="150" height="150">
                <h4>{{ $user->name }}</h4>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                <span class="badge bg-info mb-2">{{ ucfirst($user->role->name) }}</span>
                <br>
                <span class="badge bg-{{ $user->status == 'active' ? 'success' : ($user->status == 'inactive' ? 'secondary' : 'danger') }}">
                    {{ ucfirst($user->status) }}
                </span>
                
                <hr>
                
                <div class="d-grid gap-2">
                    @if($user->status == 'active')
                        <form action="{{ route('users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="inactive">
                            <button type="submit" class="btn btn-sm btn-secondary w-100">
                                <i class="fas fa-ban me-2"></i>Non-aktifkan User
                            </button>
                        </form>
                    @else
                        <form action="{{ route('users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="active">
                            <button type="submit" class="btn btn-sm btn-success w-100">
                                <i class="fas fa-check me-2"></i>Aktifkan User
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-clock me-2"></i>Timeline</h6>
                <hr>
                <div class="small">
                    <p class="mb-2">
                        <i class="fas fa-calendar-plus text-success me-2"></i>
                        <strong>Dibuat:</strong><br>
                        {{ $user->created_at->format('d F Y, H:i') }}
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-calendar-check text-info me-2"></i>
                        <strong>Terakhir Diupdate:</strong><br>
                        {{ $user->updated_at->format('d F Y, H:i') }}
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-sign-in-alt text-primary me-2"></i>
                        <strong>Last Login:</strong><br>
                        {{ $user->last_login_at ? $user->last_login_at->format('d F Y, H:i') : 'Belum pernah login' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Lengkap</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%" class="text-muted">Nama Lengkap</td>
                        <td><strong>{{ $user->name }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Email</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Telepon</td>
                        <td>{{ $user->phone ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Role</td>
                        <td><span class="badge bg-info">{{ ucfirst($user->role->name) }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            <span class="badge bg-{{ $user->status == 'active' ? 'success' : ($user->status == 'inactive' ? 'secondary' : 'danger') }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Data Warga</td>
                        <td>
                            @if($user->warga)
                                <a href="{{ route('warga.show', $user->warga) }}">
                                    {{ $user->warga->nama }} (NIK: {{ $user->warga->nik }})
                                </a>
                            @else
                                <span class="text-muted">Tidak terhubung</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Profil Lengkap</td>
                        <td>
                            @if($user->isProfileComplete())
                                <span class="badge bg-success"><i class="fas fa-check me-1"></i>Lengkap</span>
                            @else
                                <span class="badge bg-warning"><i class="fas fa-exclamation me-1"></i>Belum Lengkap</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Statistik</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h3 class="text-primary">{{ $user->permohonan->count() }}</h3>
                            <p class="text-muted mb-0">Permohonan Diajukan</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h3 class="text-success">{{ $user->processedPermohonan->count() }}</h3>
                            <p class="text-muted mb-0">Permohonan Diproses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @if($user->permohonan->count() > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Riwayat Permohonan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No Permohonan</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->permohonan->take(5) as $permohonan)
                            <tr>
                                <td>{{ $permohonan->nomor_permohonan }}</td>
                                <td>{{ $permohonan->layanan->nama }}</td>
                                <td>
                                    <span class="badge bg-{{ $permohonan->status->color ?? 'secondary' }}">
                                        {{ $permohonan->status->nama }}
                                    </span>
                                </td>
                                <td>{{ $permohonan->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($user->permohonan->count() > 5)
                    <a href="{{ route('permohonan.index', ['user_id' => $user->id]) }}" class="btn btn-sm btn-link">
                        Lihat semua permohonan ({{ $user->permohonan->count() }})
                    </a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar User
    </a>
</div>
@endsection
