<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SIMDESA</title>
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
            <h4 class="fw-bold text-secondary">Selesaikan Reset</h4>
            <p class="text-muted small">Silakan buat password baru Anda.</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label small fw-bold">Password Baru</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="••••••••">
                @error('password')
                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn-primary w-100">Simpan Password Baru</button>
        </form>
    </div>
</body>
</html>
