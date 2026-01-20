<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $layanan->nama_layanan }}</title>
    <style>
        @page {
            margin: 1.2cm 1.5cm;
        }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* --- Sizing Classes --- */
        
        /* Extra Compact: For very long letters (Nikah, Pindah, etc) */
        body.extra-compact { 
            font-size: 9pt !important; 
            line-height: 1.1 !important; 
        }
        body.extra-compact .kop-surat { margin-bottom: 5px !important; padding-bottom: 2px !important; min-height: 85px !important; }
        body.extra-compact .logo { width: 85px !important; }
        body.extra-compact h1 { font-size: 11pt !important; margin: 3px 0 1px 0 !important; }
        body.extra-compact .content { margin: 3px 0 !important; }
        body.extra-compact table { margin-bottom: 3px !important; }
        body.extra-compact table td { padding: 0px 2px !important; }
        body.extra-compact p { margin: 2px 0 !important; }
        body.extra-compact .ttd { margin-top: 10px !important; }

        /* Compact: For long letters (SKCK, Domisili with many fields) */
        body.compact { 
            font-size: 10.5pt !important; 
            line-height: 1.25 !important; 
        }
        body.compact .kop-surat { margin-bottom: 10px !important; padding-bottom: 4px !important; min-height: 95px !important; }
        body.compact .logo { width: 95px !important; }
        body.compact h1 { font-size: 12pt !important; margin: 8px 0 3px 0 !important; }
        body.compact .content { margin: 10px 0 !important; }
        body.compact table { margin-bottom: 8px !important; }
        body.compact table td { padding: 2px 2px !important; }
        body.compact .ttd { margin-top: 20px !important; }

        /* Standard: Default sizing */
        body.standard { 
            font-size: 11.5pt !important; 
            line-height: 1.5 !important; 
        }
        body.standard table { margin-bottom: 15px !important; }
        body.standard table td { padding: 4px 2px !important; }
        
        /* Relaxed: For shorter letters (Legalisasi, Beda Nama) */
        body.relaxed { 
            font-size: 12.5pt !important; 
            line-height: 1.7 !important; 
        }
        body.relaxed .content { margin: 30px 0 !important; }
        body.relaxed table { margin-bottom: 20px !important; }
        body.relaxed table td { padding: 6px 2px !important; }
        body.relaxed .ttd { margin-top: 60px !important; }

        /* Extra Relaxed: For very short letters */
        body.extra-relaxed { 
            font-size: 14pt !important; 
            line-height: 1.9 !important; 
        }
        body.extra-relaxed .kop-surat { margin-bottom: 40px !important; }
        body.extra-relaxed .content { margin: 50px 0 !important; }
        body.extra-relaxed table { margin-bottom: 35px !important; }
        body.extra-relaxed table td { padding: 10px 2px !important; }
        body.extra-relaxed .ttd { margin-top: 100px !important; }

        .header {
            text-align: center;
            margin-bottom: 0;
        }
        .kop-surat {
            border-bottom: 3px double #000;
            padding-bottom: 5px;
            margin-bottom: 20px;
            position: relative;
            min-height: 110px;
        }
        .logo {
            width: 110px;
            height: auto;
            position: absolute;
            left: 0;
            top: 0;
        }
        h1 {
            font-size: 14pt;
            text-decoration: underline;
            margin: 15px 0 5px 0;
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
            padding: 4px 2px;
            vertical-align: top;
        }
        .ttd {
            margin-top: 40px;
            float: right;
            width: 300px;
            text-align: center;
        }
        .qr-code {
            width: 80px;
            height: 80px;
            margin: 5px auto;
        }
        .qr-code svg {
            width: 100%;
            height: 100%;
            display: block;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body class="{{ $layout_class ?? 'standard' }}">
    {{-- KOP SURAT --}}
    <div class="kop-surat">
        {{-- Logo --}}
        @if(!empty($logo_base64))
            <img src="{{ $logo_base64 }}" alt="Logo" class="logo">
        @endif
        
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
        @elseif(!empty($kades_signature_qr_raw))
            <div class="qr-code">
                {!! $kades_signature_qr_raw !!}
            </div>
        @else
            <div style="height: 80px;"></div>
        @endif
        
        <p style="font-weight: bold; text-decoration: underline;">{{ $kades_name }}</p>
    </div>
</body>
</html>
