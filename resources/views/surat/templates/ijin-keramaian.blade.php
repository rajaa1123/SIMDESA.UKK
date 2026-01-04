@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Penanggung Jawab</td>
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
        <td>{{ $alamat }}</td>
    </tr>
</table>

<p>Bermaksud mengadakan kegiatan keramaian dengan rincian:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Jenis Acara</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['jenis_acara'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td>{{ isset($form_data['tanggal_acara']) ? \Carbon\Carbon::parse($form_data['tanggal_acara'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
    <tr>
        <td>Waktu</td>
        <td>:</td>
        <td>{{ $form_data['waktu_mulai'] ?? '-' }} s/d {{ $form_data['waktu_selesai'] ?? '-' }} WIB</td>
    </tr>
    <tr>
        <td>Lokasi</td>
        <td>:</td>
        <td>{{ $form_data['lokasi_acara'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Perkiraan Tamu</td>
        <td>:</td>
        <td>{{ $form_data['perkiraan_jumlah_tamu'] ?? '-' }} Orang</td>
    </tr>
</table>

<p>Pada prinsipnya kami tidak keberatan dengan kegiatan tersebut sepanjang mematuhi peraturan yang berlaku dan menjaga ketertiban umum.</p>

<p>Demikian Surat Pengantar Ijin Keramaian ini dibuat untuk dapat dipergunakan sebagai persyaratan pengurusan ijin di kepolisian setempat.</p>
@endsection
