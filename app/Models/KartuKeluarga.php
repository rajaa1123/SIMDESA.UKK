<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    use HasFactory;

    protected $table = 'kartu_keluarga';
    
    protected $fillable = [
        'no_kk',
        'alamat',
        'kepala_keluarga',
        'status',
    ];

    public function wargas()
    {
        return $this->hasMany(Warga::class, 'kartu_keluarga_id');
    }
}