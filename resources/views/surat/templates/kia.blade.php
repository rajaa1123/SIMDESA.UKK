@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nama Orang Tua</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($nama) }}</td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>:</td>
        <td>{{ $nik }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $alamat }} RT {{ $rt }} RW {{ $rw }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Berdasarkan permohonan yang diajukan, nama tersebut di atas bermaksud mengurus dokumen identitas untuk anaknya:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nama Anak</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($form_data['nama_anak'] ?? '-') }}</td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td>{{ isset($form_data['tanggal_lahir_anak']) ? \Carbon\Carbon::parse($form_data['tanggal_lahir_anak'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Demikian surat pengantar ini kami buat dengan sebenarnya sebagai persyaratan pengajuan Kartu Identitas Anak (KIA) pada Dinas Kependudukan dan Pencatatan Sipil agar dapat diproses sebagaimana mestinya.</p>
@endsection
