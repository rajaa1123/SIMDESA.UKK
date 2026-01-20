@extends('layouts.app')

@section('title', 'Edit Layanan - ' . $layanan->nama_layanan)

@section('content')
<div class="container text-start">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary">Edit Layanan Desa</h5>
                    <span class="badge bg-light text-primary border">ID: {{ $layanan->id }}</span>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('layanan.update', $layanan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="nama_layanan" class="form-label fw-bold">Nama Layanan</label>
                            <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror" 
                                   id="nama_layanan" name="nama_layanan" value="{{ old('nama_layanan', $layanan->nama_layanan) }}" required>
                            @error('nama_layanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label fw-bold">Kategori Layanan</label>
                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                @foreach(['Layanan Administrasi Umum', 'Layanan Administrasi Kependudukan', 'Layanan Sosial', 'Layanan Ekonomi', 'Layanan Hukum'] as $cat)
                                    <option value="{{ $cat }}" {{ old('kategori', $layanan->kategori) == $cat ? 'selected' : '' }}>
                                        @php
                                            $label = str_replace('Layanan ', '', $cat);
                                        @endphp
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="template_slug" class="form-label fw-bold">Template Surat Otomatis</label>
                            <select class="form-select @error('template_slug') is-invalid @enderror" id="template_slug" name="template_slug">
                                <option value="">-- Tanpa Template (Hanya Simpan Data) --</option>
                                <option value="surat-keterangan-domisili" {{ old('template_slug', $layanan->template_slug) == 'surat-keterangan-domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                <option value="surat-keterangan-kematian" {{ old('template_slug', $layanan->template_slug) == 'surat-keterangan-kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                                <option value="surat-keterangan-tidak-mampu" {{ old('template_slug', $layanan->template_slug) == 'surat-keterangan-tidak-mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu (SKTM)</option>
                                <option value="surat-pengantar-skck" {{ old('template_slug', $layanan->template_slug) == 'surat-pengantar-skck' ? 'selected' : '' }}>Surat Pengantar SKCK</option>
                                <option value="surat-keterangan-usaha" {{ old('template_slug', $layanan->template_slug) == 'surat-keterangan-usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                            </select>
                            <div class="form-text small">Pilih template jika layanan ini ingin menghasilkan surat secara otomatis setelah disetujui.</div>
                            @error('template_slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi Layanan</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('layanan.index') }}" class="btn btn-light px-4 me-md-2">Batal</a>
                            <button type="submit" class="btn btn-warning px-4 text-dark">
                                <i class="fas fa-save me-2"></i>Perbarui Layanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
