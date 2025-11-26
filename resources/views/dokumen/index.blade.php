@extends('layouts.app')

@section('title', 'Master Dokumen')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Master Dokumen Persyaratan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('dokumen.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Dokumen
        </a>
    </div>
</div>

<!-- Filter & Search -->
<div class="card shadow-sm mb-4">
    <div class="card-body py-2">
        <form action="{{ route('dokumen.index') }}" method="GET" class="row g-2">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama dokumen..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-search me-1"></i>Cari
                </button>
                <a href="{{ route('dokumen.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Data Dokumen -->
<div class="card shadow-sm">
    <div class="card-header py-2">
        <h6 class="m-0 fw-bold text-primary">Daftar Dokumen</h6>
    </div>
    <div class="card-body p-0">
        @if($dokumens->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Nama Dokumen</th>
                            <th>Deskripsi</th>
                            <th>Digunakan di Layanan</th>
                            <th>Tanggal Dibuat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dokumens as $dokumen)
                        <tr>
                            <td class="ps-3">
                                <strong>{{ $dokumen->nama_dokumen }}</strong>
                            </td>
                            <td>
                                @if($dokumen->deskripsi)
                                    {{ Str::limit($dokumen->deskripsi, 80) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($dokumen->persyaratan_count > 0)
                                    <span class="badge bg-primary">{{ $dokumen->persyaratan_count }} Layanan</span>
                                @else
                                    <span class="badge bg-secondary">Belum digunakan</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $dokumen->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm gap-2">
                                    <a href="{{ route('dokumen.show', $dokumen->id) }}" 
                                       class="btn btn-outline-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('dokumen.edit', $dokumen->id) }}" 
                                       class="btn btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST" 
                                          onsubmit="return confirm('Hapus dokumen {{ $dokumen->nama_dokumen }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
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
            <div class="d-flex justify-content-between align-items-center p-3 border-top">
                <div class="text-muted small">
                    Menampilkan {{ $dokumens->firstItem() }} - {{ $dokumens->lastItem() }} dari {{ $dokumens->total() }} dokumen
                </div>
                {{ $dokumens->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-file-alt fa-2x text-muted mb-3"></i>
                <p class="text-muted mb-2">Belum ada data dokumen.</p>
                <a href="{{ route('dokumen.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus me-1"></i>Tambah Dokumen Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection