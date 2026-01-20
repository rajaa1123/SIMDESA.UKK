@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan bahwa:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nama Lengkap</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($nama) }}</td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>:</td>
        <td>{{ $nik }}</td>
    </tr>
    <tr>
        <td>Tempat/Tgl Lahir</td>
        <td>:</td>
        <td>{{ $tempat_lahir }}, {{ $tanggal_lahir }}</td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>{{ $jenis_kelamin }}</td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td>:</td>
        <td>{{ $pekerjaan }}</td>
    </tr>
    <tr>
        <td>Agama</td>
        <td>:</td>
        <td>{{ $agama }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $alamat }} RT {{ $rt }} RW {{ $rw }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Berdasarkan catatan kependudukan yang ada pada kami, nama tersebut di atas adalah benar-benar penduduk Desa {{ $kelurahan }} Kecamatan {{ $kecamatan }} yang berdomisili di alamat tersebut dan telah memenuhi syarat untuk mengajukan permohonan administrasi kependudukan.</p>

<p style="text-indent: 45px;">Surat pengantar ini diberikan kepada yang bersangkutan untuk dipergunakan sebagai persyaratan <strong>{{ strtoupper($form_data['jenis_permohonan'] ?? 'PERMOHONAN KTP BARU') }}</strong> di Kantor Kecamatan {{ $kecamatan }}.</p>

<p style="text-indent: 45px;">Demikian surat pengantar ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya, dan kepada pihak yang berkepentingan diharapkan dapat memberikan bantuan serta fasilitas seperlunya.</p>
@endsection
