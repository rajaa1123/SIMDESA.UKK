<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ GUNAKAN updateOrCreate UNTUK HINDARI DUPLIKASI
        User::updateOrCreate(
            [
                'email' => 'admin@desa.local' // Cari berdasarkan email
            ],
            [
                'warga_id' => null,
                'name' => 'Administrator Desa',
                'email' => 'admin@desa.local',
                'password' => bcrypt('password'),
                'phone' => '081234567890',
                'role_id' => 2, // admin
            ]
        );

        $this->command->info('Admin user created/updated successfully!');
    }
}