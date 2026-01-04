<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $layanan->nama_layanan }}</title>
    <style>
        @page {
            margin: 2cm 2.5cm;
        }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .kop-surat {
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            position: relative;
        }
        .logo {
            width: 75px;
            height: auto;
            position: absolute;
            left: 0;
            top: 0;
        }
        h1 {
            font-size: 14pt;
            text-decoration: underline;
            margin: 20px 0;
            font-weight: bold;
        }
        .content {
            text-align: justify;
            margin: 20px 0;
        }
        table {
            width: 100%;
            margin: 10px 0;
            border-collapse: collapse;
        }
        table td {
            padding: 2px;
            vertical-align: top;
        }
        .ttd {
            margin-top: 50px;
            float: right;
            width: 300px;
            text-align: center;
        }
        .qr-code {
            width: 90px;
            height: 90px;
            margin: 10px auto;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    {{-- KOP SURAT --}}
    <div class="kop-surat">
        {{-- Logo placeholder - in real app use absolute path or base64 --}}
        {{-- <img src="{{ public_path('images/logo-desa.png') }}" alt="Logo" class="logo"> --}}
        
        <div class="header">
            <h3 style="margin: 0; font-size: 14pt;">PEMERINTAH KABUPATEN {{ $kabupaten }}</h3>
            <h3 style="margin: 0; font-size: 14pt;">KECAMATAN {{ $kecamatan }}</h3>
            <h2 style="margin: 5px 0; font-size: 16pt;">DESA {{ $kelurahan }}</h2>
            <p style="margin: 0; font-size: 10pt; font-style: italic;">
                Jl. Raya Sidokare No. 123, Sidokare, Sidoarjo 61234<br>
                Telp: (031) 1234567 | Email: desasidokare@sidoarjo.go.id
            </p>
        </div>
    </div>

    {{-- JUDUL & NOMOR --}}
    <div style="text-align: center;">
        <h1 style="margin-bottom: 5px;">{{ strtoupper($layanan->nama_layanan) }}</h1>
        <p style="margin-top: 0;">Nomor: {{ $nomor_surat }}</p>
    </div>

    {{-- ISI SURAT (CUSTOM PER TEMPLATE) --}}
    <div class="content">
        @yield('content')
    </div>

    {{-- TANDA TANGAN --}}
    <div class="ttd">
        <p>{{ $kelurahan }}, {{ $tanggal_surat }}</p>
        <p>Kepala Desa {{ $kelurahan }}</p>
        
        @if(!empty($kades_signature_qr))
            <img src="{{ $kades_signature_qr }}" alt="Digital Signature" class="qr-code">
        @else
            <div style="height: 90px;"></div>
        @endif
        
        <p style="font-weight: bold; text-decoration: underline;">{{ $kades_name }}</p>
    </div>
</body>
</html>
