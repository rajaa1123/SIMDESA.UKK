@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%; margin-bottom: 20px; border: 1px solid #000; padding: 10px;">
    <tr>
        <td style="width: 30%;">Nama Pewaris</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($form_data['nama_pewaris'] ?? '-') }}</td>
    </tr>
    <tr>
        <td>Tanggal Meninggal</td>
        <td>:</td>
        <td>{{ isset($form_data['tanggal_meninggal_pewaris']) ? \Carbon\Carbon::parse($form_data['tanggal_meninggal_pewaris'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Bahwa almarhum/almarhumah semasa hidupnya bertempat tinggal di Desa {{ $kelurahan }} dan pada saat meninggal dunia meninggalkan ahli waris yang sah sesuai dengan ketentuan hukum yang berlaku, yaitu:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nama Ahli Waris</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($nama) }}</td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>:</td>
        <td>{{ $nik }}</td>
    </tr>
    <tr>
        <td>Hubungan Keluarga</td>
        <td>:</td>
        <td>{{ $form_data['hubungan_ahli_waris'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Jumlah Ahli Waris</td>
        <td>:</td>
        <td>{{ $form_data['jumlah_ahli_waris'] ?? '1' }} (Satu) Orang</td>
    </tr>
</table>

<p style="text-indent: 45px;">Demikian Surat Keterangan Ahli Waris ini diberikan kepada yang bersangkutan sebagai bukti administratif yang sah untuk dapat dipergunakan sebagaimana mestinya, khususnya dalam rangka penyelesaian hak-hak ahli waris.</p>

<p style="text-indent: 45px;">Segala akibat hukum yang timbul di kemudian hari sehubungan dengan pernyataan ini sepenuhnya menjadi tanggung jawab pihak yang membuat pernyataan.</p>
@endsection
