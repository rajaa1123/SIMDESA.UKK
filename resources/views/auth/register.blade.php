<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIMDESA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .register-container {
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .register-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="register-container d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card register-card">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <h3 class="card-title fw-bold text-primary">Daftar Akun</h3>
                                <p class="text-muted">Buat akun SIMDESA baru</p>
                            </div>

                            <form method="POST" action="{{ route('register') }}">
                                <form method="POST" action="{{ route('register') }}" id="registerForm">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name') }}" required>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" value="{{ old('email') }}" required>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">No. HP</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                id="phone" name="phone" value="{{ old('phone') }}">
                                        </div>
                                        @error('phone')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                                id="nik" name="nik" value="{{ old('nik') }}" required>
                                        </div>
                                        @error('nik')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" required>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi
                                            Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" required>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-2">
                                        <i class="fas fa-user-plus me-2"></i>Daftar
                                    </button>
                                </form>
                                @push('scripts')
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
                                @endpush

                                <div class="text-center mt-3">
                                    <p class="mb-0">Sudah punya akun?
                                        <a href="{{ route('login') }}" class="text-decoration-none">Login disini</a>
                                    </p>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>