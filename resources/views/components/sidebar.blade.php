<div class="position-sticky">
    <div class="sidebar-header text-center mb-4 d-none d-md-block">
        <h5 class="text-success fw-bold">SIMDESA</h5>
        <div class="small text-muted">Sistem Informasi Desa</div>
    </div>
    
    <ul class="nav flex-column">

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
            <span>Menu Utama</span>
        </h6>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" 
               href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i>Beranda
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->is('berita*') ? 'active' : '' }}" 
               href="{{ route('berita.index') }}">
                <i class="fas fa-newspaper me-2"></i>Informasi Desa
            </a>
        </li>
        
        @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
        <hr class="sidebar-divider">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
            <span>Kependudukan</span>
        </h6>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('warga*') ? 'active' : '' }}" 
               href="{{ route('warga.index') }}">
                <i class="fas fa-users me-2"></i>Data Warga
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('kartu-keluarga*') ? 'active' : '' }}" 
               href="{{ route('kartu-keluarga.index') }}">
                <i class="fas fa-address-card me-2"></i>Kartu Keluarga
            </a>
        </li>
        @endif
        


        <hr class="sidebar-divider">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
            <span>Layanan</span>
        </h6>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('layanan*') ? 'active' : '' }}" 
               href="{{ route('layanan.index') }}">
                <i class="fas fa-concierge-bell me-2"></i>Layanan Desa
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->is('permohonan*') ? 'active' : '' }}" 
               href="{{ route('permohonan.index') }}">
                <i class="fas fa-file-invoice me-2"></i>Pengajuan Layanan
                @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
                    <span id="pending-badge" class="badge bg-danger ms-2 pulse-badge" style="display: none;">0</span>
                @endif
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('pengaduan*') ? 'active' : '' }}" 
               href="{{ route('pengaduan.index') }}">
                <i class="fas fa-bullhorn me-2"></i>Pengaduan
            </a>
        </li>
        
        @if(auth()->user()->isKepalaDesa())
        <li class="nav-item">
            <a class="nav-link {{ request()->is('approval*') ? 'active' : '' }}" 
               href="{{ route('approval.index') }}">
                <i class="fas fa-check-circle me-2"></i>Approval Layanan
                <span id="approval-badge" class="badge bg-danger ms-2 pulse-badge" style="display: none;">0</span>
            </a>
        </li>
        @endif
        
        @if(auth()->user()->isAdmin() || auth()->user()->isKepalaDesa())
        <hr class="sidebar-divider">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
            <span>Administrasi Desa</span>
        </h6>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('keuangan*') ? 'active' : '' }}" 
               href="{{ route('keuangan.index') }}">
                <i class="fas fa-wallet me-2"></i>Manajemen Kas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('assets*') ? 'active' : '' }}" 
               href="{{ route('assets.index') }}">
                <i class="fas fa-boxes me-2"></i>Manajemen Aset
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dokumen*') ? 'active' : '' }}" 
               href="{{ route('dokumen.index') }}">
                <i class="fas fa-file-pdf me-2"></i>Dokumen
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" 
               href="{{ route('users.index') }}">
                <i class="fas fa-user-cog me-2"></i>Manajemen User
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('reports*') ? 'active' : '' }}" 
               href="{{ route('reports.index') }}">
                <i class="fas fa-chart-bar me-2"></i>Laporan
            </a>
        </li>
        @endif
    </ul>
</div>