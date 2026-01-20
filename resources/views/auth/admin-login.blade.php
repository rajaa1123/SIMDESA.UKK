<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SIMDESA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        :root {
            --admin-primary: #1e293b; /* Deep slate */
            --admin-secondary: #334155;
            --admin-accent: #3b82f6; /* Modern Blue */
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .login-header {
            background: var(--admin-primary);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }

        .login-header h2 {
            font-weight: 700;
            letter-spacing: -0.025em;
            margin-bottom: 5px;
        }

        .login-header p {
            font-size: 0.875rem;
            opacity: 0.8;
            margin-bottom: 0;
        }

        .card-body {
            padding: 40px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #475569;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--admin-accent);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .btn-admin {
            background-color: var(--admin-primary);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s;
            margin-top: 10px;
        }

        .btn-admin:hover {
            background-color: var(--admin-secondary);
            transform: translateY(-1px);
        }

        .alert-error {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 0.875rem;
            color: #64748b;
        }

        .logo-placeholder {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        /* Micro-animations */
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="login-wrapper fade-in">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-placeholder">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h2>Panel Admin</h2>
                <p>Masuk ke Sistem Informasi Desa</p>
            </div>
            
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <input type="hidden" name="login_type" value="admin">

                    <div class="mb-4">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               required autofocus placeholder="admin@sidokare.desa.id">
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="password" class="form-label">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none small text-primary" style="font-size: 0.75rem;">Lupa Password?</a>
                            @endif
                        </div>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required placeholder="Masukkan kata sandi">
                    </div>

                    <div class="mb-4">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        @error('g-recaptcha-response')
                            <div class="invalid-feedback d-block small" style="color: #dc2626; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label small" for="remember">Tetap masuk di perangkat ini</label>
                    </div>

                    <button type="submit" class="btn btn-admin">
                        Masuk ke Dashboard
                    </button>
                </form>
            </div>
        </div>
        
        <div class="footer-text">
            &copy; {{ date('Y') }} SIMDESA Pemerintah Desa Sidokare<br>
            <span style="font-size: 0.75rem;">Akses Khusus Admin & Perangkat Desa</span>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @if(session('unlock_at'))
    <script>
        // Rate Limit Countdown Timer
        const unlockTimestamp = {{ session('unlock_at') }};
        const errorElement = document.querySelector('.alert-error span');
        
        function updateCountdown() {
            const now = Math.floor(Date.now() / 1000);
            const remaining = unlockTimestamp - now;
            
            if (remaining <= 0) {
                if (errorElement && errorElement.parentElement) {
                    errorElement.parentElement.innerHTML = '<i class="fas fa-check-circle"></i><span>Silakan coba login kembali.</span>';
                    errorElement.parentElement.style.backgroundColor = '#d1fae5';
                    errorElement.parentElement.style.borderColor = '#a7f3d0';
                    errorElement.parentElement.style.color = '#047857';
                }
                return;
            }
            
            if (errorElement) {
                errorElement.innerHTML = 'Terlalu banyak percobaan login. Silakan coba lagi dalam <strong>' + remaining + '</strong> detik.';
            }
            
            setTimeout(updateCountdown, 1000);
        }
        
        updateCountdown();
    </script>
    @endif
</body>
</html>
