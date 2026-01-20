<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMDESA - Sistem Informasi Desa SIDOKARE</title>
    
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
        
        :root {
            --primary-green: #2d7d3e;
            --secondary-green: #4caf50;
            --light-green: #81c784;
            --dark-green: #1b5e20;
            --accent-yellow: #fdd835;
            --white: #ffffff;
            --light-bg: #f1f8e9;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background: var(--light-bg);
        }
        
        /* Navbar dengan tema hijau desa */
        .navbar {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(45, 125, 62, 0.3);
            padding: 15px 0;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            font-weight: 700;
            font-size: 1.4rem;
            color: white !important;
        }
        
        .logo-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .logo-sidoarjo {
            height: 50px;
            width: auto;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.2));
        }
        
        .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9) !important;
            margin: 0 10px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: var(--accent-yellow) !important;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 50%;
            background: var(--accent-yellow);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .btn-village-primary {
            background: var(--accent-yellow);
            border: none;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 600;
            color: var(--dark-green);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(253, 216, 53, 0.4);
        }
        
        .btn-village-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(253, 216, 53, 0.6);
            background: #ffeb3b;
            color: var(--dark-green);
        }
        
        .btn-village-outline {
            border: 2px solid white;
            color: white;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
        }
        
        .btn-village-outline:hover {
            background: white;
            color: var(--primary-green);
            transform: translateY(-2px);
        }
        
        /* Hero Section dengan desain sawah dan desa */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            display: flex;
            align-items: center;
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        /* Ilustrasi sawah animasi */
        .rice-field-pattern {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40%;
            background: 
                repeating-linear-gradient(
                    90deg,
                    rgba(45, 125, 62, 0.3) 0px,
                    rgba(76, 175, 80, 0.2) 50px,
                    rgba(45, 125, 62, 0.3) 100px
                );
            opacity: 0.5;
        }
        
        .village-clouds {
            position: absolute;
            width: 100px;
            height: 40px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 100px;
            animation: float-cloud 20s infinite linear;
        }
        
        .village-clouds::before,
        .village-clouds::after {
            content: '';
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 100px;
        }
        
        .village-clouds::before {
            width: 50px;
            height: 50px;
            top: -25px;
            left: 10px;
        }
        
        .village-clouds::after {
            width: 60px;
            height: 60px;
            top: -30px;
            right: 10px;
        }
        
        .village-clouds-1 {
            top: 10%;
            left: -100px;
        }
        
        .village-clouds-2 {
            top: 20%;
            left: -150px;
            animation-delay: 5s;
        }
        
        @keyframes float-cloud {
            to {
                transform: translateX(calc(100vw + 200px));
            }
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
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 20px;
            line-height: 1.2;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 40px;
            font-weight: 300;
            max-width: 600px;
        }
        
        .hero-buttons .btn {
            margin: 10px 10px 10px 0;
            padding: 15px 40px;
            font-size: 1.1rem;
        }
        
        /* Hero illustration - Desa */
        .hero-illustration {
            position: relative;
            height: 450px;
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
        
        .village-house {
            position: absolute;
            width: 120px;
            height: 100px;
        }
        
        .house-base {
            width: 100%;
            height: 70%;
            background: #8d6e63;
            border-radius: 5px;
            position: absolute;
            bottom: 0;
        }
        
        .house-roof {
            width: 0;
            height: 0;
            border-left: 70px solid transparent;
            border-right: 70px solid transparent;
            border-bottom: 50px solid #d32f2f;
            position: absolute;
            top: -20px;
            left: -10px;
        }
        
        .house-door {
            width: 30px;
            height: 40px;
            background: #5d4037;
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 5px 5px 0 0;
        }
        
        .house-window {
            width: 20px;
            height: 20px;
            background: #ffeb3b;
            position: absolute;
            top: 20px;
            border-radius: 3px;
        }
        
        .window-left {
            left: 15px;
        }
        
        .window-right {
            right: 15px;
        }
        
        .tree {
            position: absolute;
        }
        
        .tree-trunk {
            width: 15px;
            height: 40px;
            background: #8d6e63;
            margin: 0 auto;
        }
        
        .tree-leaves {
            width: 60px;
            height: 60px;
            background: var(--secondary-green);
            border-radius: 50%;
            position: absolute;
            top: -40px;
            left: -22px;
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
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
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
            box-shadow: 0 15px 40px rgba(45, 125, 62, 0.2);
            border-color: var(--secondary-green);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
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
        
        /* Stats Section dengan background sawah */
        .stats-section {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .stats-section::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y="50" font-size="80" opacity="0.05">🌾</text></svg>');
            background-size: 100px 100px;
            opacity: 0.1;
        }
        
        .stat-card {
            text-align: center;
            padding: 30px;
            position: relative;
            z-index: 1;
        }
        
        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            color: var(--accent-yellow);
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.95;
            font-weight: 300;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--secondary-green) 0%, var(--light-green) 100%);
            text-align: center;
            color: white;
        }
        
        .cta-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .cta-text {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.95;
        }
        
        /* Footer */
        .footer {
            background: var(--dark-green);
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
            color: var(--accent-yellow);
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
            background: var(--accent-yellow);
            color: var(--dark-green);
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
                font-size: 1rem;
            }
            
            .hero-buttons .btn {
                padding: 12px 25px;
                font-size: 1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
            
            .logo-sidoarjo {
                height: 35px;
            }
            
            .navbar-brand {
                font-size: 1.1rem;
            }
        }

        /* News Cards Styles */
        .news-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            background: white;
        }
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(45, 125, 62, 0.15);
        }
        .news-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }
        .news-category {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            background: rgba(255,255,255,0.9);
            color: var(--primary-green);
            z-index: 2;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <div class="logo-container">
                    <img src="{{ asset('images/logo-sidoarjo.png') }}" alt="Logo Kabupaten Sidoarjo" class="logo-sidoarjo">
                    <div>
                        <div style="font-size: 0.9rem; opacity: 0.9;">DESA SIDOKARE</div>
                        <div style="font-size: 0.7rem; opacity: 0.8; font-weight: 400;">Kab. Sidoarjo</div>
                    </div>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border-color: white;">
                <span class="navbar-toggler-icon" style="filter: brightness(0) invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#news">Kabar Desa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Layanan</a>
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
                                <a href="{{ url('/dashboard') }}" class="btn btn-village-primary">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </li>
                        @else
                            <li class="nav-item ms-3">
                                <a href="{{ route('login') }}" class="btn btn-village-outline">
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
        <!-- Clouds -->
        <div class="village-clouds village-clouds-1"></div>
        <div class="village-clouds village-clouds-2"></div>
        
        <!-- Rice field pattern -->
        <div class="rice-field-pattern"></div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">Selamat Datang di Desa SIDOKARE</h1>
                    <p class="hero-subtitle">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Sistem Informasi Desa Sidokare, Kabupaten Sidoarjo. Melayani dengan hati untuk administrasi desa yang lebih mudah, cepat, dan transparan.
                    </p>
                    <div class="hero-buttons">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-village-primary btn-lg">
                                <i class="fas fa-rocket me-2"></i>Mulai Layanan
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="btn btn-village-primary btn-lg">
                                <i class="fas fa-tachometer-alt me-2"></i>Ke Dashboard
                            </a>
                        @endguest
                        <a href="#features" class="btn btn-village-outline btn-lg">
                            <i class="fas fa-info-circle me-2"></i>Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-illustration">
                        <!-- Village Houses -->
                        <div class="village-house" style="left: 50px; bottom: 80px;">
                            <div class="house-roof"></div>
                            <div class="house-base">
                                <div class="house-window window-left"></div>
                                <div class="house-window window-right"></div>
                                <div class="house-door"></div>
                            </div>
                        </div>
                        
                        <div class="village-house" style="right: 100px; bottom: 60px; transform: scale(0.9);">
                            <div class="house-roof"></div>
                            <div class="house-base">
                                <div class="house-window window-left"></div>
                                <div class="house-window window-right"></div>
                                <div class="house-door"></div>
                            </div>
                        </div>
                        
                        <!-- Trees -->
                        <div class="tree" style="left: 20px; bottom: 20px;">
                            <div class="tree-leaves"></div>
                            <div class="tree-trunk"></div>
                        </div>
                        
                        <div class="tree" style="right: 50px; bottom: 10px; transform: scale(0.8);">
                            <div class="tree-leaves"></div>
                            <div class="tree-trunk"></div>
                        </div>
                        
                        <div class="tree" style="right: 200px; bottom: 30px; transform: scale(1.1);">
                            <div class="tree-leaves"></div>
                            <div class="tree-trunk"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title">Layanan Kami</h2>
            <p class="section-subtitle">Berbagai layanan administrasi desa yang dapat diakses secara digital</p>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="feature-title">Data Kependudukan</h3>
                        <p class="feature-desc">Kelola data penduduk dan kartu keluarga dengan sistem database yang terorganisir dan mudah diakses.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3 class="feature-title">Surat Menyurat</h3>
                        <p class="feature-desc">Ajukan permohonan surat secara online dengan tracking status real-time dan download hasil surat dalam format PDF.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Laporan & Statistik</h3>
                        <p class="feature-desc">Dashboard analitik dengan visualisasi data untuk pengambilan keputusan yang lebih baik.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Keamanan Terjamin</h3>
                        <p class="feature-desc">Sistem keamanan berlapis dengan enkripsi data dan kontrol akses berbasis role untuk melindungi privasi warga.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="feature-title">Akses Kapan Saja</h3>
                        <p class="feature-desc">Akses layanan dari berbagai perangkat (HP, tablet, komputer) dengan tampilan responsive.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3 class="feature-title">Tracking Permohonan</h3>
                        <p class="feature-desc">Pantau status permohonan surat Anda secara real-time dengan notifikasi otomatis.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kabar Desa Section -->
    <section class="news-section py-5 bg-light" id="news">
        <div class="container py-4">
            <h2 class="section-title">Kabar Desa Sidokare</h2>
            <p class="section-subtitle">Informasi terbaru seputar kegiatan dan perkembangan desa</p>
            
            <div class="row g-4">
                @forelse($latestBerita as $berita)
                <div class="col-lg-4 col-md-6">
                    <div class="card news-card">
                        <span class="news-category">{{ $berita->kategori }}</span>
                        @if($berita->gambar)
                            <img src="{{ Storage::url($berita->gambar) }}" class="card-img-top news-image" alt="{{ $berita->judul }}">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center news-image">
                                <i class="fas fa-image fa-3x text-white-50"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ $berita->published_at->format('d M Y') }}</small>
                                <small class="text-muted"><i class="far fa-user me-1"></i> {{ $berita->user->name }}</small>
                            </div>
                            <h5 class="card-title fw-bold">{{ Str::limit($berita->judul, 50) }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                            <a href="{{ route('berita.show', $berita->slug) }}" class="btn btn-outline-success btn-sm stretched-link">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-newspaper fa-3x mb-3 opacity-25"></i>
                        <p>Belum ada kabar terbaru saat ini.</p>
                    </div>
                </div>
                @endforelse
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('berita.index') }}" class="btn btn-village-outline" style="color: var(--primary-green); border-color: var(--primary-green);">
                    Lihat Semua Berita <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section" id="stats">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Layanan Online</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-number">{{ $stats['total_layanan'] }}+</div>
                        <div class="stat-label">Jenis Layanan Surat</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($stats['total_warga']) }}</div>
                        <div class="stat-label">Warga Terdaftar</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-number">{{ $stats['proses_cepat'] }}</div>
                        <div class="stat-label">Proses Cepat</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="contact">
        <div class="container">
            <h2 class="cta-title">Siap Menggunakan Layanan Digital Kami?</h2>
            <p class="cta-text">Bergabunglah dengan sistem pelayanan desa modern untuk kemudahan akses administrasi Anda</p>
            @guest
                <a href="{{ route('login') }}" class="btn btn-village-primary btn-lg" style="background: white; color: var(--primary-green); box-shadow: 0 6px 30px rgba(0,0,0,0.2);">
                    <i class="fas fa-sign-in-alt me-2"></i>Login Sekarang
                </a>
            @else
                <a href="{{ url('/dashboard') }}" class="btn btn-village-primary btn-lg" style="background: white; color: var(--primary-green); box-shadow: 0 6px 30px rgba(0,0,0,0.2);">
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
                        <img src="{{ asset('images/logo-sidoarjo.png') }}" alt="Logo Sidoarjo" style="height: 40px; margin-right: 10px; vertical-align: middle;">
                        DESA SIDOKARE
                    </h3>
                    <p class="text-white-50">
                        Sistem Informasi Desa SIDOKARE, Kabupaten Sidoarjo. Melayani masyarakat dengan teknologi digital untuk administrasi yang lebih baik.
                    </p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-title">Menu</h5>
                    <a href="#features" class="footer-link">Layanan</a>
                    <a href="#stats" class="footer-link">Statistik</a>
                    <a href="{{ route('login') }}" class="footer-link">Login</a>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-title">Layanan Surat</h5>
                    <a href="#" class="footer-link">Surat Keterangan Domisili</a>
                    <a href="#" class="footer-link">Surat Keterangan Usaha</a>
                    <a href="#" class="footer-link">Surat Keterangan Tidak Mampu</a>
                    <a href="#" class="footer-link">Dan 20+ lainnya</a>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5 class="footer-title">Kontak Kami</h5>
                    <p class="text-white-50">
                        <i class="fas fa-map-marker-alt me-2"></i>Kantor Desa SIDOKARE<br>
                        <span style="padding-left: 24px;">Kecamatan Sidoarjo</span><br>
                        <span style="padding-left: 24px;">Kabupaten Sidoarjo</span>
                    </p>
                    <p class="text-white-50">
                        <i class="fas fa-phone me-2"></i>(031) 123-4567
                    </p>
                    <p class="text-white-50">
                        <i class="fas fa-envelope me-2"></i>desasidokareukk@gmail.com
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="mb-0">&copy; {{ date('Y') }} Desa SIDOKARE - Kabupaten Sidoarjo. Sistem Informasi Desa Modern.</p>
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
                navbar.style.boxShadow = '0 4px 30px rgba(45, 125, 62, 0.5)';
            } else {
                navbar.style.boxShadow = '0 4px 20px rgba(45, 125, 62, 0.3)';
            }
        });
    </script>
</body>
</html>
