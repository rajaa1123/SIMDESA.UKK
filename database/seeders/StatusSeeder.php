<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            // Status untuk pengajuan layanan (sistem baru dengan approval berjenjang)
            ['group_key' => 'pengajuan', 'code' => 'pending', 'name' => 'Menunggu Verifikasi Admin'],
            ['group_key' => 'pengajuan', 'code' => 'menunggu_persetujuan_kades', 'name' => 'Menunggu Persetujuan Kepala Desa'],
            ['group_key' => 'pengajuan', 'code' => 'selesai', 'name' => 'Selesai'],
            ['group_key' => 'pengajuan', 'code' => 'ditolak', 'name' => 'Ditolak'],
            
            // Status lama untuk backward compatibility (permohonan)
            ['group_key' => 'permohonan', 'code' => 'baru', 'name' => 'Menunggu Diproses'],
            ['group_key' => 'permohonan', 'code' => 'diproses', 'name' => 'Sedang Diproses'],
            ['group_key' => 'permohonan', 'code' => 'ditolak', 'name' => 'Ditolak'],
            ['group_key' => 'permohonan', 'code' => 'selesai', 'name' => 'Selesai'],
            
            // Status untuk dokumen
            ['group_key' => 'dokumen', 'code' => 'valid', 'name' => 'Valid'],
            ['group_key' => 'dokumen', 'code' => 'invalid', 'name' => 'Tidak Valid'],
            ['group_key' => 'dokumen', 'code' => 'revisi', 'name' => 'Perlu Revisi'],
        ];

        foreach ($statuses as $status) {
            Status::updateOrCreate(
                [
                    'group_key' => $status['group_key'],
                    'code' => $status['code']
                ],
                $status
            );
        }
    }
}