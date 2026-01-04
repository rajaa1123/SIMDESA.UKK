@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Lengkap</td>
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

<p>Telah resmi bercerai dengan:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Mantan Pasangan</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['nama_mantan_pasangan'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Nomor Putusan</td>
        <td>:</td>
        <td>{{ $form_data['nomor_putusan_pengadilan'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Tanggal Putusan</td>
        <td>:</td>
        <td>{{ isset($form_data['tanggal_putusan']) ? \Carbon\Carbon::parse($form_data['tanggal_putusan'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
</table>

<p>Demikian surat pengantar ini dibuat untuk dapat dipergunakan sebagai persyaratan pengurusan Akta Perceraian.</p>
@endsection
