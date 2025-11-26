@extends('layouts.app')

@section('title', 'Edit Permohonan - ' . $permohonan->nomor_resi)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Permohonan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('permohonan.show', $permohonan->id) }}" class="btn btn-info btn-sm me-2">
            <i class="fas fa-eye me-1"></i>Detail
        </a>
        <a href="{{ route('permohonan.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-primary">Form Edit Permohonan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('permohonan.update', $permohonan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Informasi Dasar -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">No. Resi</label>
                            <p class="form-control-plaintext">{{ $permohonan->nomor_resi }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Pengajuan</label>
                            <p class="form-control-plaintext">{{ $permohonan->tanggal_pengajuan->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Layanan -->
                    <div class="mb-3">
                        <label for="layanan_id" class="form-label">Layanan <span class="text-danger">*</span></label>
                        <select class="form-control @error('layanan_id') is-invalid @enderror" 
                                id="layanan_id" name="layanan_id" required>
                            @foreach($layanans as $layanan)
                                <option value="{{ $layanan->id }}" 
                                    {{ old('layanan_id', $permohonan->layanan_id) == $layanan->id ? 'selected' : '' }}>
                                    {{ $layanan->nama_layanan }} ({{ $layanan->durasi_proses }} - {{ $layanan->biaya }})
                                </option>
                            @endforeach
                        </select>
                        @error('layanan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status_id" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status_id') is-invalid @enderror" 
                                id="status_id" name="status_id" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" 
                                    {{ old('status_id', $permohonan->status_id) == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Processor -->
                    <div class="mb-3">
                        <label for="processor_user_id" class="form-label">Ditangani Oleh</label>
                        <select class="form-control @error('processor_user_id') is-invalid @enderror" 
                                id="processor_user_id" name="processor_user_id">
                            <option value="">-- Pilih Processor --</option>
                            @foreach($processors as $processor)
                                <option value="{{ $processor->id }}" 
                                    {{ old('processor_user_id', $permohonan->processor_user_id) == $processor->id ? 'selected' : '' }}>
                                    {{ $processor->name }} ({{ $processor->role->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('processor_user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Biaya Admin -->
                    <div class="mb-3">
                        <label for="biaya_admin" class="form-label">Biaya Admin</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('biaya_admin') is-invalid @enderror" 
                                   id="biaya_admin" name="biaya_admin" 
                                   value="{{ old('biaya_admin', $permohonan->biaya_admin) }}" 
                                   min="0" step="500">
                        </div>
                        @error('biaya_admin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="datetime-local" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                               id="tanggal_selesai" name="tanggal_selesai" 
                               value="{{ old('tanggal_selesai', $permohonan->tanggal_selesai ? $permohonan->tanggal_selesai->format('Y-m-d\TH:i') : '') }}">
                        @error('tanggal_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" name="keterangan" rows="4">{{ old('keterangan', $permohonan->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('permohonan.show', $permohonan->id) }}" class="btn btn-secondary btn-sm me-2">Batal</a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-1"></i>Update Permohonan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Informasi Pemohon -->
        <div class="card shadow-sm mb-3">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-info">Informasi Pemohon</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-user-circle text-muted me-2"></i>
                    <div>
                        <strong>{{ $permohonan->user->name }}</strong>
                        <br>
                        <small class="text-muted">{{ $permohonan->user->email }}</small>
                    </div>
                </div>
                <div class="small">
                    <div><strong>No. HP:</strong> {{ $permohonan->user->phone ?? '-' }}</div>
                    <div><strong>Role:</strong> {{ $permohonan->user->role->name }}</div>
                </div>
            </div>
        </div>

        <!-- Informasi Layanan -->
        <div class="card shadow-sm mb-3">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-warning">Informasi Layanan</h6>
            </div>
            <div class="card-body">
                <h6 class="fw-bold">{{ $permohonan->layanan->nama_layanan }}</h6>
                <p class="small mb-2">{{ $permohonan->layanan->deskripsi }}</p>
                <div class="row text-center small">
                    <div class="col-6 border-end">
                        <div class="text-muted">Durasi</div>
                        <div class="fw-bold text-info">{{ $permohonan->layanan->durasi_proses }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted">Biaya</div>
                        <div class="fw-bold {{ $permohonan->layanan->biaya == 'Gratis' ? 'text-success' : 'text-warning' }}">
                            {{ $permohonan->layanan->biaya }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow-sm">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-success">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('permohonan.show', $permohonan->id) }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-eye me-1"></i>Lihat Detail
                    </a>
                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="document.getElementById('status_id').value = 2">
                        <i class="fas fa-play me-1"></i>Set Sedang Diproses
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm" onclick="setSelesai()">
                        <i class="fas fa-check me-1"></i>Set Selesai
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function setSelesai() {
    document.getElementById('status_id').value = 4; // Selesai
    document.getElementById('tanggal_selesai').value = new Date().toISOString().slice(0, 16);
    document.getElementById('processor_user_id').value = {{ auth()->id() }}; // Current user sebagai processor
}
</script>
@endpush