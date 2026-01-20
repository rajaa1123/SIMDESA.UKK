<!DOCTYPE html>
<html>
<head>
    <title>Surat Selesai</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #2d7d3e;">Permohonan Surat Disetujui</h2>
        
        <p>Halo <strong>{{ $permohonan->user->name }}</strong>,</p>
        
        <p>Kabar baik! Permohonan surat Anda telah disetujui dan ditandatangani secara digital oleh Kepala Desa.</p>
        
        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="width: 150px; font-weight: bold;">Jenis Layanan:</td>
                <td>{{ $permohonan->layanan->nama_layanan }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Nomor Resi:</td>
                <td>{{ $permohonan->nomor_resi }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Tanggal Selesai:</td>
                <td>{{ now()->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
        
        <p>Anda dapat mengunduh surat tersebut dengan login ke aplikasi SIMDESA atau klik tombol di bawah ini:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('permohonan.show', $permohonan->id) }}" style="background-color: #2d7d3e; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                Download Surat
            </a>
        </div>
        
        <p>Terima kasih telah menggunakan layanan SIMDESA Sidokare.</p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <small style="color: #777;">Email ini dikirim otomatis, mohon tidak membalas email ini.</small>
    </div>
</body>
</html>
