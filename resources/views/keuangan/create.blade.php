@extends('layouts.app')

@section('title', 'Catat Transaksi Kas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Catat Transaksi Baru</h1>
    <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Transaksi Kas</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('keuangan.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                                   value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipe Transaksi <span class="text-danger">*</span></label>
                            <select name="tipe" id="tipe" class="form-control @error('tipe') is-invalid @enderror" required>
                                <option value="masuk" {{ old('tipe') == 'masuk' ? 'selected' : '' }}>Pemasukan (Uang Masuk)</option>
                                <option value="keluar" {{ old('tipe') == 'keluar' ? 'selected' : '' }}>Pengeluaran (Uang Keluar)</option>
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
                               value="{{ old('jumlah') }}" placeholder="Contoh: 5000000" required>
                        @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan / Catatan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                  rows="3" placeholder="Contoh: Pencairan Dana Desa Tahap I">{{ old('keterangan') }}</textarea>
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="reset" class="btn btn-light me-md-2">Reset</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Bantuan Pengisian</div>
                        <div class="small text-muted mb-3">Pastikan Anda mencatat transaksi sesuai dengan bukti fisik yang ada.</div>
                        
                        <h6>Kategori Pemasukan:</h6>
                        <ul class="small">
                            @foreach($categoriesMasuk as $cat) <li>{{ $cat }}</li> @endforeach
                        </ul>

                        <h6>Kategori Pengeluaran:</h6>
                        <ul class="small">
                            @foreach($categoriesKeluar as $cat) <li>{{ $cat }}</li> @endforeach
                        </ul>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
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

    function updateCategories() {
        const type = tipeSelect.value;
        const categories = type === 'masuk' ? categoriesMasuk : categoriesKeluar;
        
        kategoriSelect.innerHTML = '';
        categories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat;
            option.textContent = cat;
            if (cat === "{{ old('kategori') }}") option.selected = true;
            kategoriSelect.appendChild(option);
        });
    }

    tipeSelect.addEventListener('change', updateCategories);
    updateCategories(); // Init on load
</script>
@endpush
@endsection
