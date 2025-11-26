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
        // layanan 1
         

        // layanan 2
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN KEMATIAN',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat keterangan resmi terkait kematian warga sebagai dasar pengurusan akta kematian.',
            'durasi_proses' => '1 hari kerja',
            'biaya' => 'Gratis',
        ]);

        // layanan 3
        Layanan::create([
            'nama_layanan' => 'SURAT DOMISILI TEMPAT TINGGAL',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pernyataan tempat tinggal bagi penduduk baru atau sementara.',
            'durasi_proses' => '1-2 hari kerja',
            'biaya' => 'Rp10.000 (materai)',
        ]);

        // layanan 4
        Layanan::create([
            'nama_layanan' => 'SURAT PERNYATAAN AHLI WARIS',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pernyataan resmi untuk menentukan ahli waris sah dari almarhum',
            'durasi_proses' => '2-3 hari kerja',
            'biaya' => 'Rp10.000 (materai)',
        ]);

        // layanan 5
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN RIWAYAT TANAH',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat keterangan asal-usul dan riwayat kepemilikan tanah.',
            'durasi_proses' => '3 hari kerja',
            'biaya' => 'Gratis', 
        ]);

        // layanan 6
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN BEDA NAMA',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pernyataan bahwa dua nama berbeda merujuk pada orang yang sama.',
            'durasi_proses' => '1-2 hari kerja',
            'biaya' => 'Gratis',
        ]);

        // layanan 7
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN JANDA / DUDA',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pernyataan status perkawinan setelah bercerai atau ditinggal pasangan.',
            'durasi_proses' => '1-2 hari kerja',
            'biaya' => 'Gratis',
        ]);

        // layanan 8
        Layanan::create([
            'nama_layanan' => 'LEGALISASI DOKUMEN',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Pengesahan dokumen oleh kelurahan agar diakui keabsahannya.',
            'durasi_proses' => '1 hari kerja',
            'biaya' => 'Rp5.000-Rp10.000 per lembar',
        ]);

        // layanan 9
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN BELUM MENIKAH',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat yang menyatakan bahwa pemohon belum pernah menikah.',
            'durasi_proses' => '1 hari kerja',
            'biaya' => 'Gratis',
        ]);

        // layanan 10
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN DOMISILI USAHA',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat yang menyatakan keberadaan usaha di wilayah kelurahan.',
            'durasi_proses' => '2 hari kerja',
            'biaya' => 'Rp10.000 (materai)',
        ]);

        // layanan 11
        Layanan::create([
            'nama_layanan' => 'SURAT PENGANTAR IJIN KERAMAIAN',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pengantar izin kegiatan masyarakat (acara, hajatan, dll)..',
            'durasi_proses' => '1 hari kerja',
            'biaya' => 'Gratis',        
        ]);

        // layanan 12
        Layanan::create([
            'nama_layanan' => 'SURAT KETERANGAN TIDAK MAMPU (SKTM)',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pernyataan kondisi ekonomi warga kurang mampu untuk keperluan bantuan.',
            'durasi_proses' => '1 hari kerja',
            'biaya' => 'Gratis',
        ]);


        // layanan 13
        Layanan::create([
            'nama_layanan' => 'SURAT PENGANTAR NIKAH',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Surat pengantar administrasi untuk pencatatan pernikahan di KUA.',
            'durasi_proses' => '1 hari kerja',
            'biaya' => 'Gratis',
        ]);


        // layanan 14
        Layanan::create([
            'nama_layanan' => 'PENANGANAN PENGADUAN MASYARAKAT',
            'kategori' => 'Layanan Administrasi Umum',
            'deskripsi' => 'Fasilitasi keluhan dan laporan warga terhadap pelayanan publik.',
            'durasi_proses' => '1-3 hari kerja tergantung kasus',
            'biaya' => 'Gratis',
        ]);


        // LAYANAN ADMINISTRASI KEPENDUDUKAN


        // layanan 1
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN KTP ELEKTRONIK',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pembuatan atau pencetakan ulang e-KTP bagi warga usia 17 tahun ke atas.',
            'durasi_proses' => '3-5 hari kerja',
            'biaya' => 'Gratis',
        ]);


        // layanan 2
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN KARTU KELUARGA (KK)',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pembuatan KK baru atau pembaruan data anggota keluarga..',
            'durasi_proses' => '2-3 hari kerja',
            'biaya' => 'Gratis',
        ]);


        // layanan 3
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN KARTU IDENTITAS ANAK (KIA)',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pembuatan KIA bagi anak usia di bawah 17 tahun.',
            'durasi_proses' => '3 hari kerja',
            'biaya' => 'Gratis',
        ]);


        // layanan 4
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN PINDAH TEMPAT',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pengajuan surat pindah domisili antar wilayah.',
            'durasi_proses' => '2-3 hari kerja',
            'biaya' => 'Gratis',
        ]);


        // layanan 5
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN PEMBATALAN PINDAH',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pembatalan surat pindah karena perubahan rencana tempat tinggal.',
            'durasi_proses' => '1-2 hari kerja',
            'biaya' => 'Gratis',
        ]);


        // layanan 6
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN PINDAH DATANG',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pengajuan administrasi kedatangan warga dari daerah lain.',
            'durasi_proses' => '2-3 hari kerja',
            'biaya' => 'Gratis',
        ]);


        // layanan 7
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN AKTE KELAHIRAN',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pengajuan akta kelahiran anak yang baru lahir.',
            'durasi_proses' => '3-5 hari kerja',
            'biaya' => 'Gratis',
        ]);


        // layanan 8
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN AKTE KEMATIAN',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pengajuan akta kematian warga yang telah meninggal.',
            'durasi_proses' => '3-5 hari kerja',
            'biaya' => 'Gratis',
        ]);


        // layanan 9
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN AKTE PERCERAIAN',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pengajuan akta perceraian berdasarkan putusan pengadilan.',
            'durasi_proses' => '3-7 hari kerja',
            'biaya' => 'Gratis',
        ]);


        // layanan 10
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN AKTE PERKAWINAN',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pengajuan akta perkawinan bagi pasangan yang telah menikah.',
            'durasi_proses' => '3-5 hari kerja',
            'biaya' => 'Gratis',
        ]);


        // layanan 11
        Layanan::create([
            'nama_layanan' => 'PERMOHONAN PEDULI DILAN',
            'kategori' => 'Layanan Administrasi Kependudukan',
            'deskripsi' => 'Pendaftaran program pelayanan kependudukan keliling (jemput bola).',
            'durasi_proses' => 'Sesuai jadwal kegiatan',
            'biaya' => 'Gratis',
        ]);
    }
}