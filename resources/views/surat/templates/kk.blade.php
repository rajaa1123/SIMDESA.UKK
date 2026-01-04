@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Kepala Keluarga</td>
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
        <td>{{ $alamat }} RT {{ $rt }} RW {{ $rw }}</td>
    </tr>
</table>

<p>Orang tersebut di atas adalah benar-benar penduduk Desa {{ $kelurahan }} yang mengajukan permohonan pengurusan Kartu Keluarga (KK) dengan rincian:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Jenis Permohonan</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['jenis_permohonan_kk'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Alasan</td>
        <td>:</td>
        <td>{{ $form_data['alasan_permohonan'] ?? '-' }}</td>
    </tr>
</table>

<p>Demikian surat pengantar ini dibuat untuk dapat dipergunakan sebagai persyaratan pengurusan KK di Kecamatan {{ $kecamatan }}.</p>
@endsection
