@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%; margin-bottom: 20px;">
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
        <td>Tanggal Kedatangan</td>
        <td>:</td>
        <td style="font-weight: bold;">{{ isset($form_data['tanggal_kedatangan']) ? \Carbon\Carbon::parse($form_data['tanggal_kedatangan'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Berdasarkan laporan kedatangan and Surat Pindah yang berlaku, nama tersebut di atas adalah benar-benar penduduk yang baru pindah datang and berdomisili di wilayah Desa {{ $kelurahan }} dengan identitas asal sebagai berikut:</p>

<table style="width: 100%; margin-bottom: 20px; border: 1px dotted #000; padding: 10px;">
    <tr>
        <td style="width: 30%;">Alamat Daerah Asal</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-style: italic;">{{ $form_data['alamat_asal_lengkap'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>No. Surat Pindah Asal</td>
        <td>:</td>
        <td>{{ $form_data['nomor_surat_pindah_asal'] ?? '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Demikian surat keterangan pindah datang ini kami buat dengan sebenarnya agar dapat dipergunakan sebagai persyaratan administrasi kependudukan and pemutakhiran data pada Kantor Desa {{ $kelurahan }}.</p>
@endsection
