<div class="position-sticky pt-3">
    <div class="sidebar-header text-center text-white mb-4 d-none d-md-block">
        <h5>SIMDESA</h5>
        <small class="text-muted">Sistem Informasi Desa</small>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('dashboard') ? 'active' : '' }}" 
               href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </li>
        
        @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('warga*') ? 'active' : '' }}" 
               href="{{ route('warga.index') }}">
                <i class="fas fa-users me-2"></i>Data Warga
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('kartu-keluarga*') ? 'active' : '' }}" 
               href="{{ route('kartu-keluarga.index') }}">
                <i class="fas fa-address-card me-2"></i>Kartu Keluarga
            </a>
        </li>
        @endif
        
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('layanan*') ? 'active' : '' }}" 
               href="{{ route('layanan.index') }}">
                <i class="fas fa-concierge-bell me-2"></i>Layanan Desa
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('permohonan*') ? 'active' : '' }}" 
               href="{{ route('permohonan.index') }}">
                <i class="fas fa-file-invoice me-2"></i>Pengajuan Layanan
            </a>
        </li>
        
        @if(auth()->user()->isKepalaDesa())
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('approval*') ? 'active' : '' }}" 
               href="{{ route('approval.index') }}">
                <i class="fas fa-check-circle me-2"></i>Approval Layanan
            </a>
        </li>
        @endif
        
        @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('dokumen*') ? 'active' : '' }}" 
               href="{{ route('dokumen.index') }}">
                <i class="fas fa-file-pdf me-2"></i>Dokumen
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('users*') ? 'active' : '' }}" 
               href="{{ route('users.index') }}">
                <i class="fas fa-user-cog me-2"></i>Manajemen User
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('reports*') ? 'active' : '' }}" 
               href="{{ route('reports.index') }}">
                <i class="fas fa-chart-bar me-2"></i>Laporan
            </a>
        </li>
        @endif
    </ul>
</div>