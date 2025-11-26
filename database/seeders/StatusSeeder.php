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
            // Status untuk permohonan
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
            // ✅ GUNAKAN updateOrCreate
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