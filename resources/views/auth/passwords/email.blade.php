<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SIMDESA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8fafc; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 400px; }
        .btn-primary { background: #2d7d3e; border: none; border-radius: 50px; padding: 10px; font-weight: 600; }
        .btn-primary:hover { background: #1b5e20; }
        .form-control { border-radius: 50px; padding: 10px 20px; }
    </style>
</head>
<body>
    <div class="card p-4">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-secondary">Lupa Password</h4>
            <p class="text-muted small">Masukkan email Anda untuk menerima kode OTP.</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger small">{{ session('error') }}</div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label small fw-bold">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                    <input type="email" name="email" class="form-control border-start-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="email@contoh.com">
                </div>
                @error('email')
                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Kirim Kode OTP</button>
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-decoration-none small text-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali ke Login</a>
            </div>
        </form>
    </div>
</body>
</html>
