<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';
    
    protected $fillable = [
        'nama_layanan',
        'kategori',
        'deskripsi',
        'template_slug',
    ];

    public function persyaratan()
    {
        return $this->hasMany(Persyaratan::class);
    }

    public function permohonan()
    {
        return $this->hasMany(Permohonan::class);
    }
}