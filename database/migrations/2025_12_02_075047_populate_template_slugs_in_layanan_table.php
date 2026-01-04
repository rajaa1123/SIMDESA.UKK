<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $slugs = [
            'SURAT KETERANGAN KEMATIAN' => 'kematian',
            'SURAT DOMISILI TEMPAT TINGGAL' => 'domisili',
            'SURAT PERNYATAAN AHLI WARIS' => 'ahli-waris',
            'SURAT KETERANGAN RIWAYAT TANAH' => 'riwayat-tanah',
            'SURAT KETERANGAN BEDA NAMA' => 'beda-nama',
            'SURAT KETERANGAN JANDA / DUDA' => 'janda-duda',
            'LEGALISASI DOKUMEN' => 'legalisasi',
            'SURAT KETERANGAN BELUM MENIKAH' => 'belum-menikah',
            'SURAT KETERANGAN DOMISILI USAHA' => 'domisili-usaha',
            'SURAT PENGANTAR IJIN KERAMAIAN' => 'ijin-keramaian',
            'SURAT KETERANGAN TIDAK MAMPU (SKTM)' => 'sktm',
            'SURAT PENGANTAR NIKAH' => 'pengantar-nikah',
            'PENANGANAN PENGADUAN MASYARAKAT' => 'pengaduan',
            'PERMOHONAN KTP ELEKTRONIK' => 'ktp',
            'PERMOHONAN KARTU KELUARGA (KK)' => 'kk',
            'PERMOHONAN KARTU IDENTITAS ANAK (KIA)' => 'kia',
            'PERMOHONAN PINDAH TEMPAT' => 'pindah-tempat',
            'PERMOHONAN PEMBATALAN PINDAH' => 'pembatalan-pindah',
            'PERMOHONAN PINDAH DATANG' => 'pindah-datang',
            'PERMOHONAN AKTE KELAHIRAN' => 'akte-kelahiran',
            'PERMOHONAN AKTE KEMATIAN' => 'akte-kematian',
            'PERMOHONAN AKTE PERCERAIAN' => 'akte-perceraian',
            'PERMOHONAN AKTE PERKAWINAN' => 'akte-perkawinan',
            'PERMOHONAN PEDULI DILAN' => 'peduli-dilan',
        ];

        foreach ($slugs as $nama => $slug) {
            DB::table('layanan')->where('nama_layanan', $nama)->update(['template_slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('layanan')->update(['template_slug' => null]);
    }
};
