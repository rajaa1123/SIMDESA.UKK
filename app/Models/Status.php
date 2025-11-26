<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';
    
    protected $fillable = [
        'group_key',
        'code',
        'name',
    ];

    public function permohonan()
    {
        return $this->hasMany(Permohonan::class, 'status_id');
    }

    public function permohonanHistoryFrom()
    {
        return $this->hasMany(PermohonanHistory::class, 'from_status_id');
    }

    public function permohonanHistoryTo()
    {
        return $this->hasMany(PermohonanHistory::class, 'to_status_id');
    }
}