<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Surat - SIMDESA</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #e9ecef;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .validation-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 600px;
            margin: 20px;
        }
        .header-section {
            background-color: #198754; /* Success Green similar to reference */
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        .validation-status {
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 5px;
        }
        .content-section {
            padding: 30px;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: top;
        }
        .info-table td:first-child {
            color: #6c757d;
            width: 40%;
            font-weight: 500;
        }
        .info-table td:last-child {
            color: #212529;
            font-weight: 600;
        }
        .info-table tr:last-child td {
            border-bottom: none;
        }
        .signature-section {
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            padding: 20px;
            text-align: center;
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <div class="validation-card">
        @if($isValid)
        <div class="header-section">
            <div class="header-icon">
                <i class="far fa-check-circle"></i>
            </div>
            <div class="validation-status">DOKUMEN VALID</div>
            <p class="mb-0 small opacity-75">Dokumen ini telah ditandatangani secara elektronik</p>
        </div>
        
        <div class="content-section">
            <h5 class="text-center mb-4 text-success fw-bold">Detail Dokumen</h5>
            
            <table class="info-table">
                <tr>
                    <td>Jenis Dokumen</td>
                    <td>{{ $permohonan->layanan->nama_layanan }}</td>
                </tr>
                <tr>
                    <td>Nomor Surat</td>
                    <td>{{ $nomorSurat }}</td>
                </tr>
                <tr>
                    <td>Tanggal Terbit</td>
                    <td>{{ \Carbon\Carbon::parse($permohonan->kades_approval_date)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                </tr>
                <tr>
                    <td>Nama Pemohon</td>
                    <td>{{ $permohonan->user->name }}</td>
                </tr>
                <tr>
                    <td>NIK Pemohon</td>
                    <td>{{ $permohonan->user->warga->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Penanda Tangan</td>
                    <td>{{ $permohonan->kadesUser->name ?? 'Kepala Desa' }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>Kepala Desa Sidokare</td>
                </tr>
            </table>
        </div>

        <div class="signature-section">
            <i class="fas fa-lock me-1"></i> Ditandatangani elektronik oleh Pemerintah Desa Sidokare
        </div>
        
        @else
        <div class="header-section bg-danger">
            <div class="header-icon">
                <i class="far fa-times-circle"></i>
            </div>
            <div class="validation-status">DOKUMEN TIDAK VALID</div>
            <p class="mb-0 small opacity-75">Data dokumen tidak ditemukan atau belum disahkan</p>
        </div>

        <div class="content-section text-center">
            <p class="text-muted">Maaf, kami tidak dapat memverifikasi keaslian dokumen ini. Hal ini mungkin terjadi karena:</p>
            <ul class="text-start text-muted small mb-4">
                <li>Dokumen belum disetujui oleh Kepala Desa.</li>
                <li>QR Code tidak valid atau rusak.</li>
                <li>Dokumen telah dibatalkan atau dihapus dari sistem.</li>
            </ul>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">Ke Halaman Utama</a>
        </div>
        @endif
    </div>

</body>
</html>
