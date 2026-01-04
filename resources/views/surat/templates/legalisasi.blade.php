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

<p>Telah mengajukan permohonan legalisasi dokumen berupa:</p>

<h3 style="text-align: center;">{{ strtoupper($form_data['jenis_dokumen'] ?? 'DOKUMEN') }}</h3>

<p>Untuk keperluan: <strong>{{ $form_data['keperluan_legalisasi'] ?? '-' }}</strong>.</p>

<p>Pihak desa telah memverifikasi keaslian dokumen tersebut sesuai dengan aslinya.</p>

<p>Demikian surat keterangan legalisasi ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
@endsection
