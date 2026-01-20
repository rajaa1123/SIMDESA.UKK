@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-check-circle me-2"></i>Approval Pengajuan Layanan</h2>
            </div>



            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Pengajuan Menunggu Persetujuan</h5>
                </div>
                <div class="card-body">
                    @if($pengajuans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Nomor Resi</th>
                                        <th width="20%">Warga</th>
                                        <th width="20%">Layanan</th>
                                        <th width="15%">Tanggal Pengajuan</th>
                                        <th width="15%">Diverifikasi Oleh</th>
                                        <th width="10%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengajuans as $index => $pengajuan)
                                    <tr>
                                        <td>{{ $pengajuans->firstItem() + $index }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $pengajuan->nomor_resi }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $pengajuan->user->name }}</strong><br>
                                            <small class="text-muted">NIK: {{ $pengajuan->user->warga->nik ?? '-' }}</small>
                                        </td>
                                        <td>{{ $pengajuan->layanan->nama_layanan }}</td>
                                        <td>{{ $pengajuan->tanggal_pengajuan->format('d M Y H:i') }}</td>
                                        <td>
                                            @if($pengajuan->adminUser)
                                                <i class="fas fa-user-check text-success me-1"></i>
                                                {{ $pengajuan->adminUser->name }}<br>
                                                <small class="text-muted">{{ $pengajuan->admin_approval_date->format('d M Y') }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('approval.show', $pengajuan->id) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $pengajuans->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Tidak ada pengajuan yang menunggu persetujuan Anda saat ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
