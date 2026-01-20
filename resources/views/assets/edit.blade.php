@extends('layouts.app')

@section('title', 'Edit Aset - ' . $asset->nama_aset)

@section('content')
<div class="container text-start">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Edit Data Aset</h5>
                    <span class="badge bg-light text-primary border">{{ $asset->kode_aset }}</span>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('assets.update', $asset->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6 text-start">
                                <label class="form-label fw-bold">Nama Aset</label>
                                <input type="text" name="nama_aset" class="form-control @error('nama_aset') is-invalid @enderror" value="{{ old('nama_aset', $asset->nama_aset) }}" required>
                                @error('nama_aset') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 text-start">
                                <label class="form-label fw-bold">Kode Aset</label>
                                <input type="text" name="kode_aset" class="form-control @error('kode_aset') is-invalid @enderror" value="{{ old('kode_aset', $asset->kode_aset) }}" required>
                                @error('kode_aset') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 text-start">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                    @foreach(['Elektronik', 'Kendaraan', 'Mebel', 'Bangunan', 'Tanah', 'Lainnya'] as $cat)
                                        <option value="{{ $cat }}" {{ old('kategori', $asset->kategori) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                                @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 text-start">
                                <label class="form-label fw-bold">Kondisi</label>
                                <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                    @foreach(['Baik', 'Rusak Ringan', 'Rusak Berat'] as $kon)
                                        <option value="{{ $kon }}" {{ old('kondisi', $asset->kondisi) == $kon ? 'selected' : '' }}>{{ $kon }}</option>
                                    @endforeach
                                </select>
                                @error('kondisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 text-start">
                                <label class="form-label fw-bold">Tanggal Perolehan</label>
                                <input type="date" name="tanggal_perolehan" class="form-control @error('tanggal_perolehan') is-invalid @enderror" value="{{ old('tanggal_perolehan', $asset->tanggal_perolehan?->format('Y-m-d')) }}">
                                @error('tanggal_perolehan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 text-start">
                                <label class="form-label fw-bold">Nilai Perolehan (Rp)</label>
                                <input type="number" name="nilai_perolehan" class="form-control @error('nilai_perolehan') is-invalid @enderror" value="{{ old('nilai_perolehan', $asset->nilai_perolehan) }}" min="0" required>
                                @error('nilai_perolehan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">Lokasi / Penyimpanan</label>
                            <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi', $asset->lokasi) }}">
                            @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4 text-start">
                            <label class="form-label fw-bold">Keterangan / Deskripsi</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan', $asset->keterangan) }}</textarea>
                            @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('assets.index') }}" class="btn btn-light me-md-2">Batal</a>
                            <button type="submit" class="btn btn-warning px-4">
                                <i class="fas fa-save me-2"></i>Perbarui Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
