<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'warga',
                'description' => 'Role untuk masyarakat desa'
            ],
            [
                'name' => 'admin', 
                'description' => 'Role untuk staff administrasi desa'
            ],
            [
                'name' => 'kepala_desa',
                'description' => 'Role untuk kepala desa'
            ]
        ];

        foreach ($roles as $role) {
            // ✅ GUNAKAN updateOrCreate UNTUK HINDARI DUPLIKASI
            Role::updateOrCreate(
                ['name' => $role['name']], // Cari berdasarkan name
                $role // Update atau create data
            );
        }
    }
}