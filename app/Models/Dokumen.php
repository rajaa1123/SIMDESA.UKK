<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumen';

    protected $fillable = [
        'nama_dokumen',
        'deskripsi',
    ];

    public function persyaratan()
    {
        return $this->hasMany(Persyaratan::class);
    }

    // ✅ ACCESSOR UNTUK COUNT PERSYARATAN
    public function getPersyaratanCountAttribute()
    {
        return $this->persyaratan()->count();
    }

    // ✅ RELATIONSHIP UNTUK ATTACHMENTS
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}