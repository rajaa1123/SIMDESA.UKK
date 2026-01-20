@extends('layouts.app')

@section('title', 'Manajemen Informasi Desa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Informasi Desa</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('berita.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Berita/Pengumuman
        </a>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Tanggal Publish</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($beritas as $item)
                    <tr>
                        <td>
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover;">
                            @else
                                <div class="bg-light text-muted d-flex align-items-center justify-content-center border rounded" style="width: 60px; height: 40px;">
                                    <i class="fas fa-image small text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold">{{ $item->judul }}</div>
                            <small class="text-muted">Slug: {{ $item->slug }}</small>
                        </td>
                        <td>
                            <span class="badge {{ $item->kategori == 'Pengumuman' ? 'bg-warning' : ($item->kategori == 'Kegiatan' ? 'bg-info' : 'bg-primary') }}">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->published_at ? $item->published_at->format('d/m/Y H:i') : '-' }}</td>
                        <td>
                            @if($item->published_at && $item->published_at <= now())
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('berita.show', $item->slug) }}" class="btn btn-sm btn-outline-info" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('berita.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Belum ada data berita.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $beritas->links() }}
        </div>
    </div>
</div>
@endsection
