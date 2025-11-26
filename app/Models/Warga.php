<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warga extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'warga';
    
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'jenis_pekerjaan',
        'alamat',
        'status_hidup',
        'status_domisili',
        'status_perkawinan',
        'no_hp',
        'kartu_keluarga_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    protected $dates = ['tanggal_lahir', 'deleted_at'];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kartu_keluarga_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'warga_id');
    }
}