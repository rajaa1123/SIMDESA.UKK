@extends('layouts.app')

@section('title', $berita->judul)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Informasi</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($berita->judul, 30) }}</li>
                </ol>
            </nav>

            <article class="bg-white rounded shadow-sm overflow-hidden">
                @if($berita->gambar)
                    <img src="{{ asset('storage/' . $berita->gambar) }}" class="w-100" style="max-height: 400px; object-fit: cover;">
                @endif
                
                <div class="p-4 p-md-5">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge {{ $berita->kategori == 'Pengumuman' ? 'bg-warning' : ($berita->kategori == 'Kegiatan' ? 'bg-info' : 'bg-primary') }} me-3">
                            {{ $berita->kategori }}
                        </span>
                        <span class="text-muted small">
                            <i class="fas fa-calendar-alt me-1"></i> {{ $berita->published_at->format('d F Y') }}
                            <i class="fas fa-user ms-3 me-1"></i> {{ $berita->user->name }}
                        </span>
                    </div>

                    <h1 class="fw-bold mb-4">{{ $berita->judul }}</h1>

                    <div class="content mt-4 leading-relaxed">
                        {!! $berita->konten !!}
                    </div>

                    <hr class="my-5">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                        @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                            <a href="{{ route('berita.edit', $berita->id) }}" class="btn btn-warning text-white">
                                <i class="fas fa-edit me-2"></i>Edit Konten
                            </a>
                        @endif
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>

<style>
    .content {
        line-height: 1.8;
        font-size: 1.1rem;
    }
    .content p {
        margin-bottom: 1.5rem;
    }
    .content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
</style>
@endsection
