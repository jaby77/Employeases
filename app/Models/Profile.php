<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'birth_date',
        'gender',
        'education',
        'skills',
        'work_experience',
        'resume_path',
        'profile_photo_path',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSkillsArrayAttribute(): array
    {
        return $this->skills ? array_map('trim', explode(',', $this->skills)) : [];
    }
}
