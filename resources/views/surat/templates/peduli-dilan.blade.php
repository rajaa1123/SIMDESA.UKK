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

<p style="text-indent: 45px;">Nama tersebut di atas telah secara resmi mengajukan permohonan layanan <strong>PEDULI DILAN (Pelayanan Adminduk Keliling)</strong> untuk jenis layanan administratif sebagai berikut:</p>

<h3 style="text-align: center; border: 1px dashed #000; padding: 10px; margin: 15px 0;">{{ strtoupper($form_data['jenis_layanan_dilan'] ?? 'LAYANAN ADMINISTRASI KELILING') }}</h3>

<p style="text-indent: 45px;">Keperluan Khusus : {{ $form_data['keperluan_khusus'] ?? '-' }}</p>

<p style="text-indent: 45px;">Permohonan ini telah secara resmi kami catat and akan segera dijadwalkan dalam agenda kunjungan tim pelayanan keliling Desa {{ $kelurahan }} ke lokasi domisili pemohon.</p>

<p style="text-indent: 45px;">Demikian surat keterangan ini kami buat sebagai bukti pendaftaran layanan Peduli Dilan and agar dipergunakan sebagaimana mestinya.</p>
@endsection
