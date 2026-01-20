<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keuangan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'keuangan';

    protected $fillable = [
        'tanggal',
        'tipe',
        'kategori',
        'jumlah',
        'keterangan',
        'permohonan_id',
        'user_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    // Static categories helper
    public static function getKategoriMasuk()
    {
        return [
            'Dana Desa (DD)',
            'Alokasi Dana Desa (ADD)',
            'Pendapatan Asli Desa (PADes)',
            'Bantuan Provinsi',
            'Bantuan Kabupaten',
            'Layanan (Otomatis)',
            'Lain-lain (Pemasukan)',
        ];
    }

    public static function getKategoriKeluar()
    {
        return [
            'Pembangunan',
            'Gaji Staf/Perangkat',
            'Operasional Kantor',
            'Pemberdayaan Masyarakat',
            'Lain-lain (Pengeluaran)',
        ];
    }
}
