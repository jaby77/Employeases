<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interview extends Model
{
    protected $fillable = [
        'application_id',
        'user_id',
        'scheduled_at',
        'location',
        'type',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'scheduled' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            'rescheduled' => 'warning',
            default => 'secondary',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->type));
    }
}
