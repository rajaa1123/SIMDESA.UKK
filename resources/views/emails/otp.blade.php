<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP SIMDESA</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #2d7d3e; text-align: center;">Pemulihan Password SIMDESA</h2>
        <p>Halo,</p>
        <p>Kami menerima permintaan untuk mengatur ulang password akun Anda di SIMDESA Sidokare. Gunakan kode OTP di bawah ini untuk melanjutkan proses:</p>
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #333; background: #f4f4f4; padding: 10px 20px; border-radius: 5px; border: 1px dashed #ccc;">
                {{ $otp }}
            </span>
        </div>
        <p>Kode ini berlaku selama 10 menit. Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini.</p>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #888; text-align: center;">
            &copy; {{ date('Y') }} SIMDESA Pemerintah Desa Sidokare<br>
            Pesan ini dikirim secara otomatis oleh sistem.
        </p>
    </div>
</body>
</html>
