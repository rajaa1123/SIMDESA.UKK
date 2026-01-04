@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Lengkap</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['nama_almarhum'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Tanggal Meninggal</td>
        <td>:</td>
        <td>{{ isset($form_data['tanggal_meninggal']) ? \Carbon\Carbon::parse($form_data['tanggal_meninggal'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
    <tr>
        <td>Tempat Meninggal</td>
        <td>:</td>
        <td>{{ $form_data['tempat_meninggal'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Sebab Kematian</td>
        <td>:</td>
        <td>{{ $form_data['sebab_kematian'] ?? '-' }}</td>
    </tr>
</table>

<p>Adalah benar-benar penduduk Desa {{ $kelurahan }} yang telah meninggal dunia.</p>

<p>Surat keterangan ini dibuat atas dasar laporan dari:</p>

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
        <td>Hubungan</td>
        <td>:</td>
        <td>{{ $form_data['hubungan_pelapor'] ?? '-' }}</td>
    </tr>
</table>

<p>Demikian Surat Keterangan Kematian ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
@endsection
