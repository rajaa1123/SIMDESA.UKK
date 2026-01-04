<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMDESA - @yield('title', 'Dashboard')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #2d7d3e;
            --secondary-green: #4caf50;
            --dark-green: #1b5e20;
            --accent-yellow: #fdd835;
            --sidebar-width: 260px;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
        }
        
        /* Navbar Styling */
        .navbar {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 10px 0;
            z-index: 1030;
        }
        
        .navbar-brand {
            color: white !important;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .navbar-logo {
            height: 40px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
        }
        
        .nav-link:hover {
            color: var(--accent-yellow) !important;
        }
        
        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 80px 0 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            width: var(--sidebar-width);
            background-color: white;
            transition: all 0.3s;
        }
        
        /* Sidebar Link Styling */
        .sidebar .nav-link {
            color: #555 !important;
            padding: 12px 25px;
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: all 0.2s;
        }
        
        .sidebar .nav-link:hover {
            background-color: #f0f7f1;
            color: var(--primary-green) !important;
        }
        
        .sidebar .nav-link.active {
            background-color: #e8f5e9;
            color: var(--primary-green) !important;
            border-left-color: var(--primary-green);
        }
        
        .sidebar .nav-link i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
        }
        
        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #999;
            padding: 10px 25px;
            margin-top: 15px;
            letter-spacing: 0.5px;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            padding-top: 80px;
            min-height: 100vh;
        }
        
        /* Mobile Responsive */
        @media (max-width: 767.98px) {
            .sidebar {
                margin-left: calc(var(--sidebar-width) * -1);
            }
            
            .sidebar.show {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        
        .navbar-toggler {
            border: none;
            color: white !important;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        /* User Dropdown */
        .user-dropdown .dropdown-toggle::after {
            display: none;
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            background-color: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            
            <a class="navbar-brand ms-2" href="#">
                <img src="{{ asset('images/logo-sidoarjo.png') }}" alt="Logo" class="navbar-logo">
                <div class="d-flex flex-column">
                    <span style="line-height: 1.2;">SIMDESA</span>
                    <small style="font-size: 0.7rem; font-weight: 400; opacity: 0.9;">Desa Sidokare</small>
                </div>
            </a>
            
            <div class="ms-auto d-flex align-items-center">
                <div class="dropdown user-dropdown">
                    <a class="nav-link d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="text-end d-none d-md-block">
                            <div style="font-size: 0.9rem; font-weight: 600;">{{ Auth::user()->name }}</div>
                            <div style="font-size: 0.7rem; opacity: 0.8;">{{ optional(Auth::user()->role)->name ?? 'Warga' }}</div>
                        </div>
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><h6 class="dropdown-header">Akun Saya</h6></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2 text-muted"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2 text-muted"></i>Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar bg-white" id="sidebar">
                @include('components.sidebar')
            </div>
            
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Alert Messages -->
                @include('components.alert')
                
                <!-- Page Content -->
                <div class="py-4">
                    @yield('content')
                </div>
                
                <!-- Footer -->
                <footer class="mt-auto py-3 text-center text-muted small">
                    &copy; {{ date('Y') }} Pemerintah Desa Sidokare - Kabupaten Sidoarjo
                </footer>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const isMobile = window.innerWidth < 768;
            
            if (isMobile && !sidebar.contains(event.target) && !event.target.closest('.navbar-toggler')) {
                sidebar.classList.remove('show');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>