<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMDESA SIDOKARE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        :root {
            --primary-green: #2d7d3e;
            --secondary-green: #4caf50;
            --accent-yellow: #fdd835;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
        }

        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            position: relative;
            overflow: hidden;
        }
        
        /* Rice field pattern overlay */
        .login-container::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y="50" font-size="80" opacity="0.05">🌾</text></svg>');
            background-size: 150px 150px;
            opacity: 0.1;
            pointer-events: none;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
            position: relative;
        }
        
        .login-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 20px;
            background: white;
            border-radius: 20px 20px 0 0;
        }
        
        .logo-img {
            width: 80px;
            height: auto;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            background-color: #f8f9fa;
        }
        
        .form-control:focus {
            border-color: var(--secondary-green);
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
            background-color: white;
        }
        
        .input-group-text {
            border-radius: 10px 0 0 10px;
            border: 1px solid #e0e0e0;
            background-color: white;
            color: var(--primary-green);
        }
        
        .form-control {
            border-radius: 0 10px 10px 0;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            border: none;
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(45, 125, 62, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(45, 125, 62, 0.4);
            background: linear-gradient(135deg, var(--secondary-green) 0%, var(--primary-green) 100%);
        }
        
        .village-decoration {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.2" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,261.3C960,256,1056,224,1152,202.7C1248,181,1344,171,1392,165.3L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>
    <div class="login-container d-flex align-items-center justify-content-center">
        <div class="village-decoration"></div>
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4">
                    <div class="card login-card">
                        <div class="login-header">
                            <img src="{{ asset('images/logo-sidoarjo.png') }}" alt="Logo Sidoarjo" class="logo-img">
                            <h4 class="fw-bold mb-0">DESA SIDOKARE</h4>
                            <small class="opacity-75">Sistem Informasi Desa</small>
                        </div>
                        
                        <div class="card-body p-4 pt-2">
                            <div class="text-center mb-4 mt-3">
                                <h5 class="text-secondary fw-bold">Selamat Datang</h5>
                                <p class="text-muted small">Silakan login untuk mengakses layanan</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <input type="hidden" name="login_type" value="warga">
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label small fw-bold text-secondary">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label small fw-bold text-secondary">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" required placeholder="******">
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label small text-secondary" for="remember">Ingat saya</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-decoration-none small text-success">Lupa Password?</a>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                    @error('g-recaptcha-response')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-login w-100 mb-3">
                                    Login Masuk
                                </button>
                                
                                <div class="text-center">
                                    <p class="mb-0 small text-muted">Belum punya akun? 
                                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-success">Daftar Warga</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="text-center mt-3 text-white opacity-75 small">
                        &copy; {{ date('Y') }} Pemerintah Desa Sidokare
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @if(session('unlock_at'))
    <script>
        // Rate Limit Countdown Timer
        const unlockTimestamp = {{ session('unlock_at') }};
        const errorElement = document.querySelector('.invalid-feedback');
        
        function updateCountdown() {
            const now = Math.floor(Date.now() / 1000);
            const remaining = unlockTimestamp - now;
            
            if (remaining <= 0) {
                if (errorElement) {
                    errorElement.textContent = 'Silakan coba login kembali.';
                    errorElement.classList.remove('text-danger');
                    errorElement.classList.add('text-success');
                }
                return;
            }
            
            if (errorElement) {
                errorElement.innerHTML = '<i class="fas fa-lock me-1"></i> Terlalu banyak percobaan login. Silakan coba lagi dalam <strong>' + remaining + '</strong> detik.';
            }
            
            setTimeout(updateCountdown, 1000);
        }
        
        updateCountdown();
    </script>
    @endif
</body>
</html>