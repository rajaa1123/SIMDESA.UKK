<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIMDESA SIDOKARE</title>
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

        .register-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            position: relative;
            overflow: hidden;
        }
        
        /* Rice field pattern overlay */
        .register-container::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y="50" font-size="80" opacity="0.05">🌾</text></svg>');
            background-size: 150px 150px;
            opacity: 0.1;
            pointer-events: none;
        }

        .register-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }
        
        .register-header {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
            position: relative;
        }
        
        .register-header::after {
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
        
        .btn-register {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            border: none;
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(45, 125, 62, 0.3);
        }
        
        .btn-register:hover {
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
    <div class="register-container d-flex align-items-center justify-content-center">
        <div class="village-decoration"></div>
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card register-card">
                        <div class="register-header">
                            <img src="{{ asset('images/logo-sidoarjo.png') }}" alt="Logo Sidoarjo" class="logo-img">
                            <h4 class="fw-bold mb-0">DESA SIDOKARE</h4>
                            <small class="opacity-75">Sistem Informasi Desa</small>
                        </div>
                        
                        <div class="card-body p-4 pt-2">
                            <div class="text-center mb-4 mt-3">
                                <h5 class="text-secondary fw-bold">Daftar Akun Warga</h5>
                                <p class="text-muted small">Hubungkan akun Anda dengan data warga menggunakan NIK yang sudah terdaftar oleh Admin.</p>
                            </div>

                            <form method="POST" action="{{ route('register') }}" id="registerForm">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}" required placeholder="Nama lengkap Anda">
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label small fw-bold text-secondary">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label small fw-bold text-secondary">No. HP</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nik" class="form-label small fw-bold text-secondary">NIK</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                            id="nik" name="nik" value="{{ old('nik') }}" required placeholder="16 digit NIK"
                                            maxlength="16" pattern="\d{16}" title="NIK harus 16 digit angka">
                                    </div>
                                    @error('nik')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label small fw-bold text-secondary">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" required placeholder="******">
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label small fw-bold text-secondary">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required placeholder="******">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                    @error('g-recaptcha-response')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-register w-100 mb-3">
                                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                                </button>
                                
                                <div class="text-center">
                                    <p class="mb-0 small text-muted">Sudah punya akun? 
                                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-success">Login disini</a>
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
    <script>
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            const nik = document.getElementById('nik').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            // Validasi NIK 16 digit
            if (nik.length !== 16 || !/^\d+$/.test(nik)) {
                e.preventDefault();
                alert('NIK harus 16 digit angka!');
                return;
            }

            // Validasi password match
            if (password !== passwordConfirmation) {
                e.preventDefault();
                alert('Password dan Konfirmasi Password tidak sama!');
                return;
            }
        });
    </script>
</body>
</html>