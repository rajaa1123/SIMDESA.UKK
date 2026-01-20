@extends('surat.base')

@section('compact_class', 'compact')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa pasangan suami istri:</p>

<table style="width: 100%; margin-bottom: 5px;">
    <tr>
        <td style="width: 30%;">Nama Ayah</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($form_data['nama_ayah'] ?? '-') }}</td>
    </tr>
    <tr>
        <td>Nama Ibu</td>
        <td>:</td>
        <td>{{ strtoupper($form_data['nama_ibu'] ?? '-') }}</td>
    </tr>
    <tr>
        <td>Alamat Orang Tua</td>
        <td>:</td>
        <td>{{ $alamat }} RT {{ $rt }} RW {{ $rw }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Berdasarkan laporan kelahiran dan catatan kependudukan Desa {{ $kelurahan }}, telah lahir seorang anak dengan identitas sebagai berikut:</p>

<table style="width: 100%; margin-bottom: 5px;">
    <tr>
        <td style="width: 30%;">Nama Anak</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($form_data['nama_anak_lengkap'] ?? '-') }}</td>
    </tr>
    <tr>
        <td>Tempat/Tgl Lahir</td>
        <td>:</td>
        <td>{{ $form_data['tempat_lahir_anak'] ?? '-' }}, {{ isset($form_data['tanggal_lahir_anak']) ? \Carbon\Carbon::parse($form_data['tanggal_lahir_anak'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>{{ $form_data['jenis_kelamin_anak'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Anak Ke-</td>
        <td>:</td>
        <td>{{ $form_data['anak_ke'] ?? '-' }} (Satu)</td>
    </tr>
</table>

<p style="text-indent: 45px;">Demikian Surat Keterangan Lahir ini kami buat dengan sebenarnya agar dapat dipergunakan sebagai persyaratan pengurusan Akta Kelahiran pada instansi yang berwenang.</p>
@endsection
