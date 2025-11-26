<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dokumen;

class DokumenSeeder extends Seeder
{
    public function run(): void
    {
        Dokumen::query()->delete();

        // Tambahkan semua dokumen yang MUNGKIN diperlukan
        Dokumen::create(['nama_dokumen' => 'Fotokopi KTP']);
        Dokumen::create(['nama_dokumen' => 'Fotokopi Kartu Keluarga (KK)']);
        Dokumen::create(['nama_dokumen' => 'Surat Pengantar RT/RW']);
        Dokumen::create(['nama_dokumen' => 'Surat Keterangan Lahir dari Bidan/RS']);
        Dokumen::create(['nama_dokumen' => 'Surat Keterangan Kematian dari RS/Dokter']);
        Dokumen::create(['nama_dokumen' => 'Akta Kelahiran']);
        Dokumen::create(['nama_dokumen' => 'Akta Nikah / Buku Nikah']);
        Dokumen::create(['nama_dokumen' => 'Akta Cerai / Surat Perceraian dari Pengadilan']);
        Dokumen::create(['nama_dokumen' => 'Putusan Pengadilan (khusus perceraian)']);
        Dokumen::create(['nama_dokumen' => 'Surat Pernyataan']);
        Dokumen::create(['nama_dokumen' => 'Foto Tempat Usaha']);
        Dokumen::create(['nama_dokumen' => 'Pas Foto (2x3 atau 3x4 atau 4x6)']);
        Dokumen::create(['nama_dokumen' => 'Dokumen Asli untuk Legalisasi']);
        Dokumen::create(['nama_dokumen' => 'Bukti Kepemilikan Tanah / Sertifikat Tanah']);
        Dokumen::create(['nama_dokumen' => 'Surat Pindah dari Daerah Asal']);
        Dokumen::create(['nama_dokumen' => 'Surat Permohonan Pembatalan Pindah']);
        Dokumen::create(['nama_dokumen' => 'Surat Rencana Kegiatan']);
        Dokumen::create(['nama_dokumen' => 'Bukti atau Dokumen Pendukung Pengaduan']);
        Dokumen::create(['nama_dokumen' => 'KTP dan KK Orang Tua']);
        Dokumen::create(['nama_dokumen' => 'Surat Keterangan Kematian Pewaris']);
        Dokumen::create(['nama_dokumen' => 'Surat Nikah Orang Tua (untuk akta kelahiran anak)']);
    }
}