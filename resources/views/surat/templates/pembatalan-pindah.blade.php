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

<p>Mengajukan permohonan PEMBATALAN PINDAH atas Surat Pindah Nomor:</p>

<h3 style="text-align: center;">{{ $form_data['nomor_surat_pindah'] ?? '-' }}</h3>

<p>Dengan alasan pembatalan:</p>
<p>{{ $form_data['alasan_pembatalan'] ?? '-' }}</p>

<p>Demikian surat keterangan pembatalan pindah ini dibuat agar yang bersangkutan dapat kembali tercatat sebagai penduduk Desa {{ $kelurahan }}.</p>
@endsection
