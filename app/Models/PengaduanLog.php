<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaduanLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'status_sebelumnya',
        'status_sesudahnya',
        'pesan'
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
