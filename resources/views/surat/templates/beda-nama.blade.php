@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nama Saat Ini</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($form_data['nama_sekarang'] ?? '-') }}</td>
    </tr>
    <tr>
        <td>Nama Lama / Berbeda</td>
        <td style="width: 2%;">:</td>
        <td style="font-style: italic;">{{ strtoupper($form_data['nama_lama'] ?? '-') }}</td>
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

<p style="text-indent: 45px;">Berdasarkan dokumen kependudukan dan bukti-bukti pendukung lainnya, nama-nama yang tercantum di atas adalah benar-benar <strong>SATU ORANG YANG SAMA</strong>. Adapun perbedaan penulisan tersebut terdapat pada dokumen:</p>

<p style="text-align: center; font-weight: bold; text-decoration: underline; margin: 15px 0;">{{ strtoupper($form_data['dokumen_berbeda'] ?? '-') }}</p>

<p style="text-indent: 45px;">Keterangan Perbedaan: {{ $form_data['perbedaan'] ?? '-' }}</p>

<p style="text-indent: 45px;">Demikian Surat Keterangan Beda Nama ini kami buat dengan sebenarnya agar dapat dipergunakan sebagai dasar pembetulan dokumen atau persyaratan administrasi lainnya yang diperlukan.</p>
@endsection
