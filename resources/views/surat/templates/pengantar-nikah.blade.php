@extends('surat.base')



@section('content')
<p>Yang bertanda tangan di bawah ini Kepala Desa {{ $kelurahan }}, Kecamatan {{ $kecamatan }}, Kabupaten {{ $kabupaten }}, dengan ini menerangkan dengan sebenarnya bahwa:</p>

<table style="width: 100%; margin-bottom: 5px;">
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
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>{{ $jenis_kelamin }}</td>
    </tr>
    <tr>
        <td>Tempat/Tgl Lahir</td>
        <td>:</td>
        <td>{{ $tempat_lahir }}, {{ $tanggal_lahir }}</td>
    </tr>
    <tr>
        <td>Kewarganegaraan</td>
        <td>:</td>
        <td>INDONESIA</td>
    </tr>
    <tr>
        <td>Agama</td>
        <td>:</td>
        <td>{{ $agama }}</td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td>:</td>
        <td>{{ $pekerjaan }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $alamat }} RT {{ $rt }} RW {{ $rw }}</td>
    </tr>
    <tr>
        <td>Status Perkawinan</td>
        <td>:</td>
        <td style="font-weight: bold;">{{ strtoupper($form_data['status_perkawinan'] ?? 'JEJAKA/PERAWAN') }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Nama tersebut di atas adalah benar-benar penduduk Desa {{ $kelurahan }} Kecamatan {{ $kecamatan }} and merupakan anak dari pasangan suami istri:</p>

<table style="width: 100%; margin-bottom: 5px;">
    <tr>
        <td style="width: 30%;">Nama Ayah</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($form_data['nama_ayah'] ?? '-') }}</td>
    </tr>
    <tr>
        <td>Nama Ibu</td>
        <td>:</td>
        <td style="font-weight: bold;">{{ strtoupper($form_data['nama_ibu'] ?? '-') }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Yang bersangkutan bermaksud akan melangsungkan pernikahan dengan calon pasangan sebagai berikut:</p>

<table style="width: 100%; margin-bottom: 5px; border: 1px dotted #000; padding: 5px;">
    <tr>
        <td style="width: 30%;">Nama Lengkap</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%; font-weight: bold;">{{ strtoupper($form_data['nama_calon_pasangan'] ?? '-') }}</td>
    </tr>
    <tr>
        <td>Tempat/Tgl Lahir</td>
        <td>:</td>
        <td>
            {{ $form_data['tempat_lahir_pasangan'] ?? '-' }}, 
            {{ isset($form_data['tanggal_lahir_pasangan']) ? \Carbon\Carbon::parse($form_data['tanggal_lahir_pasangan'])->locale('id')->isoFormat('D MMMM YYYY') : '-' }}
        </td>
    </tr>
    <tr>
        <td>Agama</td>
        <td>:</td>
        <td>{{ $form_data['agama_pasangan'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td>:</td>
        <td>{{ $form_data['pekerjaan_pasangan'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>Alamat Calon</td>
        <td>:</td>
        <td style="font-style: italic;">{{ $form_data['alamat_pasangan'] ?? '-' }}</td>
    </tr>
</table>

<p style="text-indent: 45px;">Demikian Surat Pengantar Nikah ini kami buat dengan sebenarnya agar dapat dipergunakan sebagai persyaratan kelengkapan administrasi pada Kantor Urusan Agama (KUA) setempat.</p>
@endsection
