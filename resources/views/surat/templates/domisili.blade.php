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
        <td>Tempat/Tgl Lahir</td>
        <td>:</td>
        <td>{{ $form_data['tempat_lahir'] ?? $tempat_lahir }}, {{ isset($form_data['tanggal_lahir']) ? \Carbon\Carbon::parse($form_data['tanggal_lahir'])->locale('id')->isoFormat('D MMMM YYYY') : $tanggal_lahir }}</td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>{{ $form_data['jenis_kelamin'] ?? $jenis_kelamin }}</td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td>:</td>
        <td>{{ $form_data['pekerjaan'] ?? $pekerjaan }}</td>
    </tr>
    <tr>
        <td>Agama</td>
        <td>:</td>
        <td>{{ $form_data['agama'] ?? $agama }}</td>
    </tr>
    <tr>
        <td>Alamat Asal</td>
        <td>:</td>
        <td>{{ $form_data['alamat'] ?? $alamat }} RT {{ $form_data['rt'] ?? $rt }} RW {{ $form_data['rw'] ?? $rw }}</td>
    </tr>
</table>

<p>Orang tersebut di atas adalah benar-benar penduduk yang berdomisili di:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Alamat Domisili</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['alamat_domisili_lengkap'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Lama Tinggal</td>
        <td>:</td>
        <td>{{ $form_data['lama_tinggal'] ?? '-' }}</td>
    </tr>
</table>

<p>Surat keterangan ini diberikan untuk keperluan: <strong>{{ $form_data['keperluan'] ?? '-' }}</strong>.</p>

<p>Demikian Surat Keterangan Domisili ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
@endsection
