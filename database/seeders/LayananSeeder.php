<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        Layanan::query()->delete();

        // LAYANAN ADMINISTRASI UMUM

        // layanan 2
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN KEMATIAN',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat keterangan resmi terkait kematian warga sebagai dasar pengurusan akta kematian.',
            'template_slug' => 'kematian',
        ]);

        // layanan 3
        Layanan::create([
            'nama_layanan' => 'SURAT DOMISILI TEMPAT TINGGAL',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pernyataan tempat tinggal bagi penduduk baru atau sementara.',
            'template_slug' => 'domisili',
        ]);

        // layanan 4
        Layanan::create([
            'nama_layanan' => 'SURAT PERNYATAAN AHLI WARIS',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pernyataan resmi untuk menentukan ahli waris sah dari almarhum',
            'template_slug' => 'ahli-waris',
        ]);

        // layanan 5
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN RIWAYAT TANAH',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat keterangan asal-usul dan riwayat kepemilikan tanah.',
            'template_slug' => 'riwayat-tanah',
        ]);

        // layanan 6
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN BEDA NAMA',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pernyataan bahwa dua nama berbeda merujuk pada orang yang sama.',
            'template_slug' => 'beda-nama',
        ]);

        // layanan 7
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN JANDA / DUDA',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pernyataan status perkawinan setelah bercerai atau ditinggal pasangan.',
            'template_slug' => 'janda-duda',
        ]);

        // layanan 8
        Layanan::create([
            'nama_layanan' => 'LEGALISASI DOKUMEN',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Pengesahan dokumen oleh kelurahan agar diakui keabsahannya.',
            'template_slug' => 'legalisasi',
        ]);

        // layanan 9
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN BELUM MENIKAH',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat yang menyatakan bahwa pemohon belum pernah menikah.',
            'template_slug' => 'belum-menikah',
        ]);

        // layanan 10
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN DOMISILI USAHA',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat yang menyatakan keberadaan usaha di wilayah kelurahan.',
            'template_slug' => 'domisili-usaha',
        ]);

        // layanan 11
        Layanan::create([
            'nama_layanan' => 'SURAT PENGANTAR IJIN KERAMAIAN',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pengantar izin kegiatan masyarakat (acara, hajatan, dll)..',
            'template_slug' => 'ijin-keramaian',
        ]);

        // layanan 12
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN TIDAK MAMPU (SKTM)',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pernyataan kondisi ekonomi warga kurang mampu untuk keperluan bantuan.',
            'template_slug' => 'sktm',
        ]);

        // layanan 13
        Layanan::create([
            'nama_layanan' => 'SURAT PENGANTAR NIKAH',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pengantar administrasi untuk pencatatan pernikahan di KUA.',
            'template_slug' => 'pengantar-nikah',
        ]);

        // layanan 14
        Layanan::create([
            'nama_layanan' => 'PENANGANAN PENGADUAN MASYARAKAT',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Fasilitasi keluhan dan laporan warga terhadap pelayanan publik.',
            'template_slug' => 'pengaduan',
        ]);

        // LAYANAN ADMINISTRASI KEPENDUDUKAN

        // layanan 1
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN KTP ELEKTRONIK',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pembuatan atau pencetakan ulang e-KTP bagi warga usia 17 tahun ke atas.',
            'template_slug' => 'ktp',
        ]);

        // layanan 2
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN KARTU KELUARGA (KK)',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pembuatan KK baru atau pembaruan data anggota keluarga..',
            'template_slug' => 'kk',
        ]);

        // layanan 3
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN KARTU IDENTITAS ANAK (KIA)',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pembuatan KIA bagi anak usia di bawah 17 tahun.',
            'template_slug' => 'kia',
        ]);

        // layanan 4
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN PINDAH TEMPAT',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pengajuan surat pindah domisili antar wilayah.',
            'template_slug' => 'pindah-tempat',
        ]);

        // layanan 5
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN PEMBATALAN PINDAH',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pembatalan surat pindah karena perubahan rencana tempat tinggal.',
            'template_slug' => 'pembatalan-pindah',
        ]);

        // layanan 6
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN PINDAH DATANG',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pengajuan administrasi kedatangan warga dari daerah lain.',
            'template_slug' => 'pindah-datang',
        ]);

        // layanan 7
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN AKTE KELAHIRAN',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pengajuan akta kelahiran anak yang baru lahir.',
            'template_slug' => 'akte-kelahiran',
        ]);

        // layanan 8
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN AKTE KEMATIAN',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pengajuan akta kematian warga yang telah meninggal.',
            'template_slug' => 'akte-kematian',
        ]);

        // layanan 9
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN AKTE PERCERAIAN',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pengajuan akta perceraian berdasarkan putusan pengadilan.',
            'template_slug' => 'akte-perceraian',
        ]);

        // layanan 10
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN AKTE PERKAWINAN',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pengajuan akta perkawinan bagi pasangan yang telah menikah.',
            'template_slug' => 'akte-perkawinan',
        ]);

        // layanan 11
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN PEDULI DILAN',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pendaftaran program pelayanan kependudukan keliling (jemput bola).',
            'template_slug' => 'peduli-dilan',
        ]);
    }
}
