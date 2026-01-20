@extends('layouts.app')

@section('title', 'Detail Warga - ' . $warga->nama_lengkap)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Data Warga</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('warga.edit', $warga->id) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <a href="{{ route('warga.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- Data Pribadi -->
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user me-1"></i>Data Pribadi
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">NIK</th>
                        <td>{{ $warga->nik }}</td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td><strong>{{ $warga->nama_lengkap }}</strong></td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $warga->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <th>Tempat/Tgl Lahir</th>
                        <td>
                            @if($warga->tanggal_lahir)
                                {{ $warga->tempat_lahir }}, {{ $warga->tanggal_lahir->format('d/m/Y') }} ({{ $warga->tanggal_lahir->age }} tahun)
                            @else
                                {{ $warga->tempat_lahir ?? '-' }}, -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Agama</th>
                        <td>{{ $warga->agama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pendidikan</th>
                        <td>{{ $warga->pendidikan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <td>{{ $warga->jenis_pekerjaan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Data Kontak & Status -->
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-address-card me-1"></i>Data Kontak & Status
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Alamat</th>
                        <td>{{ $warga->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>{{ $warga->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status Hidup</th>
                        <td>
                            <span class="badge bg-{{ $warga->status_hidup == 'Hidup' ? 'success' : 'danger' }}">
                                {{ $warga->status_hidup }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Status Domisili</th>
                        <td>{{ $warga->status_domisili ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status Perkawinan</th>
                        <td>{{ $warga->status_perkawinan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kartu Keluarga</th>
                        <td>
                            @if($warga->kartuKeluarga)
                                {{ $warga->kartuKeluarga->no_kk }} - {{ $warga->kartuKeluarga->kepala_keluarga }}
                            @else
                                <span class="text-muted">Belum terdaftar</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Akun User (Jika Ada) -->
@if($warga->user)
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-user-circle me-1"></i>Akun Sistem
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Email</th>
                        <td>{{ $warga->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            <span class="badge bg-primary">{{ $warga->user->role->name }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Daftar</th>
                        <td>{{ $warga->user->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Action Buttons -->
<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <div>
                <small class="text-muted">
                    <i class="fas fa-calendar me-1"></i>
                    Dibuat: {{ $warga->created_at->format('d/m/Y H:i') }} | 
                    Diupdate: {{ $warga->updated_at->format('d/m/Y H:i') }}
                </small>
            </div>
            <div>
                <a href="{{ route('warga.edit', $warga->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>Edit Data
                </a>
                <form action="{{ route('warga.destroy', $warga->id) }}" method="POST" class="d-inline" 
                      onsubmit="return confirm('Hapus data warga {{ $warga->nama_lengkap }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection