<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $attributes = [
        'role_id' => 1,
    ];

    protected $table = 'users';
    
    protected $fillable = [
        'warga_id',
        'name',
        'email',
        'password',
        'phone',
        'role_id',
        'status',
        'avatar',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Check if user has specific role
     */
    public function hasRole($roleName)
    {
        return $this->role->name === $roleName;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is kepala desa
     */
    public function isKepalaDesa()
    {
        return $this->hasRole('kepala_desa');
    }

    /**
     * Check if user is warga
     */
    public function isWarga()
    {
        return $this->hasRole('warga');
    }

    /**
     * Check if user is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Activate user
     */
    public function activate()
    {
        $this->update(['status' => 'active']);
    }

    /**
     * Deactivate user
     */
    public function deactivate()
    {
        $this->update(['status' => 'inactive']);
    }

    /**
     * Suspend user
     */
    public function suspend()
    {
        $this->update(['status' => 'suspended']);
    }

    /**
     * Check if profile is complete
     */
    public function isProfileComplete()
    {
        return $this->name && $this->email && $this->phone;
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin()
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Scope to filter active users
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to filter by role
     */
    public function scopeByRole($query, $roleId)
    {
        return $query->where('role_id', $roleId);
    }

    /**
     * Get avatar URL
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        // Default avatar using UI Avatars
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random';
    }

    // Relationships

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    public function permohonan()
    {
        return $this->hasMany(Permohonan::class, 'user_id');
    }

    public function processedPermohonan()
    {
        return $this->hasMany(Permohonan::class, 'processor_user_id');
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }
}