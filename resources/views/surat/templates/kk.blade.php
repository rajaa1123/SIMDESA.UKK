@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nama Kepala Keluarga</td>
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
        <td>{{ $alamat }} RT {{ $rt }} RW {{ $rw }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Berdasarkan catatan kependudukan yang ada pada Kantor Desa {{ $kelurahan }}, nama tersebut di atas adalah benar-benar penduduk Desa {{ $kelurahan }} Kecamatan {{ $kecamatan }} yang bermaksud mengajukan permohonan administrasi Kartu Keluarga (KK) sebagai berikut:</p>

<table style="width: 100%; margin-bottom: 20px; border: 1px dotted #000; padding: 10px;">
    <tr>
        <td style="width: 30%;">Jenis Permohonan</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($form_data['jenis_permohonan_kk'] ?? '-') }}</td>
    </tr>
    <tr>
        <td>Alasan Permohonan</td>
        <td>:</td>
        <td>{{ $form_data['alasan_permohonan'] ?? '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Demikian surat pengantar ini kami buat dengan sebenarnya agar dapat dipergunakan sebagai persyaratan kelengkapan berkas pengurusan Kartu Keluarga (KK) di Kantor Kecamatan {{ $kecamatan }} atau instansi terkait lainnya.</p>
@endsection
