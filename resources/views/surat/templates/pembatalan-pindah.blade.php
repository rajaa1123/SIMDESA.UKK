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
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $alamat }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Nama tersebut di atas mengajukan permohonan <strong>PERNYATAAN PEMBATALAN PINDAH</strong> atas Surat Pengantar Pindah yang sebelumnya telah diterbitkan dengan rincian:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nomor Surat Pindah</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ $form_data['nomor_surat_pindah'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Alasan Pembatalan</td>
        <td>:</td>
        <td style="font-style: italic;">{{ $form_data['alasan_pembatalan'] ?? '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Demikian surat keterangan ini kami buat dengan sebenarnya agar yang bersangkutan dapat kembali tercatat secara aktif sebagai penduduk Desa {{ $kelurahan }} and dipergunakan sebagaimana mestinya pada instansi terkait.</p>
@endsection
