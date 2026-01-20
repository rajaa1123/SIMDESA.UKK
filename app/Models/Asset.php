<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'asets';

    protected $fillable = [
        'nama_aset',
        'kode_aset',
        'kategori',
        'kondisi',
        'tanggal_perolehan',
        'nilai_perolehan',
        'lokasi',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_perolehan' => 'date',
        'nilai_perolehan' => 'decimal:2',
    ];
}
