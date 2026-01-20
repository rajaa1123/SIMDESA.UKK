@extends('layouts.app')

@section('title', 'Tambah Berita/Pengumuman')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Tambah Konten Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Judul</label>
                                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Masukkan judul berita/pengumuman" required>
                                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Konten</label>
                                    <textarea name="konten" id="editor" class="form-control @error('konten') is-invalid @enderror" rows="15">{{ old('konten') }}</textarea>
                                    @error('konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Kategori</label>
                                    <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                        <option value="Berita" {{ old('kategori') == 'Berita' ? 'selected' : '' }}>Berita</option>
                                        <option value="Pengumuman" {{ old('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                        <option value="Kegiatan" {{ old('kategori') == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                    </select>
                                    @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tanggal Publish</label>
                                    <input type="datetime-local" name="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                                    @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Gambar Cover</label>
                                    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">Maksimal 2MB (JPEG, PNG, JPG)</small>
                                    @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <hr>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-2"></i>Terbitkan
                                    </button>
                                    <a href="{{ route('berita.index') }}" class="btn btn-light">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
