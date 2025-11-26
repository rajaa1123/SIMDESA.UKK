<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMDESA - Sistem Informasi Manajemen Desa</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-link {
            font-weight: 500;
            color: #333 !important;
            margin: 0 10px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
        
        .btn-outline-custom {
            border: 2px solid #667eea;
            color: #667eea;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
        }
        
        .btn-outline-custom:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-content {
            z-index: 2;
            animation: fadeInUp 1s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            color: white;
            margin-bottom: 20px;
            line-height: 1.2;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 40px;
            font-weight: 300;
        }
        
        .hero-buttons .btn {
            margin: 0 10px;
            padding: 15px 40px;
            font-size: 1.1rem;
        }
        
        .btn-white-custom {
            background: white;
            color: #667eea;
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }
        
        .btn-white-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(255, 255, 255, 0.5);
            color: #667eea;
        }
        
        .btn-outline-white {
            border: 2px solid white;
            color: white;
            background: transparent;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-white:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
        }
        
        .hero-image {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        .hero-image img {
            max-width: 100%;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.3));
        }
        
        /* Floating Shapes Background */
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float-shape 15s ease-in-out infinite;
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }
        
        .shape-2 {
            width: 200px;
            height: 200px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }
        
        .shape-3 {
            width: 150px;
            height: 150px;
            bottom: 20%;
            left: 15%;
            animation-delay: 4s;
        }
        
        @keyframes float-shape {
            0%, 100% {
                transform: translateY(0px) translateX(0px);
            }
            25% {
                transform: translateY(-30px) translateX(30px);
            }
            50% {
                transform: translateY(-60px) translateX(-30px);
            }
            75% {
                transform: translateY(-30px) translateX(-60px);
            }
        }
        
        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: white;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .section-subtitle {
            text-align: center;
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 60px;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2);
            border-color: #667eea;
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: rotateY(180deg);
        }
        
        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }
        
        .feature-desc {
            color: #666;
            line-height: 1.7;
        }
        
        /* Stats Section */
        .stats-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .stat-card {
            text-align: center;
            padding: 30px;
        }
        
        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 300;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            text-align: center;
            color: white;
        }
        
        .cta-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .cta-text {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.95;
        }
        
        /* Footer */
        .footer {
            background: #1a1a2e;
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .footer-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .footer-link:hover {
            color: white;
            padding-left: 10px;
        }
        
        .social-icons a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 40px;
            padding-top: 30px;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-buttons .btn {
                padding: 12px 30px;
                margin: 5px 0;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-building me-2"></i>SIMDESA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#stats">Statistik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item ms-3">
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary-custom">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </li>
                        @else
                            <li class="nav-item ms-3">
                                <a href="{{ route('login') }}" class="btn btn-outline-custom">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </a>
                            </li>
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <!-- Floating Shapes -->
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">Sistem Informasi Manajemen Desa</h1>
                    <p class="hero-subtitle">
                        Platform digital terpadu untuk mengelola administrasi desa dengan mudah, cepat, dan efisien. Tingkatkan pelayanan kepada warga dengan teknologi modern.
                    </p>
                    <div class="hero-buttons">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-white-custom">
                                <i class="fas fa-rocket me-2"></i>Mulai Sekarang
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="btn btn-white-custom">
                                <i class="fas fa-tachometer-alt me-2"></i>Ke Dashboard
                            </a>
                        @endguest
                        <a href="#features" class="btn btn-outline-white">
                            <i class="fas fa-info-circle me-2"></i>Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 hero-image">
                    <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:rgba(255,255,255,0.9)" />
                                <stop offset="100%" style="stop-color:rgba(255,255,255,0.5)" />
                            </linearGradient>
                        </defs>
                        <!-- Buildings -->
                        <rect x="100" y="200" width="80" height="200" fill="url(#gradient)" rx="5"/>
                        <rect x="200" y="150" width="100" height="250" fill="url(#gradient)" rx="5"/>
                        <rect x="320" y="180" width="80" height="220" fill="url(#gradient)" rx="5"/>
                        <!-- Windows -->
                        <rect x="115" y="220" width="15" height="20" fill="rgba(102, 126, 234, 0.3)" rx="2"/>
                        <rect x="145" y="220" width="15" height="20" fill="rgba(102, 126, 234, 0.3)" rx="2"/>
                        <rect x="115" y="260" width="15" height="20" fill="rgba(102, 126, 234, 0.3)" rx="2"/>
                        <rect x="145" y="260" width="15" height="20" fill="rgba(102, 126, 234, 0.3)" rx="2"/>
                        <rect x="220" y="180" width="20" height="25" fill="rgba(102, 126, 234, 0.3)" rx="2"/>
                        <rect x="260" y="180" width="20" height="25" fill="rgba(102, 126, 234, 0.3)" rx="2"/>
                        <rect x="220" y="230" width="20" height="25" fill="rgba(102, 126, 234, 0.3)" rx="2"/>
                        <rect x="260" y="230" width="20" height="25" fill="rgba(102, 126, 234, 0.3)" rx="2"/>
                        <!-- Data flow animation -->
                        <circle cx="250" cy="100" r="40" fill="rgba(255,255,255,0.9)" opacity="0.8">
                            <animate attributeName="r" values="40;50;40" dur="2s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.8;0.4;0.8" dur="2s" repeatCount="indefinite"/>
                        </circle>
                        <path d="M 250 140 L 250 180" stroke="white" stroke-width="3" stroke-dasharray="5,5">
                            <animate attributeName="stroke-dashoffset" from="0" to="10" dur="0.5s" repeatCount="indefinite"/>
                        </path>
                        <text x="250" y="110" text-anchor="middle" fill="#667eea" font-size="20" font-weight="bold">DATA</text>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <p class="section-subtitle">Solusi lengkap untuk manajemen administrasi desa modern</p>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="feature-title">Manajemen Warga</h3>
                        <p class="feature-desc">Kelola data kependudukan dan kartu keluarga dengan sistem database yang terorganisir dan mudah diakses.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3 class="feature-title">Layanan Permohonan</h3>
                        <p class="feature-desc">Proses permohonan surat dan dokumen secara digital dengan tracking status real-time.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h3 class="feature-title">Laporan & Analitik</h3>
                        <p class="feature-desc">Dashboard analitik komprehensif dengan visualisasi data untuk pengambilan keputusan.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Keamanan Data</h3>
                        <p class="feature-desc">Sistem keamanan berlapis dengan enkripsi data dan kontrol akses berbasis role.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="feature-title">Mobile Friendly</h3>
                        <p class="feature-desc">Akses sistem dari berbagai perangkat dengan tampilan responsive dan user-friendly.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3 class="feature-title">Activity Log</h3>
                        <p class="feature-desc">Tracking semua aktivitas pengguna untuk audit trail dan transparency penuh.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section" id="stats">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">99%</div>
                        <div class="stat-label">Tingkat Kepuasan</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Akses Online</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">100+</div>
                        <div class="stat-label">Jenis Layanan</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">Fast</div>
                        <div class="stat-label">Pemrosesan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="contact">
        <div class="container">
            <h2 class="cta-title">Siap Memulai Transformasi Digital?</h2>
            <p class="cta-text">Bergabunglah dengan sistem manajemen desa modern untuk pelayanan yang lebih baik</p>
            @guest
                <a href="{{ route('login') }}" class="btn btn-white-custom btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Login Sekarang
                </a>
            @else
                <a href="{{ url('/dashboard') }}" class="btn btn-white-custom btn-lg">
                    <i class="fas fa-tachometer-alt me-2"></i>Ke Dashboard
                </a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h3 class="footer-title">
                        <i class="fas fa-building me-2"></i>SIMDESA
                    </h3>
                    <p class="text-white-50">
                        Sistem Informasi Manajemen Desa yang memudahkan administrasi dan pelayanan kepada masyarakat.
                    </p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-title">Menu</h5>
                    <a href="#features" class="footer-link">Fitur</a>
                    <a href="#stats" class="footer-link">Statistik</a>
                    <a href="{{ route('login') }}" class="footer-link">Login</a>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-title">Layanan</h5>
                    <a href="#" class="footer-link">Surat Menyurat</a>
                    <a href="#" class="footer-link">Data Kependudukan</a>
                    <a href="#" class="footer-link">Laporan Desa</a>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5 class="footer-title">Kontak</h5>
                    <p class="text-white-50">
                        <i class="fas fa-map-marker-alt me-2"></i>Kantor Desa
                    </p>
                    <p class="text-white-50">
                        <i class="fas fa-phone me-2"></i>(021) 1234-5678
                    </p>
                    <p class="text-white-50">
                        <i class="fas fa-envelope me-2"></i>info@simdesa.id
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="mb-0">&copy; {{ date('Y') }} SIMDESA. All rights reserved. Built with <i class="fas fa-heart text-danger"></i> for better village administration.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.2)';
            } else {
                navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.1)';
            }
        });
        
        // Counter animation for stats
        const observerOptions = {
            threshold: 0.5
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.stat-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>
