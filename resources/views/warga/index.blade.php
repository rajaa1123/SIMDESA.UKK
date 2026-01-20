@extends('layouts.app')

@section('title', 'Data Warga')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Warga</h1>

    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('warga.create') }}" class="btn btn-success">
            <i class="fas fa-user-plus me-1"></i>Tambah Warga
        </a>
    </div>
</div>

<!-- Filter & Search -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('warga.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIK..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status_hidup" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="Hidup" {{ request('status_hidup') == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                    <option value="Meninggal" {{ request('status_hidup') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>Cari
                </button>
                <a href="{{ route('warga.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Data Warga -->
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Warga</h6>
    </div>
    <div class="card-body">
        @if($wargas->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>TTL</th>
                            <th>No. HP</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wargas as $warga)
                        <tr>
                            <td>{{ $warga->nik }}</td>
                            <td>
                                <strong>{{ $warga->nama_lengkap }}</strong>
                                @if($warga->kartuKeluarga)
                                    <br><small class="text-muted">KK: {{ $warga->kartuKeluarga->no_kk }}</small>
                                @endif
                            </td>
                            <td>{{ $warga->jenis_kelamin }}</td>
                            <td>
                                {{ $warga->tempat_lahir }}, 
                                {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->format('d-m-Y') }}
                            </td>
                            <td>{{ $warga->no_hp ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $warga->status_hidup == 'Hidup' ? 'success' : 'danger' }}">
                                    {{ $warga->status_hidup }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('warga.show', $warga->id) }}" 
                                       class="btn btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('warga.edit', $warga->id) }}" 
                                       class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('warga.destroy', $warga->id) }}" method="POST" 
                                          class="d-inline" onsubmit="return confirm('Hapus data warga ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $wargas->firstItem() }} - {{ $wargas->lastItem() }} dari {{ $wargas->total() }} warga
                </div>
                {{ $wargas->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada data warga.</p>
                <a href="{{ route('warga.create') }}" class="btn btn-success">
                    <i class="fas fa-user-plus me-1"></i>Tambah Warga Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection