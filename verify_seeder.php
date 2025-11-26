<?php

use App\Models\Layanan;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$layanan = Layanan::where('nama_layanan', 'SURAT KETERANGAN KEMATIAN')->first();
if ($layanan) {
    echo "Layanan: " . $layanan->nama_layanan . "\n";
    echo "Persyaratan:\n";
    foreach ($layanan->persyaratan as $p) {
        echo "- " . $p->dokumen->nama_dokumen . " (" . ($p->wajib ? 'Wajib' : 'Opsional') . ")\n";
    }
} else {
    echo "Layanan not found.\n";
}
