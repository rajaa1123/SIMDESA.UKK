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
        'admin_user_id',
        'admin_approval_date',
        'admin_note',
        'kades_user_id',
        'kades_approval_date',
        'kades_note',
        'rejection_reason',
        'rejected_by',
        'hasil_surat_file',
        'hasil_surat_filename',
        'hasil_surat_uploaded_at',
        'hasil_surat_uploaded_by',
        // Digital signature fields
        'kades_digital_signature',
        'kades_signature_qr_path',
        'kades_signature_timestamp',
        // Custom surat data fields (filled by warga in form)
        'surat_nama',
        'surat_nik',
        'surat_tempat_lahir',
        'surat_tanggal_lahir',
        'surat_jenis_kelamin',
        'surat_agama',
        'surat_pekerjaan',
        'surat_alamat',
        'surat_rt',
        'surat_rw',
        // Dynamic form data (JSON)
        'form_data',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'admin_approval_date' => 'datetime',
        'kades_approval_date' => 'datetime',
        'hasil_surat_uploaded_at' => 'datetime',
        'kades_signature_timestamp' => 'datetime',
        'surat_tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'form_data' => 'array', // Auto JSON decode/encode
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

    public function adminUser()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    public function kadesUser()
    {
        return $this->belongsTo(User::class, 'kades_user_id');
    }

    public function hasilSuratUploadedBy()
    {
        return $this->belongsTo(User::class, 'hasil_surat_uploaded_by');
    }

    // Helper methods untuk check status
    public function isPending()
    {
        return $this->status && $this->status->code === 'pending';
    }

    public function isMenungguPersetujuanKades()
    {
        return $this->status && $this->status->code === 'menunggu_persetujuan_kades';
    }

    public function isSelesai()
    {
        return $this->status && $this->status->code === 'selesai';
    }

    public function isDitolak()
    {
        return $this->status && $this->status->code === 'ditolak';
    }

    // Helper methods untuk file upload authorization
    public function canUploadFiles()
    {
        // Warga can upload files only if status is pending or waiting for kepala desa
        return $this->isPending() || $this->isMenungguPersetujuanKades();
    }

    public function isFilesLocked()
    {
        // Files are locked when permohonan is finished or rejected
        return $this->isSelesai() || $this->isDitolak();
    }

    public function getRequiredPersyaratan()
    {
        // Get all required (wajib) persyaratan for this layanan
        return $this->layanan->persyaratan()->where('wajib', true)->get();
    }

    public function getOptionalPersyaratan()
    {
        // Get all optional persyaratan for this layanan
        return $this->layanan->persyaratan()->where('wajib', false)->get();
    }

    public function hasAllRequiredAttachments()
    {
        $requiredPersyaratan = $this->getRequiredPersyaratan();
        
        foreach ($requiredPersyaratan as $syarat) {
            $hasAttachment = $this->attachments()
                ->where('dokumen_id', $syarat->dokumen_id)
                ->exists();
            
            if (!$hasAttachment) {
                return false;
            }
        }
        
        return true;
    }

    // Helper methods untuk hasil surat
    public function hasHasilSurat()
    {
        return !empty($this->hasil_surat_file);
    }

    public function canUploadHasilSurat()
    {
        // Admin/Kades can upload hasil surat when permohonan is verified (menunggu_persetujuan_kades) or selesai
        return $this->isMenungguPersetujuanKades() || $this->isSelesai();
    }

    // Digital signature helper methods
    public function hasDigitalSignature()
    {
        return !empty($this->kades_digital_signature);
    }

    public function getSignatureQrUrl()
    {
        return $this->kades_signature_qr_path 
            ? asset('storage/' . $this->kades_signature_qr_path)
            : null;
    }

    /**
     * STRICT GUARD: Check if status transition is valid
     * Enforces one-way status flow
     */
    public function canTransitionTo($newStatusCode)
    {
        $currentCode = $this->status->code ?? null;

        // Define allowed transitions (strict rules)
        $allowedTransitions = [
            'pending' => ['menunggu_persetujuan_kades', 'ditolak'],
            'menunggu_persetujuan_kades' => ['selesai', 'ditolak'],
            'selesai' => [], // Terminal state - no transitions allowed
            'ditolak' => [], // Terminal state - no transitions allowed
        ];

        return in_array($newStatusCode, $allowedTransitions[$currentCode] ?? []);
    }

    /**
     * Check if current user can access this permohonan for approval
     * Used by Kepala Desa approval system
     */
    public function canBeAccessedByKades()
    {
        return $this->isMenungguPersetujuanKades();
    }
}