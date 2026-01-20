@extends('layouts.app')

@section('title', 'Pengaduan Masyarakat')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pengaduan Masyarakat</h1>
    @if(auth()->user()->isWarga())
    <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Buat Pengaduan Baru
    </a>
    @endif
</div>



<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                        <th>Pelapor</th>
                        @endif
                        <th>Judul</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduans as $index => $pengaduan)
                    <tr>
                        <td>{{ $pengaduans->firstItem() + $index }}</td>
                        <td>{{ $pengaduan->created_at->format('d M Y H:i') }}</td>
                        @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                        <td>{{ $pengaduan->user->name ?? 'Warga' }}</td>
                        @endif
                        <td>{{ Str::limit($pengaduan->judul, 30) }}</td>
                        <td>{{ Str::limit($pengaduan->lokasi, 20) }}</td>
                        <td>
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
                        </td>
                        <td>
                            <a href="{{ route('pengaduan.show', $pengaduan) }}" class="btn btn-sm btn-info text-white">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ (auth()->user()->isAdmin() || auth()->user()->isKepalaDesa()) ? 7 : 6 }}" class="text-center py-4">
                            <div class="text-muted">Belum ada data pengaduan</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $pengaduans->links() }}
        </div>
    </div>
</div>
@endsection
