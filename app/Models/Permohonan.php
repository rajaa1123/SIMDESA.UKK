<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Permohonan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'permohonan';
    
    protected $fillable = [
        'layanan_id',
        'user_id',
        'tanggal_pengajuan',
        'status_id',
        'keterangan',
        'nomor_resi',
        'tanggal_selesai',
        'processor_user_id',
        'biaya_admin',
    ];

        protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $dates = ['tanggal_pengajuan', 'tanggal_selesai', 'deleted_at'];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processor_user_id');
    }

    public function history()
    {
        return $this->hasMany(PermohonanHistory::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}