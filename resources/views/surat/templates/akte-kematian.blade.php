@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Almarhum</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['nama_almarhum_akte'] ?? '-' }}</td>
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

<p>Surat keterangan ini dibuat atas laporan dari:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Pelapor</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $nama }}</td>
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

<p>Demikian surat keterangan kematian ini dibuat untuk dapat dipergunakan sebagai persyaratan pengurusan Akta Kematian.</p>
@endsection
