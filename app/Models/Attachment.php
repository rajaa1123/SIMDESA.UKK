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
        'file_content',
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

    // Accessor for download URL
    public function getFileUrlAttribute()
    {
        return route('file.download', $this->id);
    }

    public function getStreamUrlAttribute()
    {
        return route('file.stream', $this->id);
    }

    // Accessor for formatted file size
    public function getFileSizeFormattedAttribute()
    {
        if (!$this->size) {
            return 'Unknown';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $this->size > 0 ? floor(log($this->size, 1024)) : 0;
        
        return number_format($this->size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    // Check if file is an image
    public function isImage()
    {
        return in_array($this->mime, ['image/jpeg', 'image/jpg', 'image/png']);
    }

    // Check if file is a PDF
    public function isPdf()
    {
        return $this->mime === 'application/pdf';
    }
}