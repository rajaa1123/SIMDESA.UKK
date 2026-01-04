@extends('layouts.app')

@section('title', 'Layanan Desa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Layanan Desa</h1>
    @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('layanan.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Layanan
        </a>
    </div>
    @endif
</div>

<!-- Filter & Search -->
@if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
<div class="card shadow mb-4">
    <div class="card-body py-3">
        <form action="{{ route('layanan.index') }}" method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama layanan..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="kategori" class="form-control form-control-sm">
                    <option value="">Semua Kategori</option>
                    <option value="Layanan Administrasi Umum" {{ request('kategori') == 'Layanan Administrasi Umum' ? 'selected' : '' }}>Administrasi Umum</option>
                    <option value="Layanan Administrasi Kependudukan" {{ request('kategori') == 'Layanan Administrasi Kependudukan' ? 'selected' : '' }}>Administrasi Kependudukan</option>
                    <option value="Layanan Sosial" {{ request('kategori') == 'Layanan Sosial' ? 'selected' : '' }}>Sosial</option>
                    <option value="Layanan Ekonomi" {{ request('kategori') == 'Layanan Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                    <option value="Layanan Hukum" {{ request('kategori') == 'Layanan Hukum' ? 'selected' : '' }}>Hukum</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-search me-1"></i>Cari
                </button>
                <a href="{{ route('layanan.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Layanan Cards -->
<div class="row">
    @forelse($layanans as $layanan)
    <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
        <div class="card shadow-sm h-100 layanan-card">
            <div class="card-body">
                <h6 class="card-title fw-bold text-primary">{{ $layanan->nama_layanan }}</h6>
                <span class="badge bg-info mb-2">{{ $layanan->kategori }}</span>
                <p class="card-text small text-muted">{{ Str::limit($layanan->deskripsi, 100) }}</p>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <div class="d-flex justify-content-between align-items-center">
                    @if(auth()->user()->isWarga())
                    <a href="{{ route('permohonan.create') }}?layanan_id={{ $layanan->id }}" 
                       class="btn btn-sm btn-outline-success w-100" title="Ajukan Permohonan">
                        <i class="fas fa-file-alt me-1"></i>Ajukan
                    </a>
                    @endif
                    
                    @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                    <div class="btn-group w-100">
                        <a href="{{ route('layanan.edit', $layanan->id) }}" class="btn btn-sm btn-outline-warning w-50" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('layanan.destroy', $layanan->id) }}" method="POST" 
                              onsubmit="return confirm('Hapus layanan {{ $layanan->nama_layanan }}?')" class="w-50">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-4">
            <i class="fas fa-concierge-bell fa-2x text-muted mb-2"></i>
            <p class="text-muted mb-2">Belum ada layanan tersedia.</p>
            @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
            <a href="{{ route('layanan.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus me-1"></i>Tambah Layanan Pertama
            </a>
            @endif
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($layanans->hasPages())
<div class="row mt-3">
    <div class="col-12">
        <div class="d-flex justify-content-center">
            {{ $layanans->links() }}
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
.layanan-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border: 1px solid #dee2e6;
}
.layanan-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
}
.card {
    font-size: 0.85rem;
}
</style>
@endpush