@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Pemilik</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $nama }}</td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>:</td>
        <td>{{ $nik }}</td>
    </tr>
    <tr>
        <td>Alamat Pemilik</td>
        <td>:</td>
        <td>{{ $alamat }}</td>
    </tr>
</table>

<p>Adalah benar-benar pemilik/pengelola usaha dengan rincian sebagai berikut:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Usaha</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['nama_usaha'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Jenis Usaha</td>
        <td>:</td>
        <td>{{ $form_data['jenis_usaha'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Alamat Usaha</td>
        <td>:</td>
        <td>{{ $form_data['alamat_usaha'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Tahun Berdiri</td>
        <td>:</td>
        <td>{{ $form_data['tahun_berdiri'] ?? '-' }}</td>
    </tr>
</table>

<p>Demikian Surat Keterangan Domisili Usaha ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
@endsection
