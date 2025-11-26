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
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            transition: all 0.3s;
        }
        
        .main-content {
            margin-left: 240px;
            transition: all 0.3s;
        }
        
        @media (max-width: 767.98px) {
            .sidebar {
                margin-left: -240px;
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
        }
    nav[role="navigation"] span.inline-flex a {
            text-decoration: none;
        }
        
    nav[role="navigation"] span[aria-current="page"]  span{
            background-color: #0d6efd;
            color: white;
        }
        
 
        nav[role="navigation"] span.inline-flex a svg{
            width: 30px;

        }

         nav[role="navigation"] div.flex ,
           nav[role="navigation"] span[aria-disabled="true"]{
            display: none;
         }
           nav[role="navigation"] div p {
            display: none;
           }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-light bg-light shadow-sm fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler d-md-none" type="button" onclick="toggleSidebar()">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="navbar-brand d-none d-md-block">
                <strong>SIMDESA</strong>
                <small class="text-muted">Sistem Informasi Desa</small>
            </div>
            
            <div class="navbar-nav flex-row">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
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
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar" id="sidebar">
                @include('components.sidebar')
            </div>
            
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content" style="margin-top: 60px;">
                <!-- Alert Messages -->
                @include('components.alert')
                
                <!-- Page Content -->
                <div class="container-fluid py-4">
                    @yield('content')
                </div>
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
            
            if (isMobile && !sidebar.contains(event.target) && !event.target.classList.contains('navbar-toggler')) {
                sidebar.classList.remove('show');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>