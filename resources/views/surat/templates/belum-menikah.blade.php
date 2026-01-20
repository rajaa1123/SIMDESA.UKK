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
        <td>Tempat/Tgl Lahir</td>
        <td>:</td>
        <td>{{ $tempat_lahir }}, {{ $tanggal_lahir }}</td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>{{ $jenis_kelamin }}</td>
    </tr>
    <tr>
        <td>Agama</td>
        <td>:</td>
        <td>{{ $agama }}</td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td>:</td>
        <td>{{ $pekerjaan }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $alamat }} RT {{ $rt }} RW {{ $rw }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Berdasarkan catatan register kependudukan Desa {{ $kelurahan }} serta pernyataan yang bersangkutan, bahwa nama tersebut di atas adalah benar-benar penduduk Desa {{ $kelurahan }} yang pada saat surat ini diterbitkan berstatus:</p>

<h3 style="text-align: center; border: 1px solid #000; padding: 10px; width: fit-content; margin: 20px auto;">BELUM PERNAH MENIKAH</h3>

<p style="text-indent: 45px;">Surat keterangan ini diberikan untuk keperluan: <strong>{{ strtoupper($form_data['keperluan'] ?? '-') }}</strong>.</p>

<p style="text-indent: 45px;">Demikian Surat Keterangan ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya, dan pihak yang berkepentingan diharapkan menjadikan maklum.</p>
@endsection
