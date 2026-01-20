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
        <td>Alamat Domisili</td>
        <td>:</td>
        <td>{{ $alamat }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Berdasarkan catatan register kependudukan Desa {{ $kelurahan }} serta bukti akta kematian yang ada, nama tersebut di atas adalah benar-benar penduduk Desa {{ $kelurahan }} yang saat ini berstatus:</p>

<h3 style="text-align: center; border: 1px solid #000; padding: 10px; width: fit-content; margin: 20px auto;">{{ strtoupper($form_data['status_perkawinan'] ?? 'JANDA/DUDA') }}</h3>

<p style="text-indent: 45px;">Status tersebut diakibatkan karena pasangan yang bernama <strong>{{ strtoupper($form_data['nama_pasangan'] ?? '-') }}</strong> telah meninggal dunia pada tanggal {{ isset($form_data['tanggal_meninggal_pasangan']) ? \Carbon\Carbon::parse($form_data['tanggal_meninggal_pasangan'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}.</p>

<p style="text-indent: 45px;">Demikian Surat Keterangan ini kami buat dengan sebenarnya agar dapat dipergunakan sebagai persyaratan administratif serta keperluan lainnya yang sah menurut hukum.</p>
@endsection
