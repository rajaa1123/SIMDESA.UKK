<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;
use App\Models\Dokumen;
use App\Models\Persyaratan;

class PersyaratanSeeder extends Seeder
{
    public function run(): void
    {
        Persyaratan::query()->delete();

        // Helper function to attach requirements
        $attach = function ($layananName, $dokumenNames) {
            $layanan = Layanan::where('nama_layanan', $layananName)->first();
            if (!$layanan) return;

            foreach ($dokumenNames as $docName => $isWajib) {
                // Handle array format or simple string
                $name = is_int($docName) ? $isWajib : $docName;
                $wajib = is_int($docName) ? true : $isWajib; // Default true if key is int

                $dokumen = Dokumen::where('nama_dokumen', $name)->first();
                if ($dokumen) {
                    Persyaratan::create([
                        'layanan_id' => $layanan->id,
                        'dokumen_id' => $dokumen->id,
                        'wajib' => $wajib,
                    ]);
                }
            }
        };

        // --- LAYANAN ADMINISTRASI UMUM ---

        $attach('SURAT KETERANGAN KEMATIAN', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Surat Keterangan Kematian dari RS/Dokter'
        ]);

        $attach('SURAT DOMISILI TEMPAT TINGGAL', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Pas Foto (2x3 atau 3x4 atau 4x6)' => false // Opsional
        ]);

        $attach('SURAT PERNYATAAN AHLI WARIS', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Surat Keterangan Kematian Pewaris',
            'Surat Pernyataan'
        ]);

        $attach('SURAT KETERANGAN RIWAYAT TANAH', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Bukti Kepemilikan Tanah / Sertifikat Tanah'
        ]);

        $attach('SURAT KETERANGAN BEDA NAMA', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Surat Pernyataan'
        ]);

        $attach('SURAT KETERANGAN JANDA / DUDA', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Akta Cerai / Surat Perceraian dari Pengadilan' => false,
            'Surat Keterangan Kematian dari RS/Dokter' => false,
            'Surat Pernyataan'
        ]);

        $attach('LEGALISASI DOKUMEN', [
            'Dokumen Asli untuk Legalisasi',
            'Fotokopi KTP'
        ]);

        $attach('SURAT KETERANGAN BELUM MENIKAH', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Surat Pernyataan'
        ]);

        $attach('SURAT KETERANGAN DOMISILI USAHA', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Foto Tempat Usaha'
        ]);

        $attach('SURAT PENGANTAR IJIN KERAMAIAN', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Surat Rencana Kegiatan'
        ]);

        $attach('SURAT KETERANGAN TIDAK MAMPU (SKTM)', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Foto Tempat Usaha' => false // Jika ada usaha kecil
        ]);

        $attach('SURAT PENGANTAR NIKAH', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Akta Kelahiran',
            'Pas Foto (2x3 atau 3x4 atau 4x6)'
        ]);

        $attach('PENANGANAN PENGADUAN MASYARAKAT', [
            'Fotokopi KTP',
            'Bukti atau Dokumen Pendukung Pengaduan'
        ]);

        // --- LAYANAN ADMINISTRASI KEPENDUDUKAN ---

        $attach('PERMOHONAN KTP ELEKTRONIK', [
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Akta Kelahiran' => false
        ]);

        $attach('PERMOHONAN KARTU KELUARGA (KK)', [
            'Surat Pengantar RT/RW',
            'Akta Nikah / Buku Nikah',
            'Akta Kelahiran' => false
        ]);

        $attach('PERMOHONAN KARTU IDENTITAS ANAK (KIA)', [
            'Fotokopi Kartu Keluarga (KK)',
            'Akta Kelahiran',
            'Pas Foto (2x3 atau 3x4 atau 4x6)' => false // Untuk anak > 5 tahun
        ]);

        $attach('PERMOHONAN PINDAH TEMPAT', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW'
        ]);

        $attach('PERMOHONAN PEMBATALAN PINDAH', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Permohonan Pembatalan Pindah'
        ]);

        $attach('PERMOHONAN PINDAH DATANG', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pindah dari Daerah Asal',
            'Surat Pengantar RT/RW'
        ]);

        $attach('PERMOHONAN AKTE KELAHIRAN', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Keterangan Lahir dari Bidan/RS',
            'Surat Nikah Orang Tua (untuk akta kelahiran anak)',
            'KTP dan KK Orang Tua'
        ]);

        $attach('PERMOHONAN AKTE KEMATIAN', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Keterangan Kematian dari RS/Dokter',
            'KTP dan KK Orang Tua' => false // Jika yg meninggal anak
        ]);

        $attach('PERMOHONAN AKTE PERCERAIAN', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Putusan Pengadilan (khusus perceraian)',
            'Akta Nikah / Buku Nikah'
        ]);

        $attach('PERMOHONAN AKTE PERKAWINAN', [
            'Fotokopi KTP',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Pas Foto (2x3 atau 3x4 atau 4x6)'
        ]);
        
        $attach('PERMOHONAN PEDULI DILAN', [
             'Fotokopi KTP',
             'Fotokopi Kartu Keluarga (KK)'
        ]);
    }
}
