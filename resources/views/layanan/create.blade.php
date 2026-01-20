@extends('layouts.app')

@section('title', 'Tambah Layanan Baru')

@section('content')
<div class="container text-start">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary">Tambah Layanan Desa Baru</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('layanan.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nama_layanan" class="form-label fw-bold">Nama Layanan</label>
                            <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror" 
                                   id="nama_layanan" name="nama_layanan" value="{{ old('nama_layanan') }}" 
                                   placeholder="Contoh: Surat Keterangan Domisili" required>
                            @error('nama_layanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label fw-bold">Kategori Layanan</label>
                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Layanan Administrasi Umum" {{ old('kategori') == 'Layanan Administrasi Umum' ? 'selected' : '' }}>Administrasi Umum</option>
                                <option value="Layanan Administrasi Kependudukan" {{ old('kategori') == 'Layanan Administrasi Kependudukan' ? 'selected' : '' }}>Administrasi Kependudukan</option>
                                <option value="Layanan Sosial" {{ old('kategori') == 'Layanan Sosial' ? 'selected' : '' }}>Sosial</option>
                                <option value="Layanan Ekonomi" {{ old('kategori') == 'Layanan Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                <option value="Layanan Hukum" {{ old('kategori') == 'Layanan Hukum' ? 'selected' : '' }}>Hukum</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="template_slug" class="form-label fw-bold">Template Surat Otomatis</label>
                            <select class="form-select @error('template_slug') is-invalid @enderror" id="template_slug" name="template_slug">
                                <option value="">-- Tanpa Template (Hanya Simpan Data) --</option>
                                <option value="surat-keterangan-domisili" {{ old('template_slug') == 'surat-keterangan-domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                <option value="surat-keterangan-kematian" {{ old('template_slug') == 'surat-keterangan-kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                                <option value="surat-keterangan-tidak-mampu" {{ old('template_slug') == 'surat-keterangan-tidak-mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu (SKTM)</option>
                                <option value="surat-pengantar-skck" {{ old('template_slug') == 'surat-pengantar-skck' ? 'selected' : '' }}>Surat Pengantar SKCK</option>
                                <option value="surat-keterangan-usaha" {{ old('template_slug') == 'surat-keterangan-usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                            </select>
                            <div class="form-text small">Pilih template jika layanan ini ingin menghasilkan surat secara otomatis setelah disetujui.</div>
                            @error('template_slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi Layanan</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="4" 
                                      placeholder="Jelaskan mengenai prosedur atau kegunaan layanan ini..." required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('layanan.index') }}" class="btn btn-light px-4 me-md-2">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Simpan Layanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
