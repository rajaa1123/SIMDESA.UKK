<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        try {
            // Create Admin Account
            $adminRole = Role::where('name', 'admin')->first();
            if (!$adminRole) {
                $this->command->error('Role admin not found!');
                return;
            }
            $this->command->info('Creating Admin user...');
            
            User::updateOrCreate(
                ['email' => 'admin@desa.id'],
                [
                    'name' => 'Administrator Desa',
                    'email' => 'admin@desa.id',
                    'password' => Hash::make('password'),
                    'phone' => '081234567890',
                    'role_id' => $adminRole->id,
                    'email_verified_at' => now(),
                ]
            );

            // Create Kepala Desa Account
            $kadesRole = Role::where('name', 'kepala_desa')->first();
            if (!$kadesRole) {
                $this->command->error('Role kepala_desa not found!');
                return;
            }
            $this->command->info('Creating Kepala Desa user...');

            User::updateOrCreate(
                ['email' => 'kades@desa.id'],
                [
                    'name' => 'Kepala Desa',
                    'email' => 'kades@desa.id',
                    'password' => Hash::make('password'),
                    'phone' => '081234567891',
                    'role_id' => $kadesRole->id,
                    'email_verified_at' => now(),
                ]
            );

            // Create Warga Account (for testing)
            $wargaRole = Role::where('name', 'warga')->first();
            if (!$wargaRole) {
                $this->command->error('Role warga not found!');
                return;
            }
            $this->command->info('Creating Warga user...');

            User::updateOrCreate(
                ['email' => 'warga@desa.id'],
                [
                    'name' => 'Warga Contoh',
                    'email' => 'warga@desa.id',
                    'password' => Hash::make('password'),
                    'phone' => '081234567892',
                    'role_id' => $wargaRole->id,
                    'email_verified_at' => now(),
                ]
            );

            $this->command->info('✓ Users seeded successfully (Admin, Kepala Desa, Warga)');
        } catch (\Exception $e) {
            $this->command->error('Error seeding users: ' . $e->getMessage());
        }
    }
}
