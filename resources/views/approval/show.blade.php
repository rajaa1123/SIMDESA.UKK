@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-check-circle me-2"></i>Detail Pengajuan Layanan</h2>
                <a href="{{ route('approval.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Informasi Pengajuan -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Informasi Pengajuan</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Nomor Resi</th>
                                    <td><span class="badge bg-secondary fs-6">{{ $permohonan->nomor_resi }}</span></td>
                                </tr>
                                <tr>
                                    <th>Layanan</th>
                                    <td><strong>{{ $permohonan->layanan->nama_layanan }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>{{ $permohonan->layanan->kategori }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <td>{{ $permohonan->tanggal_pengajuan->format('d F Y, H:i') }} WIB</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-warning">{{ $permohonan->status->name }}</span>
                                    </td>
                                </tr>
                                @if($permohonan->keterangan)
                                <tr>
                                    <th>Keterangan dari Warga</th>
                                    <td>{{ $permohonan->keterangan }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Data Pemohon -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-user me-2"></i>Data Pemohon</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Nama Lengkap</th>
                                    <td>{{ $permohonan->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td>{{ $permohonan->user->warga->nik ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $permohonan->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Telepon</th>
                                    <td>{{ $permohonan->user->phone ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($permohonan->adminUser)
                    <!-- Verifikasi Admin -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-user-check me-2"></i>Verifikasi Admin</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Diverifikasi Oleh</th>
                                    <td>{{ $permohonan->adminUser->name }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Verifikasi</th>
                                    <td>{{ $permohonan->admin_approval_date->format('d F Y, H:i') }} WIB</td>
                                </tr>
                                @if($permohonan->admin_note)
                                <tr>
                                    <th>Catatan Admin</th>
                                    <td>{{ $permohonan->admin_note }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Form Approval -->
                <div class="col-lg-4">
                    <!-- Preview Surat PDF -->
                    @if($permohonan->hasHasilSurat())
                    <div class="card shadow mb-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-file-pdf me-2"></i>Preview Surat</h5>
                        </div>
                        <div class="card-body text-center">
                            <p class="text-muted mb-3">
                                <i class="fas fa-check-circle text-success"></i> Surat sudah di-generate oleh Admin
                            </p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('surat.preview', $permohonan) }}" 
                                   class="btn btn-primary" target="_blank">
                                    <i class="fas fa-eye me-1"></i>Preview Surat (Tab Baru)
                                </a>
                                <a href="{{ route('permohonan.download-hasil-surat', $permohonan) }}" 
                                   class="btn btn-outline-secondary">
                                    <i class="fas fa-download me-1"></i>Download PDF
                                </a>
                            </div>
                            <small class="text-muted d-block mt-2">
                                Periksa isi surat sebelum menyetujui
                            </small>
                        </div>
                    </div>
                    @else
                    <div class="card shadow mb-3">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Surat Belum Tersedia</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-0">
                                <i class="fas fa-info-circle"></i> Surat belum di-generate. 
                                Sistem akan otomatis generate saat Anda menyetujui.
                            </p>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Form Approval -->
                    <div class="card shadow sticky-top" style="top: 20px;">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0"><i class="fas fa-gavel me-2"></i>Keputusan Persetujuan</h5>
                        </div>
                        <div class="card-body">
                            <!-- Form Setuju -->
                            <form action="{{ route('approval.approve', $permohonan->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Catatan Kepala Desa (Opsional)</label>
                                    <textarea name="kades_note" class="form-control" rows="3" 
                                              placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100" 
                                        onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')">
                                    <i class="fas fa-check-circle me-1"></i>Setujui Pengajuan
                                </button>
                            </form>

                            <hr>

                            <!-- Form Tolak -->
                            <form action="{{ route('approval.reject', $permohonan->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-danger">
                                        Alasan Penolakan <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="rejection_reason" class="form-control @error('rejection_reason') is-invalid @enderror" 
                                              rows="3" required placeholder="Jelaskan alasan penolakan..."></textarea>
                                    @error('rejection_reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Catatan Tambahan (Opsional)</label>
                                    <textarea name="kades_note" class="form-control" rows="2" 
                                              placeholder="Catatan tambahan jika ada..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger w-100" 
                                        onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">
                                    <i class="fas fa-times-circle me-1"></i>Tolak Pengajuan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline History -->
            @if($permohonan->history->count() > 0)
            <div class="card shadow mt-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Perubahan Status</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($permohonan->history()->orderBy('created_at', 'desc')->get() as $history)
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-circle text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $history->changedBy->name ?? 'System' }}</strong>
                                        <small class="text-muted">{{ $history->created_at->format('d M Y, H:i') }}</small>
                                    </div>
                                    <div class="text-muted">
                                        <span class="badge bg-secondary">{{ $history->fromStatus->name ?? '-' }}</span>
                                        <i class="fas fa-arrow-right mx-2"></i>
                                        <span class="badge bg-primary">{{ $history->toStatus->name ?? '-' }}</span>
                                    </div>
                                    @if($history->note)
                                    <p class="mt-2 mb-0"><em>"{{ $history->note }}"</em></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
