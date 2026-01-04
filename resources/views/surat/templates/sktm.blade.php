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
        <td>{{ $tempat_lahir }}, {{ $tanggal_lahir }}</td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>{{ $jenis_kelamin }}</td>
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
    <tr>
        <td>Jumlah Tanggungan</td>
        <td>:</td>
        <td>{{ $form_data['jumlah_tanggungan'] ?? '0' }} Orang</td>
    </tr>
</table>

<p>Berdasarkan data yang ada pada kami dan pengamatan di lapangan, orang tersebut di atas tergolong keluarga <strong>TIDAK MAMPU / MISKIN</strong>.</p>

<p>Surat keterangan ini diberikan untuk keperluan: <strong>{{ $form_data['keperluan_sktm'] ?? '-' }}</strong>.</p>

<p>Demikian Surat Keterangan Tidak Mampu (SKTM) ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
@endsection
