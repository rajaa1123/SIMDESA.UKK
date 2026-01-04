@extends('surat.base')

@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 30%;">Nama Saat Ini</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ $form_data['nama_sekarang'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Nama Lama/Berbeda</td>
        <td>:</td>
        <td>{{ $form_data['nama_lama'] ?? '-' }}</td>
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

<p>Adalah benar-benar orang yang sama, namun terdapat perbedaan penulisan nama pada dokumen:</p>

<p><strong>{{ $form_data['dokumen_berbeda'] ?? '-' }}</strong></p>

<p>Penjelasan perbedaan:</p>
<p>{{ $form_data['perbedaan'] ?? '-' }}</p>

<p>Demikian Surat Keterangan Beda Nama ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
@endsection
