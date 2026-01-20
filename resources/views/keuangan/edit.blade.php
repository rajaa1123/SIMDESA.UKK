@extends('layouts.app')

@section('title', 'Edit Transaksi Kas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Transaksi</h1>
    <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card shadow border-left-warning">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Transaksi</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('keuangan.update', $keuangan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                                   value="{{ old('tanggal', $keuangan->tanggal->format('Y-m-d')) }}" required>
                            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipe Transaksi <span class="text-danger">*</span></label>
                            <select name="tipe" id="tipe" class="form-control @error('tipe') is-invalid @enderror" required>
                                <option value="masuk" {{ old('tipe', $keuangan->tipe) == 'masuk' ? 'selected' : '' }}>Pemasukan (Uang Masuk)</option>
                                <option value="keluar" {{ old('tipe', $keuangan->tipe) == 'keluar' ? 'selected' : '' }}>Pengeluaran (Uang Keluar)</option>
                            </select>
                            @error('tipe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                            <!-- Options will be populated by JS -->
                        </select>
                        @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" 
                               value="{{ old('jumlah', $keuangan->jumlah) }}" placeholder="Contoh: 5000000" required>
                        @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan / Catatan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                  rows="3" placeholder="Contoh: Pencairan Dana Desa Tahap I">{{ old('keterangan', $keuangan->keterangan) }}</textarea>
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>Update Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const categoriesMasuk = @json($categoriesMasuk);
    const categoriesKeluar = @json($categoriesKeluar);
    const tipeSelect = document.getElementById('tipe');
    const kategoriSelect = document.getElementById('kategori');
    const currentKategori = "{{ old('kategori', $keuangan->kategori) }}";

    function updateCategories() {
        const type = tipeSelect.value;
        const categories = type === 'masuk' ? categoriesMasuk : categoriesKeluar;
        
        kategoriSelect.innerHTML = '';
        categories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat;
            option.textContent = cat;
            if (cat === currentKategori) option.selected = true;
            kategoriSelect.appendChild(option);
        });
    }

    tipeSelect.addEventListener('change', updateCategories);
    updateCategories(); // Init on load
</script>
@endpush
@endsection
