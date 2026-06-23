<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'user_type',
        'name',
        'username',
        'email',
        'password',
        'profile_picture',
        'account_status',
        'provider',
        'provider_id',
        'phone',
        'whatsapp',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'website',
        'two_factor_enabled',
        'email_verified',
        'bio',
        'job_title',
        'referral_source',
        'parent_account_id',
        'account_type',
        'role_id',
        'onboarding_complete',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_enabled' => 'boolean',
        'onboarding_complete' => 'boolean',
        'email_verified' => 'boolean',
    ];

    // ========================================
    // ============= RELATIONSHIPS ============
    // ========================================

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function parentAccount()
    {
        return $this->belongsTo(User::class, 'parent_account_id');
    }

    public function subAccounts()
    {
        return $this->hasMany(User::class, 'parent_account_id');
    }

    public function uploadedResources()
    {
        return $this->hasMany(Resource::class, 'uploader_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function savedResources()
    {
        return $this->belongsToMany(Resource::class, 'saved_resources')
            ->withTimestamps();
    }

    // === Assignment-Specific Relationships ===
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    // ========================================
    // ============ HELPER METHODS ============
    // ========================================

    public function isApplicant(): bool
    {
        return optional($this->role)->name === 'Applicant';
    }

    public function isReviewer(): bool
    {
        return optional($this->role)->name === 'Reviewer';
    }

    public function scopeActive($query)
    {
        return $query->where('account_status', 'active');
    }

    /**
     * Check if user has any role assigned
     */
    public function hasRole(): bool
    {
        return $this->role_id !== null;
    }
}