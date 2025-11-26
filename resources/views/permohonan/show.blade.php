@extends('layouts.app')

@section('title', 'Detail Permohonan - ' . $permohonan->nomor_resi)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Permohonan</h1>
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
                    <i class="fas fa-file-alt me-1"></i>Informasi Permohonan
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
                                            'diproses' => 'bg-primary',
                                            'ditolak' => 'bg-danger', 
                                            'selesai' => 'bg-success'
                                        ][$permohonan->status->code] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $statusClass }} fs-6">
                                        {{ $permohonan->status->name }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Biaya Admin</th>
                                <td>
                                    <strong class="{{ $permohonan->biaya_admin > 0 ? 'text-warning' : 'text-success' }}">
                                        Rp {{ number_format($permohonan->biaya_admin, 0, ',', '.') }}
                                    </strong>
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

    <!-- Sidebar Actions -->
    <div class="col-md-4">
        <!-- Quick Actions -->
        <div class="card shadow-sm mb-3">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-success">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                    <a href="{{ route('permohonan.edit', $permohonan->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit Permohonan
                    </a>
                    
                    <!-- Update Status Form -->
                    <form action="{{ route('permohonan.update-status', $permohonan->id) }}" method="POST" class="mt-2">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Update Status</label>
                            <select name="status_id" class="form-control form-control-sm" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $permohonan->status_id == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <textarea name="note" class="form-control form-control-sm" rows="2" 
                                      placeholder="Catatan (opsional)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-sync me-1"></i>Update Status
                        </button>
                    </form>
                    @endif

                    @if(auth()->user()->isWarga())
                    <div class="text-center">
                        <div class="mb-2">
                            <i class="fas fa-info-circle text-info fa-2x"></i>
                        </div>
                        <p class="small text-muted mb-2">
                            Pantau terus status permohonan Anda. Admin akan memproses secepatnya.
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informasi Layanan -->
        <div class="card shadow-sm mb-3">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-info">Informasi Layanan</h6>
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
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i>
                                </a>
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
                
                @if(auth()->user()->isWarga())
                <div class="mt-3">
                    <button class="btn btn-outline-success btn-sm w-100">
                        <i class="fas fa-upload me-1"></i>Unggah Dokumen
                    </button>
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