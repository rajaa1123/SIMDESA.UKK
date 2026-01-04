@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Suami</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $nama }}</td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>:</td>
        <td>{{ $nik }}</td>
    </tr>
    <tr>
        <td>Nama Istri</td>
        <td>:</td>
        <td>{{ $form_data['nama_pasangan'] ?? '-' }}</td>
    </tr>
</table>

<p>Telah melangsungkan perkawinan pada:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Tanggal Perkawinan</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ isset($form_data['tanggal_perkawinan_akte']) ? \Carbon\Carbon::parse($form_data['tanggal_perkawinan_akte'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
    <tr>
        <td>Tempat Perkawinan</td>
        <td>:</td>
        <td>{{ $form_data['tempat_perkawinan'] ?? '-' }}</td>
    </tr>
</table>

<p>Demikian surat pengantar ini dibuat untuk dapat dipergunakan sebagai persyaratan pengurusan Akta Perkawinan.</p>
@endsection
