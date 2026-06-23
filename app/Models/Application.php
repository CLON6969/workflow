<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'amount',
        'date',
        'attachment',
        'status',
        'current_reviewer_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
        'status' => ApplicationStatus::class,           // ← Important Enum Casting
        'current_reviewer_id' => 'integer',
    ];

    // === Relationships ===

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currentReviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'current_reviewer_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ApplicationLog::class);
    }

    // === Helper Methods ===

    public function isDraft(): bool
    {
        return $this->status === ApplicationStatus::DRAFT;
    }

    public function canBeEditedBy(User $user): bool
    {
        return $this->isDraft() && $this->user_id === $user->id;
    }

    public function belongsToUser(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    /**
     * Get status label for views
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    /**
     * Get status badge color for views
     */
    public function getStatusBadgeAttribute(): string
    {
        return $this->status->badgeColor();
    }
}