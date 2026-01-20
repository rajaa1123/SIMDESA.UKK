@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nama Almarhum</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($form_data['nama_almarhum_akte'] ?? '-') }}</td>
    </tr>
    <tr>
        <td>Tanggal Meninggal</td>
        <td>:</td>
        <td>{{ isset($form_data['tanggal_meninggal_akte']) ? \Carbon\Carbon::parse($form_data['tanggal_meninggal_akte'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
    <tr>
        <td>Tempat Meninggal</td>
        <td>:</td>
        <td>{{ $form_data['tempat_meninggal_akte'] ?? '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Berdasarkan laporan kependudukan yang kami terima, surat keterangan ini diterbitkan atas permohonan pelapor dengan identitas sebagai berikut:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nama Pelapor</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($nama) }}</td>
    </tr>
    <tr>
        <td>NIK Pelapor</td>
        <td>:</td>
        <td>{{ $nik }}</td>
    </tr>
    <tr>
        <td>Alamat Pelapor</td>
        <td>:</td>
        <td>{{ $alamat }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Demikian surat pengantar ini kami buat dengan sebenarnya agar dapat dipergunakan sebagai persyaratan kelengkapan berkas pengurusan Akta Kematian pada Dinas Kependudukan dan Pencatatan Sipil.</p>
@endsection
