@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Pewaris</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['nama_pewaris'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Tanggal Meninggal</td>
        <td>:</td>
        <td>{{ isset($form_data['tanggal_meninggal_pewaris']) ? \Carbon\Carbon::parse($form_data['tanggal_meninggal_pewaris'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
</table>

<p>Telah meninggal dunia dan meninggalkan ahli waris sebagai berikut:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Ahli Waris</td>
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
        <td>{{ $form_data['hubungan_ahli_waris'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Jumlah Ahli Waris</td>
        <td>:</td>
        <td>{{ $form_data['jumlah_ahli_waris'] ?? '1' }} Orang</td>
    </tr>
</table>

<p>Demikian Surat Pernyataan Ahli Waris ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
@endsection
