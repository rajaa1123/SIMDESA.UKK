@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, menerangkan bahwa telah menerima pengaduan dari:</p>

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

<p>Terkait dengan perihal:</p>
<h3 style="text-align: center;">{{ strtoupper($form_data['perihal_pengaduan'] ?? 'PENGADUAN') }}</h3>

<p>Uraian Pengaduan:</p>
<p>{{ $form_data['uraian_pengaduan'] ?? '-' }}</p>

<p>Tindakan yang Diharapkan:</p>
<p>{{ $form_data['tindakan_diharapkan'] ?? '-' }}</p>

<p>Pengaduan ini telah kami terima dan akan segera ditindaklanjuti sesuai dengan prosedur yang berlaku.</p>

<p>Demikian surat tanda terima pengaduan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
@endsection
