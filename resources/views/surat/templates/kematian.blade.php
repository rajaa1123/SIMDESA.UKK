@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nama Lengkap</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($form_data['nama_almarhum'] ?? '-') }}</td>
    </tr>
    <tr>
        <td>Tanggal Meninggal</td>
        <td>:</td>
        <td>{{ isset($form_data['tanggal_meninggal']) ? \Carbon\Carbon::parse($form_data['tanggal_meninggal'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</td>
    </tr>
    <tr>
        <td>Tempat Meninggal</td>
        <td>:</td>
        <td>{{ $form_data['tempat_meninggal'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Sebab Kematian</td>
        <td>:</td>
        <td>{{ $form_data['sebab_kematian'] ?? '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Berdasarkan catatan kependudukan dan laporan kematian dari pihak keluarga, nama tersebut di atas adalah benar-benar penduduk Desa {{ $kelurahan }} yang telah meninggal dunia pada waktu dan tempat sebagaimana tercantum di atas.</p>

<p style="text-indent: 45px;">Surat keterangan ini diterbitkan berdasarkan laporan dari:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nama Pelapor</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($nama) }}</td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>:</td>
        <td>{{ $nik }}</td>
    </tr>
    <tr>
        <td>Hubungan Keluarga</td>
        <td>:</td>
        <td>{{ $form_data['hubungan_pelapor'] ?? '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Demikian Surat Keterangan Kematian ini kami buat dengan sebenarnya agar dapat dipergunakan sebagai persyaratan pengurusan Akta Kematian serta keperluan administrasi lainnya.</p>
@endsection
