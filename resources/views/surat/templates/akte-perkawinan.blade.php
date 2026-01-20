@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nama Suami</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($nama) }}</td>
    </tr>
    <tr>
        <td>NIK Suami</td>
        <td>:</td>
        <td>{{ $nik }}</td>
    </tr>
    <tr>
        <td>Nama Istri</td>
        <td>:</td>
        <td style="font-weight: bold;">{{ strtoupper($form_data['nama_pasangan'] ?? '-') }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Nama-nama tersebut di atas adalah benar pasangan suami istri yang telah melangsungkan perkawinan secara sah menurut agama dan kepercayaan pada:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Waktu Perkawinan</td>
        <td>:</td>
        <td>{{ isset($form_data['tanggal_perkawinan_akte']) ? \Carbon\Carbon::parse($form_data['tanggal_perkawinan_akte'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
    <tr>
        <td>Tempat Perkawinan</td>
        <td>:</td>
        <td>{{ $form_data['tempat_perkawinan'] ?? '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Demikian surat pengantar ini kami buat dengan sebenarnya agar dapat dipergunakan sebagai persyaratan kelengkapan berkas untuk penerbitan Akta Perkawinan pada Dinas Kependudukan dan Pencatatan Sipil.</p>
@endsection
