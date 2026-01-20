@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Pengaduan</h1>
    <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Laporan</h6>
                @php
                    $badgeClass = match($pengaduan->status) {
                        'Pending' => 'warning',
                        'Diproses' => 'info',
                        'Selesai' => 'success',
                        'Ditolak' => 'danger',
                        default => 'secondary'
                    };
                @endphp
                <span class="badge bg-{{ $badgeClass }}">{{ $pengaduan->status }}</span>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5 class="font-weight-bold">{{ $pengaduan->judul }}</h5>
                    <small class="text-muted">
                        <i class="fas fa-calendar-alt me-1"></i> {{ $pengaduan->created_at->format('d M Y H:i') }} | 
                        <i class="fas fa-map-marker-alt me-1"></i> {{ $pengaduan->lokasi }} |
                        <i class="fas fa-user me-1"></i> {{ $pengaduan->user->name ?? 'Warga' }}
                    </small>
                </div>

                @if($pengaduan->foto)
                <div class="mb-4 text-center">
                    <img src="{{ Storage::url($pengaduan->foto) }}" class="img-fluid rounded border shadow-sm mb-2" style="max-height: 400px;" alt="Foto Bukti">
                    <div class="mt-2">
                        <a href="{{ Storage::url($pengaduan->foto) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-external-link-alt me-1"></i>Lihat Ukuran Penuh
                        </a>
                        <a href="{{ Storage::url($pengaduan->foto) }}" download class="btn btn-sm btn-primary ms-2">
                            <i class="fas fa-download me-1"></i>Download Foto Bukti
                        </a>
                    </div>
                </div>
                @endif

                <div class="mb-4">
                    <h6>Isi Laporan:</h6>
                    <p class="text-justify border p-3 rounded bg-light">{{ $pengaduan->isi_laporan }}</p>
                </div>

                @if($pengaduan->tanggapan)
                <div class="alert alert-info">
                    <h6><i class="fas fa-comments me-2"></i>Tanggapan Petugas:</h6>
                    <hr>
                    <p class="mb-0">{{ $pengaduan->tanggapan }}</p>
                    <small class="text-muted mt-2 d-block">Diupdate: {{ $pengaduan->updated_at->format('d M Y H:i') }}</small>
                </div>
                @endif
            </div>
            @if(auth()->user()->isWarga() && $pengaduan->status == 'Pending')
            <div class="card-footer">
                 <form action="{{ route('pengaduan.destroy', $pengaduan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash me-1"></i>Hapus Laporan
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Tindak Lanjut</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('pengaduan.update', $pengaduan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Update Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" required>
                            <option value="Pending" {{ $pengaduan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Ditolak" {{ $pengaduan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tanggapan" class="form-label">Tanggapan / Catatan</label>
                        <textarea class="form-control" name="tanggapan" id="tanggapan" rows="4" required placeholder="Berikan tanggapan...">{{ $pengaduan->tanggapan }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        @if($pengaduan->logs->count() > 0)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Pelacakan</h6>
            </div>
            <div class="card-body">
                <div class="timeline-small">
                    @foreach($pengaduan->logs->sortByDesc('created_at') as $log)
                        <div class="timeline-item pb-3 border-start ps-3 position-relative">
                            <span class="timeline-dot"></span>
                            <div class="small fw-bold text-primary">{{ $log->status_sesudahnya }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ $log->created_at->format('d M Y, H:i') }}</div>
                            <div class="small mt-1">{{ $log->pesan }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
    @else
    <div class="col-md-4">
        @if($pengaduan->logs->count() > 0)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Status Pelacakan</h6>
            </div>
            <div class="card-body">
                <div class="timeline-small">
                    @foreach($pengaduan->logs->sortByDesc('created_at') as $log)
                        <div class="timeline-item pb-3 border-start ps-3 position-relative">
                            <span class="timeline-dot"></span>
                            <div class="small fw-bold text-primary">{{ $log->status_sesudahnya }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ $log->created_at->format('d M Y, H:i') }}</div>
                            <div class="small mt-1">{{ $log->pesan }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        
        <div class="card shadow bg-light border-0">
            <div class="card-body">
                <h6>Bantuan:</h6>
                <p class="small text-muted mb-0">Jika laporan Anda belum ditanggapi dalam 3 hari kerja, silakan hubungi kantor desa melalui WhatsApp: <a href="https://wa.me/6281234567890">0812-3456-7890</a></p>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .timeline-dot {
        position: absolute;
        width: 12px;
        height: 12px;
        background-color: var(--primary-green, #2d7d3e);
        border: 2px solid white;
        border-radius: 50%;
        left: -6px;
        top: 0;
    }
    .timeline-item:last-child {
        border-start: 2px solid transparent !important;
    }
    .timeline-item {
        border-start: 2px solid #e9ecef !important;
    }
</style>
@endsection
