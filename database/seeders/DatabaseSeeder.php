<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            StatusSeeder::class,
            UserSeeder::class,  // Includes Admin, Kepala Desa, and Warga
            LayananSeeder::class,
            DokumenSeeder::class,
            PersyaratanSeeder::class,
        ]);
    }
}