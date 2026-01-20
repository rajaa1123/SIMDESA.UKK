@extends('surat.base')

@section('compact_class', 'compact')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%; margin-bottom: 5px;">
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
        <td>Alamat Asal</td>
        <td>:</td>
        <td>{{ $alamat }} RT {{ $rt }} RW {{ $rw }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Berdasarkan permohonan yang bersangkutan, nama tersebut di atas mengajukan permohonan <strong>PINDAH TEMPAT</strong> dari Desa {{ $kelurahan }} Kecamatan {{ $kecamatan }} dengan tujuan sebagai berikut:</p>

<table style="width: 100%; margin-bottom: 5px;">
    <tr>
        <td style="width: 30%;">Alamat Tujuan</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-style: italic;">{{ $form_data['alamat_tujuan_lengkap'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Desa/Kelurahan</td>
        <td>:</td>
        <td>{{ $form_data['desa_tujuan'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Kecamatan</td>
        <td>:</td>
        <td>{{ $form_data['kecamatan_tujuan'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Kabupaten/Kota</td>
        <td>:</td>
        <td>{{ $form_data['kabupaten_tujuan'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Provinsi</td>
        <td>:</td>
        <td>{{ $form_data['provinsi_tujuan'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Alasan Pindah</td>
        <td>:</td>
        <td>{{ $form_data['alasan_pindah'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Jumlah Pengikut</td>
        <td>:</td>
        <td>{{ $form_data['jumlah_anggota_pindah'] ?? '1' }} (Satu) Orang</td>
    </tr>
</table>

<p style="text-indent: 45px;">Demikian Surat Pengantar Pindah Tempat ini kami buat dengan sebenarnya agar dapat dipergunakan sebagai persyaratan pengurusan administrasi kependudukan lebih lanjut di daerah tujuan serta instansi terkait lainnya.</p>
@endsection
