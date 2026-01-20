@extends('surat.base')

@section('compact_class', 'compact')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%; margin-bottom: 5px;">
    <tr>
        <td style="width: 30%;">Nama Penanggung Jawab</td>
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
        <td>{{ $alamat }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Nama tersebut di atas adalah penanggung jawab kegiatan yang bermaksud menyelenggarakan acara hiburan / keramaian di wilayah Desa {{ $kelurahan }} dengan rincian sebagai berikut:</p>

<table style="width: 100%; margin-bottom: 5px; border: 1px solid #000; padding: 5px;">
    <tr>
        <td style="width: 30%;">Jenis Acara</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($form_data['jenis_acara'] ?? '-') }}</td>
    </tr>
    <tr>
        <td>Waktu Pelaksanaan</td>
        <td>:</td>
        <td>{{ isset($form_data['tanggal_acara']) ? \Carbon\Carbon::parse($form_data['tanggal_acara'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
    <tr>
        <td>Jam Pelaksanaan</td>
        <td>:</td>
        <td>Pukul {{ $form_data['waktu_mulai'] ?? '-' }} s/d {{ $form_data['waktu_selesai'] ?? '-' }} WIB</td>
    </tr>
    <tr>
        <td>Lokasi Acara</td>
        <td>:</td>
        <td>{{ $form_data['lokasi_acara'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Estimasi Massa</td>
        <td>:</td>
        <td>Kurang lebih {{ $form_data['perkiraan_jumlah_tamu'] ?? '-' }} Orang</td>
    </tr>
</table>

<p style="text-indent: 45px;">Pada dasarnya Pemerintah Desa {{ $kelurahan }} tidak keberatan atas rencana kegiatan tersebut sepanjang pihak penyelenggara sanggup menjaga keamanan, ketertiban, kebersihan, serta mematuhi norma-norma dan peraturan perundang-undangan yang berlaku.</p>

<p style="text-indent: 45px;">Demikian Surat Pengantar Ijin Keramaian ini kami buat dengan sebenarnya agar dapat dipergunakan sebagai bahan pertimbangan dalam pengurusan ijin keramaian di Kepolisian Sektor (Polsek) {{ $kecamatan }} atau instansi berwenang lainnya.</p>
@endsection
