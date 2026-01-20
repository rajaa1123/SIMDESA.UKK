@extends('surat.base')

@section('compact_class', 'compact')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya berdasarkan catatan yang ada di Buku Registrasi Tanah (Buku C) Desa {{ $kelurahan }} bahwa:</p>

<table style="width: 100%; margin-bottom: 5px;">
    <tr>
        <td style="width: 30%;">Nama Pemilik</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($nama) }}</td>
    </tr>
    <tr>
        <td>Lokasi Bidang Tanah</td>
        <td>:</td>
        <td>{{ $form_data['lokasi_tanah'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Luas Estimasi Tanah</td>
        <td>:</td>
        <td style="font-weight: bold;">± {{ $form_data['luas_tanah'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Asal Usul Perolehan</td>
        <td>:</td>
        <td>{{ $form_data['asal_tanah'] ?? '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Adapun batas-batas bidang tanah tersebut adalah sebagai berikut:</p>

<table style="width: 100%; margin-bottom: 5px; border: 1px solid #000; padding: 5px;">
    <tr>
        <td style="width: 30%;">Sebelah UTARA</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['batas_utara'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Sebelah SELATAN</td>
        <td>:</td>
        <td>{{ $form_data['batas_selatan'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Sebelah TIMUR</td>
        <td>:</td>
        <td>{{ $form_data['batas_timur'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Sebelah BARAT</td>
        <td>:</td>
        <td>{{ $form_data['batas_barat'] ?? '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Demikian Surat Keterangan Riwayat Tanah ini kami buat dengan sebenarnya berdasarkan data fisik and yuridis yang ada pada kami, agar dapat dipergunakan sebagai dasar pengurusan sertifikat tanah atau keperluan administrasi pertanahan lainnya.</p>
@endsection
