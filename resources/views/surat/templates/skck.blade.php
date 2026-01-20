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

<p style="text-indent: 45px;">Berdasarkan catatan yang ada pada Kantor Desa {{ $kelurahan }} serta sepengetahuan kami, nama tersebut di atas adalah benar-benar penduduk Desa {{ $kelurahan }} yang memiliki kelakuan baik dalam kehidupan bermasyarakat serta tidak pernah terlibat dalam tindakan pidana atau kriminalitas apapun.</p>

<p style="text-indent: 45px;">Surat pengantar ini diberikan kepada yang bersangkutan untuk memenuhi persyaratan: <strong>{{ strtoupper($form_data['keperluan'] ?? 'PENGURUSAN SKCK') }}</strong>.</p>

@if(!empty($form_data['keterangan_lain']))
<p style="text-indent: 45px;">Keterangan Tambahan: {{ $form_data['keterangan_lain'] }}</p>
@endif

<p style="text-indent: 45px;">Demikian Surat Pengantar ini kami buat dengan sebenarnya agar dapat dipergunakan sebagai bahan pertimbangan dalam pengurusan Surat Keterangan Catatan Kepolisian (SKCK) di instansi terkait.</p>
@endsection
