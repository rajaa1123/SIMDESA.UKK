@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan bahwa telah menerima pengaduan / aspirasi dari masyarakat:</p>

<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 30%;">Nama Pelapor</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($nama) }}</td>
    </tr>
    <tr>
        <td>NIK Pelapor</td>
        <td>:</td>
        <td>{{ $nik }}</td>
    </tr>
    <tr>
        <td>Alamat Pelapor</td>
        <td>:</td>
        <td>{{ $alamat }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Disampaikan perihal pengaduan sebagai berikut:</p>
<h3 style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin: 15px 0;">{{ strtoupper($form_data['perihal_pengaduan'] ?? 'PENGADUAN MASYARAKAT') }}</h3>

<p><strong>Uraian Pengaduan :</strong></p>
<p style="font-style: italic; border: 1px solid #ddd; padding: 10px; background: #f9f9f9;">{{ $form_data['uraian_pengaduan'] ?? '-' }}</p>

<p><strong>Tindakan yang Diharapkan :</strong></p>
<p>{{ $form_data['tindakan_diharapkan'] ?? '-' }}</p>

<p style="text-indent: 45px;">Pengaduan ini telah secara resmi kami terima and akan segera diproses lebih lanjut melalui fungsi mediasi atau koordinasi dengan instansi terkait sesuai dengan ketentuan peraturan yang berlaku di wilayah Desa {{ $kelurahan }}.</p>

<p style="text-indent: 45px;">Demikian Surat Tanda Terima Pengaduan ini kami buat dengan sebenarnya sebagai bukti administrasi pelaporan masyarakat.</p>
@endsection
