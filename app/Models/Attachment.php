<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachment';
    
    protected $fillable = [
        'attachable_type',
        'attachable_id',
        'dokumen_id',
        'uploaded_by',
        'file_path',
        'nama_file',
        'mime',
        'size',
        'status_id',
    ];

    public function attachable()
    {
        return $this->morphTo();
    }

    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}