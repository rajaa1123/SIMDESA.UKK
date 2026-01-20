@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa:</p>

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
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $alamat }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Nama tersebut di atas telah mengajukan permohonan legalisasi / pengesahan atas dokumen administrasi sebagai berikut:</p>

<h3 style="text-align: center; font-weight: bold; margin: 15px 0;">{{ strtoupper($form_data['jenis_dokumen'] ?? 'DOKUMEN ADMINISTRASI') }}</h3>

<p style="text-indent: 45px;">Digunakan untuk keperluan: <strong>{{ strtoupper($form_data['keperluan_legalisasi'] ?? '-') }}</strong>.</p>

<p style="text-indent: 45px;">Pihak Pemerintah Desa {{ $kelurahan }} melalui pejabat yang berwenang telah melakukan verifikasi dan pencocokan data fisik dokumen fotokopi tersebut di atas and menyatakan bahwa dokumen tersebut telah sesuai dengan aslinya.</p>

<p style="text-indent: 45px;">Demikian Surat Keterangan Legalisasi ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.</p>
@endsection
