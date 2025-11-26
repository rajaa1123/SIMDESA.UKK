<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanHistory extends Model
{
    use HasFactory;

    protected $table = 'permohonan_history';
    
    protected $fillable = [
        'permohonan_id',
        'from_status_id',
        'to_status_id',
        'changed_by',
        'note',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function fromStatus()
    {
        return $this->belongsTo(Status::class, 'from_status_id');
    }

    public function toStatus()
    {
        return $this->belongsTo(Status::class, 'to_status_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}