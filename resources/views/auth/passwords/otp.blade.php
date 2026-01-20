<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - SIMDESA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8fafc; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 400px; }
        .btn-primary { background: #2d7d3e; border: none; border-radius: 50px; padding: 10px; font-weight: 600; }
        .btn-primary:hover { background: #1b5e20; }
        .form-control { border-radius: 50px; padding: 10px 20px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 5px; }
    </style>
</head>
<body>
    <div class="card p-4">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-secondary">Verifikasi OTP</h4>
            <p class="text-muted small">Masukkan 6 digit kode yang dikirim ke <b>{{ $email }}</b></p>
        </div>

        @if(session('success'))
            <div class="alert alert-success small">{{ session('success') }}</div>
        @endif

        <form action="{{ route('password.verify') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div class="mb-4">
                <input type="text" name="otp" class="form-control @error('otp') is-invalid @enderror" required maxlength="6" placeholder="000000" autofocus>
                @error('otp')
                    <div class="invalid-feedback d-block small text-center">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Verifikasi Kode</button>
            <div class="text-center">
                <p class="small text-muted mb-0">Tidak menerima kode? <a href="{{ route('password.request') }}" class="text-decoration-none text-success fw-bold">Kirim ulang</a></p>
            </div>
        </form>
    </div>
</body>
</html>
