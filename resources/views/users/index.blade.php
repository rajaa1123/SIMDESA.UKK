@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manajemen User</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah User
    </a>
</div>

<!-- Filter -->
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('users.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="">Semua Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="5%">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td>
                            <input type="checkbox" class="user-checkbox" value="{{ $user->id }}">
                        </td>
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                                     class="rounded-circle me-2" width="32" height="32">
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-info">{{ ucfirst($user->role->name) }}</span>
                        </td>
                        <td>
                            @if($user->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($user->status == 'inactive')
                                <span class="badge bg-secondary">Inactive</span>
                            @else
                                <span class="badge bg-danger">Suspended</span>
                            @endif
                        </td>
                        <td>
                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id != auth()->id())
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data user</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Bulk Actions -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div id="bulkActions" style="display: none;">
                <button type="button" class="btn btn-sm btn-success" onclick="bulkAction('activate')">
                    <i class="fas fa-check me-1"></i>Aktifkan
                </button>
                <button type="button" class="btn btn-sm btn-secondary" onclick="bulkAction('deactivate')">
                    <i class="fas fa-ban me-1"></i>Non-aktifkan
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="bulkAction('delete')">
                    <i class="fas fa-trash me-1"></i>Hapus
                </button>
            </div>
            <div class="ms-auto">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Select All Checkboxes
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        toggleBulkActions();
    });

    // Individual Checkbox
    document.querySelectorAll('.user-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkActions);
    });

    function toggleBulkActions() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        const bulkActions = document.getElementById('bulkActions');
        bulkActions.style.display = checkedBoxes.length > 0 ? 'block' : 'none';
    }

    function bulkAction(action) {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        const ids = Array.from(checkedBoxes).map(cb => cb.value);
        
        if (ids.length === 0) {
            alert('Pilih minimal 1 user');
            return;
        }

        let message = '';
        switch(action) {
            case 'activate':
                message = `Aktifkan ${ids.length} user?`;
                break;
            case 'deactivate':
                message = `Non-aktifkan ${ids.length} user?`;
                break;
            case 'delete':
                message = `Hapus ${ids.length} user? Tindakan ini tidak bisa dibatalkan!`;
                break;
        }

        if (confirm(message)) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/users/bulk-${action}`;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            form.innerHTML = `
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="ids" value="${ids.join(',')}">
            `;
            
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush
