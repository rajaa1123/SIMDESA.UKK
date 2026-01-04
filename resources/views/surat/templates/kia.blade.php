@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Orang Tua</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $nama }}</td>
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

<p>Mengajukan permohonan pembuatan Kartu Identitas Anak (KIA) untuk anak:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Anak</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['nama_anak'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td>{{ isset($form_data['tanggal_lahir_anak']) ? \Carbon\Carbon::parse($form_data['tanggal_lahir_anak'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
</table>

<p>Demikian surat pengantar ini dibuat untuk dapat dipergunakan sebagai persyaratan pengurusan KIA di Dinas Kependudukan dan Pencatatan Sipil.</p>
@endsection
