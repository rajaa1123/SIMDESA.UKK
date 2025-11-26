@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        @if(auth()->user()->isAdmin())
            Dashboard Administrator
        @elseif(auth()->user()->isKepalaDesa())
            Dashboard Kepala Desa  
        @else
            Dashboard Warga
        @endif
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <span class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-calendar me-1"></i>
                {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>
</div>

<!-- Welcome Message -->
<div class="alert alert-info mb-4">
    <h5 class="alert-heading">
        <i class="fas fa-user me-2"></i>Selamat datang, {{ auth()->user()->name }}!
    </h5>
    <p class="mb-0">
        @if(auth()->user()->isAdmin())
            Anda login sebagai <strong>Administrator</strong>. Kelola data warga, layanan, dan permohonan dengan mudah.
        @elseif(auth()->user()->isKepalaDesa())
            Anda login sebagai <strong>Kepala Desa</strong>. Pantau kinerja dan akses laporan lengkap.
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('warga.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-user-plus me-2"></i>Tambah Warga
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('permohonan.create') }}" class="btn btn-success w-100">
                            <i class="fas fa-plus me-2"></i>Ajukan Permohonan
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('layanan.index') }}" class="btn btn-info w-100">
                            <i class="fas fa-list me-2"></i>Kelola Layanan
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('reports.index') }}" class="btn btn-warning w-100">
                            <i class="fas fa-chart-bar me-2"></i>Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<!-- Quick Actions untuk Warga -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('permohonan.create') }}" class="btn btn-success w-100">
                            <i class="fas fa-plus me-2"></i>Ajukan Permohonan Baru
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('permohonan.index') }}" class="btn btn-primary w-100">
                            <i class="fas fa-list me-2"></i>Lihat Semua Permohonan
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('layanan.index') }}" class="btn btn-info w-100">
                            <i class="fas fa-concierge-bell me-2"></i>Lihat Layanan Tersedia
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Recent Permohonan -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    @if(auth()->user()->isWarga())
                        Permohonan Terbaru Saya
                    @else
                        Permohonan Terbaru
                    @endif
                </h6>
                <a href="{{ route('permohonan.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @if($recent_permohonan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Resi</th>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                                    <th>Nama Pemohon</th>
                                    @endif
                                    <th>Layanan</th>
                                    <th>Status</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_permohonan as $permohonan)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $permohonan->nomor_resi }}</span>
                                    </td>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                                    <td>{{ $permohonan->user->name }}</td>
                                    @endif
                                    <td>{{ $permohonan->layanan->nama_layanan }}</td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'baru' => 'bg-warning',
                                                'diproses' => 'bg-primary',
                                                'ditolak' => 'bg-danger', 
                                                'selesai' => 'bg-success'
                                            ][$permohonan->status->code] ?? 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $statusClass }}">
                                            {{ $permohonan->status->name }}
                                        </span>
                                    </td>
                                    <td>{{ $permohonan->tanggal_pengajuan->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('permohonan.show', $permohonan->id) }}" 
                                           class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">
                            @if(auth()->user()->isWarga())
                                Belum ada permohonan. <a href="{{ route('permohonan.create') }}">Ajukan permohonan pertama Anda!</a>
                            @else
                                Belum ada permohonan.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection