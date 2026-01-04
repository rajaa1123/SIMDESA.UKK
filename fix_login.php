<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "--- FIXING USER LOGIN ---\n";

$accounts = [
    'admin@desa.id' => 'Administrator Desa',
    'kades@desa.id' => 'Kepala Desa',
    'warga@desa.id' => 'Warga Contoh'
];

foreach ($accounts as $email => $name) {
    // Cari user, termasuk yang sudah di-soft delete
    $user = User::withTrashed()->where('email', $email)->first();

    if ($user) {
        echo "Found user: $name ($email)\n";
        
        // 1. Restore if deleted
        if ($user->trashed()) {
            $user->restore();
            echo "  - Restored from trash (Soft Delete)\n";
        }

        // 2. Force Reset Password
        $user->password = Hash::make('password');
        
        // 3. Ensure Role is correct (just in case)
        // Kita tidak ubah role disini agar tidak merusak relasi, tapi kita pastikan user aktif
        
        $user->save();
        echo "  - Password RESET to 'password'\n";
        echo "  - User updated successfully.\n";
    } else {
        echo "WARNING: User $name ($email) NOT FOUND in database!\n";
        echo "  - Please run: php artisan db:seed --class=UserSeeder\n";
    }
    echo "------------------------\n";
}

echo "Done. Try logging in now.\n";
