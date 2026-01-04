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

<p>Mengajukan permohonan layanan <strong>PEDULI DILAN (Pelayanan Keliling)</strong> untuk:</p>

<h3 style="text-align: center;">{{ strtoupper($form_data['jenis_layanan_dilan'] ?? 'LAYANAN') }}</h3>

<p>Dengan keperluan khusus:</p>
<p>{{ $form_data['keperluan_khusus'] ?? '-' }}</p>

<p>Permohonan ini telah kami catat dan akan dijadwalkan dalam kunjungan pelayanan keliling berikutnya.</p>

<p>Demikian surat keterangan ini dibuat sebagai bukti pendaftaran layanan Peduli Dilan.</p>
@endsection
