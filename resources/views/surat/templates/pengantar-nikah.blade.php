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
        <td>Tempat/Tgl Lahir</td>
        <td>:</td>
        <td>{{ $tempat_lahir }}, {{ $tanggal_lahir }}</td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>{{ $jenis_kelamin }}</td>
    </tr>
    <tr>
        <td>Agama</td>
        <td>:</td>
        <td>{{ $agama }}</td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td>:</td>
        <td>{{ $pekerjaan }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $alamat }} RT {{ $rt }} RW {{ $rw }}</td>
    </tr>
</table>

<p>Adalah benar-benar penduduk Desa {{ $kelurahan }} yang akan melangsungkan pernikahan dengan:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Calon Pasangan</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['nama_calon_pasangan'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Rencana Tanggal Nikah</td>
        <td>:</td>
        <td>{{ isset($form_data['tanggal_rencana_nikah']) ? \Carbon\Carbon::parse($form_data['tanggal_rencana_nikah'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
</table>

<p>Demikian Surat Pengantar Nikah ini dibuat untuk dapat dipergunakan sebagai persyaratan administrasi di KUA setempat.</p>
@endsection
