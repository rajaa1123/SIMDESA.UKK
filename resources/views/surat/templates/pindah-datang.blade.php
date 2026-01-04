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
        <td>Tanggal Kedatangan</td>
        <td>:</td>
        <td>{{ isset($form_data['tanggal_kedatangan']) ? \Carbon\Carbon::parse($form_data['tanggal_kedatangan'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
</table>

<p>Adalah penduduk yang baru pindah datang dari:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Alamat Asal</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['alamat_asal_lengkap'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>No. Surat Pindah Asal</td>
        <td>:</td>
        <td>{{ $form_data['nomor_surat_pindah_asal'] ?? '-' }}</td>
    </tr>
</table>

<p>Demikian surat keterangan pindah datang ini dibuat untuk dapat dipergunakan sebagai persyaratan administrasi kependudukan di Desa {{ $kelurahan }}.</p>
@endsection
