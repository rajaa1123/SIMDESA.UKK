@extends('layouts.app')

@section('title', 'Informasi Desa')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold">Pusat Informasi Desa</h2>
            <p class="text-muted">Dapatkan berita dan pengumuman terbaru seputar Desa Sidokare.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="btn-group shadow-sm">
                <a href="{{ route('berita.index') }}" class="btn btn-outline-primary {{ !request('kategori') ? 'active' : '' }}">Semua</a>
                <a href="{{ route('berita.index', ['kategori' => 'Berita']) }}" class="btn btn-outline-primary {{ request('kategori') == 'Berita' ? 'active' : '' }}">Berita</a>
                <a href="{{ route('berita.index', ['kategori' => 'Pengumuman']) }}" class="btn btn-outline-primary {{ request('kategori') == 'Pengumuman' ? 'active' : '' }}">Pengumuman</a>
            </div>
        </div>
    </div>

    @if($beritas->count() > 0)
        <div class="row g-4">
            @foreach($beritas as $item)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-newspaper fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge {{ $item->kategori == 'Pengumuman' ? 'bg-warning' : ($item->kategori == 'Kegiatan' ? 'bg-info' : 'bg-primary') }}">
                                    {{ $item->kategori }}
                                </span>
                                <small class="text-muted">{{ $item->published_at->format('d M Y') }}</small>
                            </div>
                            <h5 class="card-title fw-bold">
                                <a href="{{ route('berita.show', $item->slug) }}" class="text-decoration-none text-dark">{{ $item->judul }}</a>
                            </h5>
                            <p class="card-text text-muted">
                                {{ Str::limit(strip_tags($item->konten), 100) }}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-3">
                            <a href="{{ route('berita.show', $item->slug) }}" class="btn btn-sm btn-link p-0 text-primary text-decoration-none fw-bold">
                                Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $beritas->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <img src="{{ asset('images/no-data.svg') }}" alt="No Data" class="mb-3" style="width: 200px; opacity: 0.5;">
            <h5 class="text-muted">Belum ada berita atau pengumuman saat ini.</h5>
        </div>
    @endif
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .transition {
        transition: all 0.3s ease;
    }
</style>
@endsection
