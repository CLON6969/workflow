<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'user_id',
        'old_status',
        'new_status',
        'comment',
    ];

    protected $casts = [
        'old_status' => 'string',
        'new_status' => 'string',
    ];

    // Relationships
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
