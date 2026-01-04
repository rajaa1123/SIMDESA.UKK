@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Ayah</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['nama_ayah'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Nama Ibu</td>
        <td>:</td>
        <td>{{ $form_data['nama_ibu'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $alamat }} RT {{ $rt }} RW {{ $rw }}</td>
    </tr>
</table>

<p>Telah lahir seorang anak:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Anak</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['nama_anak_lengkap'] ?? '-' }}</td>
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
        <td>{{ $form_data['anak_ke'] ?? '-' }}</td>
    </tr>
</table>

<p>Demikian surat keterangan kelahiran ini dibuat untuk dapat dipergunakan sebagai persyaratan pengurusan Akta Kelahiran.</p>
@endsection
