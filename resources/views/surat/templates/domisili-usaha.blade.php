@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nama Pemilik</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($nama) }}</td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>:</td>
        <td>{{ $nik }}</td>
    </tr>
    <tr>
        <td>Alamat Domisili</td>
        <td>:</td>
        <td>{{ $alamat }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Berdasarkan pemantauan lapangan dan data yang ada pada kami, nama tersebut di atas adalah benar-benar memiliki dan mengelola bidang usaha yang berlokasi di wilayah Desa {{ $kelurahan }} dengan rincian sebagai berikut:</p>

<table style="width: 100%; margin-bottom: 20px; border: 1px dotted #000; padding: 10px;">
    <tr>
        <td style="width: 30%;">Nama Usaha</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($form_data['nama_usaha'] ?? '-') }}</td>
    </tr>
    <tr>
        <td>Bidang / Jenis Usaha</td>
        <td>:</td>
        <td>{{ $form_data['jenis_usaha'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Alamat Tempat Usaha</td>
        <td>:</td>
        <td>{{ $form_data['alamat_usaha'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Tahun Operasional</td>
        <td>:</td>
        <td>Sejak Tahun {{ $form_data['tahun_berdiri'] ?? '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Demikian Surat Keterangan Domisili Usaha ini kami buat dengan sebenarnya agar dapat dipergunakan sebagai persyaratan administratif penunjang legalitas usaha serta keperluan perizinan lainnya.</p>
@endsection
