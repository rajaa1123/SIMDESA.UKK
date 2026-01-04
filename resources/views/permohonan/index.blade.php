@extends('layouts.app')

@section('title', 'Data Pengajuan Layanan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        @if(auth()->user()->isWarga())
            Pengajuan Saya
        @else
            Data Pengajuan Layanan
        @endif
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('permohonan.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus me-1"></i>Ajukan Layanan
        </a>
    </div>
</div>

<!-- Filter & Search -->
<div class="card shadow-sm mb-4">
    <div class="card-body py-2">
        <form action="{{ route('permohonan.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari no. resi..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status_id" class="form-control form-control-sm">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="layanan_id" class="form-control form-control-sm">
                    <option value="">Semua Layanan</option>
                    @foreach($layanans as $layanan)
                        <option value="{{ $layanan->id }}" {{ request('layanan_id') == $layanan->id ? 'selected' : '' }}>
                            {{ $layanan->nama_layanan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-search me-1"></i>Cari
                </button>
                <a href="{{ route('permohonan.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Data Permohonan -->
<div class="card shadow-sm">
    <div class="card-header py-2">
        <h6 class="m-0 fw-bold text-primary">Daftar Pengajuan Layanan</h6>
    </div>
    <div class="card-body p-0">
        @if($permohonans->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">No. Resi</th>
                            @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                            <th>Pemohon</th>
                            @endif
                            <th>Layanan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permohonans as $permohonan)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-bold text-primary">{{ $permohonan->nomor_resi }}</span>
                            </td>
                            @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-user-circle text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <div class="fw-semibold">{{ $permohonan->user->name }}</div>
                                        <small class="text-muted">{{ $permohonan->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            @endif
                            <td>
                                <div class="fw-semibold">{{ $permohonan->layanan->nama_layanan }}</div>
                                <small class="text-muted">{{ $permohonan->layanan->kategori }}</small>
                            </td>
                            <td>
                                <div>{{ $permohonan->tanggal_pengajuan->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $permohonan->tanggal_pengajuan->format('H:i') }}</small>
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'pending' => 'bg-warning',
                                        'menunggu_persetujuan_kades' => 'bg-info',
                                        'baru' => 'bg-warning',
                                        'diproses' => 'bg-primary',
                                        'ditolak' => 'bg-danger', 
                                        'selesai' => 'bg-success'
                                    ][$permohonan->status->code] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    {{ $permohonan->status->name }}
                                </span>
                                @if($permohonan->processor)
                                    <small class="d-block text-muted">Oleh: {{ $permohonan->processor->name }}</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm gap-2">
                                    <a href="{{ route('permohonan.show', $permohonan->id) }}" 
                                       class="btn btn-outline-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                                    <a href="{{ route('permohonan.edit', $permohonan->id) }}" 
                                       class="btn btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center p-3 border-top">
                <div class="text-muted small">
                    Menampilkan {{ $permohonans->firstItem() }} - {{ $permohonans->lastItem() }} dari {{ $permohonans->total() }} permohonan
                </div>
                {{ $permohonans->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-file-alt fa-2x text-muted mb-3"></i>
                <p class="text-muted mb-2">
                    @if(auth()->user()->isWarga())
                        Belum ada pengajuan.
                    @else
                        Belum ada data pengajuan.
                    @endif
                </p>
                <a href="{{ route('permohonan.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus me-1"></i>Ajukan Layanan Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection