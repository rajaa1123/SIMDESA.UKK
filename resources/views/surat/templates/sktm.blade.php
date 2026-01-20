@extends('surat.base')

@section('compact_class', 'compact')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan bahwa:</p>

<table style="width: 100%; margin-bottom: 5px;">
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

<p style="text-indent: 45px;">Berdasarkan data kependudukan yang ada pada kami serta hasil pemantauan dan pengamatan di lapangan, nama tersebut di atas adalah benar-benar penduduk Desa {{ $kelurahan }} Kecamatan {{ $kecamatan }} yang berasal dari keluarga dengan status sosial ekonomi <strong>TIDAK MAMPU (MISKIN)</strong>.</p>

<p style="text-indent: 45px;">Surat keterangan ini diberikan kepada yang bersangkutan untuk memenuhi persyaratan: <strong>{{ strtoupper($form_data['keperluan_sktm'] ?? '-') }}</strong>.</p>

<p style="text-indent: 45px;">Demikian Surat Keterangan Tidak Mampu (SKTM) ini kami buat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya, dan kepada instansi terkait dimohon dapat memberikan fasilitas sesuai dengan ketentuan yang berlaku.</p>
@endsection
