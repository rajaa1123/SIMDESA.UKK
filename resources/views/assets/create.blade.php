@extends('layouts.app')

@section('title', 'Tambah Aset Baru')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Tambah Aset / Inventaris</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('assets.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Aset</label>
                                <input type="text" name="nama_aset" class="form-control @error('nama_aset') is-invalid @enderror" value="{{ old('nama_aset') }}" placeholder="Contoh: Laptop Kantor" required>
                                @error('nama_aset') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kode Aset</label>
                                <input type="text" name="kode_aset" class="form-control @error('kode_aset') is-invalid @enderror" value="{{ old('kode_aset', 'AST-' . strtoupper(\Illuminate\Support\Str::random(6))) }}" required>
                                @error('kode_aset') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Elektronik">Elektronik</option>
                                    <option value="Kendaraan">Kendaraan</option>
                                    <option value="Mebel">Mebel</option>
                                    <option value="Bangunan">Bangunan</option>
                                    <option value="Tanah">Tanah</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kondisi</label>
                                <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                                @error('kondisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal Perolehan</label>
                                <input type="date" name="tanggal_perolehan" class="form-control @error('tanggal_perolehan') is-invalid @enderror" value="{{ old('tanggal_perolehan') }}">
                                @error('tanggal_perolehan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nilai Perolehan (Rp)</label>
                                <input type="number" name="nilai_perolehan" class="form-control @error('nilai_perolehan') is-invalid @enderror" value="{{ old('nilai_perolehan', 0) }}" min="0" required>
                                @error('nilai_perolehan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Lokasi / Penyimpanan</label>
                            <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}" placeholder="Contoh: Ruang Sekretaris">
                            @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Keterangan / Deskripsi</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('assets.index') }}" class="btn btn-light me-md-2">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Simpan Aset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
