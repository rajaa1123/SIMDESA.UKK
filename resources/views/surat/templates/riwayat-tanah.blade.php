@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Pemilik</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $nama }}</td>
    </tr>
    <tr>
        <td>Lokasi Tanah</td>
        <td>:</td>
        <td>{{ $form_data['lokasi_tanah'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Luas Tanah</td>
        <td>:</td>
        <td>{{ $form_data['luas_tanah'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Asal Tanah</td>
        <td>:</td>
        <td>{{ $form_data['asal_tanah'] ?? '-' }}</td>
    </tr>
</table>

<p>Adapun batas-batas tanah tersebut adalah sebagai berikut:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Utara</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['batas_utara'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Selatan</td>
        <td>:</td>
        <td>{{ $form_data['batas_selatan'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Timur</td>
        <td>:</td>
        <td>{{ $form_data['batas_timur'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Barat</td>
        <td>:</td>
        <td>{{ $form_data['batas_barat'] ?? '-' }}</td>
    </tr>
</table>

<p>Demikian Surat Keterangan Riwayat Tanah ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
@endsection
