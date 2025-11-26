@extends('layouts.app')

@section('title', 'Detail KK - ' . $kartuKeluarga->no_kk)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Kartu Keluarga</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('kartu-keluarga.edit', $kartuKeluarga->id) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <a href="{{ route('kartu-keluarga.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- Data Kartu Keluarga -->
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-address-card me-1"></i>Data Kartu Keluarga
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">No. KK</th>
                        <td><strong>{{ $kartuKeluarga->no_kk }}</strong></td>
                    </tr>
                    <tr>
                        <th>Kepala Keluarga</th>
                        <td><strong>{{ $kartuKeluarga->kepala_keluarga }}</strong></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $kartuKeluarga->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-{{ $kartuKeluarga->status == 'Aktif' ? 'success' : 'secondary' }}">
                                {{ $kartuKeluarga->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Jumlah Anggota</th>
                        <td>
                            <span class="badge bg-primary">{{ $kartuKeluarga->wargas->count() }} Orang</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Anggota Keluarga -->
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-users me-1"></i>Anggota Keluarga
                </h6>
                <span class="badge bg-primary">{{ $kartuKeluarga->wargas->count() }} Orang</span>
            </div>
            <div class="card-body">
                @if($kartuKeluarga->wargas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kartuKeluarga->wargas as $warga)
                                <tr>
                                    <td>
                                        <a href="{{ route('warga.show', $warga->id) }}" class="text-decoration-none">
                                            {{ $warga->nama_lengkap }}
                                        </a>
                                    </td>
                                    <td>{{ $warga->nik }}</td>
                                    <td>
                                        <span class="badge bg-{{ $warga->status_hidup == 'Hidup' ? 'success' : 'danger' }}">
                                            {{ $warga->status_hidup }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-user-slash fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada anggota keluarga</p>
                        <small class="text-muted">Tambahkan warga ke KK ini melalui edit data warga</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <div>
                <small class="text-muted">
                    <i class="fas fa-calendar me-1"></i>
                    Dibuat: {{ $kartuKeluarga->created_at->format('d/m/Y H:i') }} | 
                    Diupdate: {{ $kartuKeluarga->updated_at->format('d/m/Y H:i') }}
                </small>
            </div>
            <div>
                <a href="{{ route('kartu-keluarga.edit', $kartuKeluarga->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>Edit Data
                </a>
                <form action="{{ route('kartu-keluarga.destroy', $kartuKeluarga->id) }}" method="POST" class="d-inline" 
                      onsubmit="return confirm('Hapus kartu keluarga {{ $kartuKeluarga->no_kk }}?')">
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