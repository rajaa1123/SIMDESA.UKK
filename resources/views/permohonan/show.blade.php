@extends('layouts.app')

@section('title', 'Detail Pengajuan - ' . $permohonan->nomor_resi)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Pengajuan Layanan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('permohonan.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- Informasi Utama -->
    <div class="col-md-8">
        <!-- Data Permohonan -->
        <div class="card shadow-sm mb-3">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-primary">
                    <i class="fas fa-file-alt me-1"></i>Informasi Pengajuan
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="40%">No. Resi</th>
                                <td><strong class="text-primary">{{ $permohonan->nomor_resi }}</strong></td>
                            </tr>
                            <tr>
                                <th>Layanan</th>
                                <td>
                                    <strong>{{ $permohonan->layanan->nama_layanan }}</strong>
                                    <br><small class="text-muted">{{ $permohonan->layanan->kategori }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Pengajuan</th>
                                <td>{{ $permohonan->tanggal_pengajuan->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="40%">Status</th>
                                <td>
                                    @php
                                        $statusClass = [
                                            'baru' => 'bg-warning',
                                            'pending' => 'bg-warning',
                                            'diproses' => 'bg-primary',
                                            'menunggu_persetujuan_kades' => 'bg-info',
                                            'ditolak' => 'bg-danger', 
                                            'selesai' => 'bg-success'
                                        ][$permohonan->status->code] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $statusClass }} fs-6">
                                        {{ $permohonan->status->name }}
                                    </span>
                                </td>
                            </tr>
                            @if($permohonan->tanggal_selesai)
                            <tr>
                                <th>Tanggal Selesai</th>
                                <td>{{ $permohonan->tanggal_selesai->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                @if($permohonan->keterangan)
                <div class="mt-3 p-3 bg-light rounded">
                    <strong>Keterangan:</strong>
                    <p class="mb-0">{{ $permohonan->keterangan }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Informasi Pemohon -->
        <div class="card shadow-sm mb-3">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-info">
                    <i class="fas fa-user me-1"></i>Informasi Pemohon
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="40%">Nama</th>
                                <td>{{ $permohonan->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $permohonan->user->email }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="40%">No. HP</th>
                                <td>{{ $permohonan->user->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>
                                    <span class="badge bg-secondary">{{ $permohonan->user->role->name }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hasil Surat Layanan -->
        <div class="card shadow-sm mb-3">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-success">
                    <i class="fas fa-file-pdf me-1"></i>Surat Hasil Layanan
                </h6>
            </div>
            <div class="card-body">
                @if($permohonan->hasHasilSurat())
                    <!-- Jika surat sudah diupload -->
                    <div class="alert alert-success mb-3">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Surat hasil layanan telah tersedia!</strong>
                    </div>
                    
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th width="30%">File</th>
                            <td>{{ $permohonan->hasil_surat_filename }}</td>
                        </tr>
                        <tr>
                            <th>Diupload Oleh</th>
                            <td>{{ $permohonan->hasilSuratUploadedBy->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Upload</th>
                            <td>{{ $permohonan->hasil_surat_uploaded_at?->format('d/m/Y H:i') ?? '-' }}</td>
                        </tr>
                    </table>

                    <div class="d-flex gap-2">
                        @if(auth()->user()->isWarga() && !$permohonan->isSelesai())
                            <div class="alert alert-warning py-2 mb-0 d-flex align-items-center small">
                                <i class="fas fa-lock me-2"></i>
                                <span>Surat dapat didownload setelah disetujui Kepala Desa (Status: Selesai).</span>
                            </div>
                        @else
                            <a href="{{ route('permohonan.download-hasil-surat', $permohonan) }}" 
                               class="btn btn-success btn-sm">
                                <i class="fas fa-download me-1"></i>
                                {{ $permohonan->isSelesai() ? 'Download Surat Sah' : 'Download Draft Surat' }}
                            </a>
                        @endif
                        
                        @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                            <button type="button" class="btn btn-warning btn-sm" 
                                    data-bs-toggle="collapse" data-bs-target="#re-upload-form">
                                <i class="fas fa-redo me-1"></i>Upload Ulang
                            </button>
                        @endif
                    </div>

                    @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                        <div class="collapse mt-3" id="re-upload-form">
                            <div class="border rounded p-3 bg-light">
                                <h6 class="mb-3">Upload Surat Baru (Replace)</h6>
                                <form action="{{ route('permohonan.upload-hasil-surat', $permohonan) }}" 
                                      method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-2">
                                        <input type="file" name="hasil_surat" class="form-control form-control-sm" 
                                               accept=".pdf" required>
                                        <small class="text-muted">Format: PDF, Max: 10MB</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-upload me-1"></i>Upload
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Jika surat belum diupload -->
                    @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Surat hasil belum diupload. Anda dapat mengupload manual atau generate otomatis.
                        </div>
                        
                        <!-- Auto Generate Buttons -->
                        <div class="d-grid gap-2 mb-3">
                            <!-- Direct Generate (No Preview) -->
                            <form action="{{ route('surat.generate', $permohonan) }}" method="POST" 
                                  onsubmit="return confirm('Generate PDF surat otomatis? Nomor surat akan dibuat otomatis.');">
                                @csrf
                                <input type="hidden" name="nomor_surat" value="AUTO">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-magic me-2"></i>Generate Surat Otomatis
                                </button>
                            </form>
                            
                            <!-- Preview First -->
                            <a href="{{ route('surat.preview', $permohonan) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>Preview Dulu Sebelum Generate
                            </a>
                        </div>
                        
                        <div class="alert alert-warning text-center small">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Upload manual dinonaktifkan. Gunakan tombol generate di atas.
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                            <p class="mb-0">Surat hasil layanan belum tersedia. Silakan tunggu admin/kepala desa untuk mengupload surat hasil.</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Digital Signature Verification (BSRE Simulation) -->
        @if($permohonan->is_signed_electronically || $permohonan->kades_digital_signature)
        <div class="card shadow-sm mb-3 border-primary bg-light">
            <div class="card-header py-2 bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold">
                    <i class="fas fa-shield-alt me-1"></i>Verifikasi Tanda Tangan Elektronik
                </h6>
                <span class="badge bg-white text-primary">BSRE Verified</span>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center">
                        @if($permohonan->kades_signature_qr_path)
                            <img src="{{ Storage::url($permohonan->kades_signature_qr_path) }}" class="img-fluid border p-1 bg-white mb-2" style="max-width: 120px;" alt="QR Signature">
                        @else
                            <div class="bg-white border p-3 mb-2 d-inline-block">
                                <i class="fas fa-qrcode fa-4x text-muted"></i>
                            </div>
                        @endif
                        <div class="small text-muted">Scan untuk Verifikasi</div>
                    </div>
                    <div class="col-md-9">
                        <div class="alert alert-light border-0 mb-0 py-2">
                            <p class="small mb-1"><strong>Penandatangan:</strong> {{ $permohonan->kadesUser->name ?? 'Kepala Desa Sidokare' }}</p>
                            <p class="small mb-1"><strong>Waktu:</strong> {{ $permohonan->kades_signature_timestamp?->format('d/m/Y H:i:s') ?? '-' }} WIB</p>
                            <p class="small mb-1"><strong>Doc-ID:</strong> <code>{{ substr($permohonan->digital_signature_hash ?? $permohonan->kades_digital_signature, 0, 16) }}...</code></p>
                            <hr class="my-2">
                            <div class="d-flex align-items-center text-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <span class="small fw-bold">Dokumen ini telah ditandatangani secara elektronik dan memiliki kekuatan hukum yang sah.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- History Status -->
        <div class="card shadow-sm">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-warning">
                    <i class="fas fa-history me-1"></i>Riwayat Status
                </h6>
            </div>
            <div class="card-body">
                @if($permohonan->history->count() > 0)
                    <div class="timeline">
                        @foreach($permohonan->history->sortBy('created_at') as $history)
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="timeline-badge bg-primary me-3">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong>
                                            @if($history->fromStatus && $history->toStatus)
                                                {{ $history->fromStatus->name }} → {{ $history->toStatus->name }}
                                            @elseif($history->toStatus)
                                                → {{ $history->toStatus->name }}
                                            @endif
                                        </strong>
                                        <small class="text-muted">{{ $history->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    @if($history->changedBy)
                                        <small class="text-muted">Oleh: {{ $history->changedBy->name }}</small>
                                    @endif
                                    @if($history->note)
                                        <div class="mt-1 p-2 bg-light rounded small">
                                            <strong>Catatan:</strong> {{ $history->note }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-history fa-2x mb-2"></i>
                        <p>Belum ada riwayat perubahan status</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Info Layanan -->
        <div class="card shadow-sm mb-3">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-info">Informasi Layanan</h6>
            </div>
            <div class="card-body">
                <h6 class="fw-bold">{{ $permohonan->layanan->nama_layanan }}</h6>
                <p class="small mb-2">{{ $permohonan->layanan->deskripsi }}</p>

            </div>
        </div>

        <!-- Dokumen -->
        <div class="card shadow-sm">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-warning">
                    <i class="fas fa-paperclip me-1"></i>Dokumen
                </h6>
            </div>
            <div class="card-body">
                @if($permohonan->attachments->count() > 0)
                    <div class="list-group list-group-flush small">
                        @foreach($permohonan->attachments as $attachment)
                        <div class="list-group-item px-0 py-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file text-muted me-2"></i>
                                    {{ $attachment->nama_file }}
                                </div>
                                <div class="btn-group btn-group-sm">
                                    @if($attachment->isPdf() || $attachment->isImage())
                                        <a href="{{ route('file.stream', $attachment) }}" 
                                           class="btn btn-outline-info" 
                                           target="_blank"
                                           title="Lihat File">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('file.download', $attachment) }}" 
                                       class="btn btn-outline-primary"
                                       title="Download File">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-2">
                        <i class="fas fa-file-upload fa-2x mb-2"></i>
                        <p class="small mb-0">Belum ada dokumen diunggah</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline-badge {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}
.timeline-item {
    position: relative;
}
.timeline-item:not(:last-child):after {
    content: '';
    position: absolute;
    left: 15px;
    top: 40px;
    bottom: -20px;
    width: 2px;
    background: #dee2e6;
}
</style>
@endpush