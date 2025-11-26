@extends('layouts.app')

@section('title', 'Data Kartu Keluarga')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Kartu Keluarga</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('kartu-keluarga.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-1"></i>Tambah KK
        </a>
    </div>
</div>

<!-- Filter & Search -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('kartu-keluarga.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari No. KK atau Kepala Keluarga..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>Cari
                </button>
                <a href="{{ route('kartu-keluarga.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Data Kartu Keluarga -->
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kartu Keluarga</h6>
    </div>
    <div class="card-body">
        @if($kartuKeluargas->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No. KK</th>
                            <th>Kepala Keluarga</th>
                            <th>Alamat</th>
                            <th>Jumlah Anggota</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kartuKeluargas as $kk)
                        <tr>
                            <td>
                                <strong>{{ $kk->no_kk }}</strong>
                            </td>
                            <td>
                                <strong>{{ $kk->kepala_keluarga }}</strong>
                            </td>
                            <td>
                                {{ Str::limit($kk->alamat, 50) }}
                                @if(strlen($kk->alamat) > 50)
                                    <a href="#" data-bs-toggle="tooltip" title="{{ $kk->alamat }}">
                                        <i class="fas fa-info-circle text-info"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $kk->wargas_count }} Orang</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $kk->status == 'Aktif' ? 'success' : 'secondary' }}">
                                    {{ $kk->status }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('kartu-keluarga.show', $kk->id) }}" 
                                       class="btn btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kartu-keluarga.edit', $kk->id) }}" 
                                       class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kartu-keluarga.destroy', $kk->id) }}" method="POST" 
                                          class="d-inline" onsubmit="return confirm('Hapus kartu keluarga {{ $kk->no_kk }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $kartuKeluargas->firstItem() }} - {{ $kartuKeluargas->lastItem() }} dari {{ $kartuKeluargas->total() }} KK
                </div>
                {{ $kartuKeluargas->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-address-card fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada data kartu keluarga.</p>
                <a href="{{ route('kartu-keluarga.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i>Tambah Kartu Keluarga Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
@endpush