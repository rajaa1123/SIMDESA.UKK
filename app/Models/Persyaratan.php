<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    use HasFactory;

    protected $table = 'persyaratan';
    
    protected $fillable = [
        'layanan_id',
        'dokumen_id',
        'wajib',
        'catatan',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class);
    }
}