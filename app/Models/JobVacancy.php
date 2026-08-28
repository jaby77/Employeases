<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class JobVacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_category_id',
        'title',
        'slug',
        'description',
        'requirements',
        'benefits',
        'salary_min',
        'salary_max',
        'employment_type',
        'location',
        'company',
        'slots_available',
        'application_deadline',
        'is_active',
        'is_open',
    ];

    protected function casts(): array
    {
        return [
            'salary_min' => 'decimal:2',
            'salary_max' => 'decimal:2',
            'slots_available' => 'integer',
            'application_deadline' => 'date',
            'is_active' => 'boolean',
            'is_open' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (JobVacancy $vacancy) {
            if (empty($vacancy->slug)) {
                $vacancy->slug = Str::slug($vacancy->title) . '-' . uniqid();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_jobs')->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOpen($query)
    {
        return $query->where('is_open', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)->where('is_open', true);
    }

    public function scopeByEmploymentType($query, string $type)
    {
        return $query->where('employment_type', $type);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('job_category_id', $categoryId);
    }

    public function scopeByLocation($query, string $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    public function scopeBySalaryRange($query, $min, $max = null)
    {
        $query->where(function ($q) use ($min, $max) {
            $q->where('salary_max', '>=', $min);
            if ($max) {
                $q->where('salary_min', '<=', $max);
            }
        });
        return $query;
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('location', 'like', "%{$term}%")
              ->orWhere('company', 'like', "%{$term}%");
        });
    }

    public function getSalaryFormattedAttribute(): string
    {
        if (!$this->salary_min && !$this->salary_max) {
            return 'Negotiable';
        }
        $min = $this->salary_min ? '₱' . number_format($this->salary_min, 2) : '';
        $max = $this->salary_max ? '₱' . number_format($this->salary_max, 2) : '';
        return $min . ($min && $max ? ' - ' : '') . $max;
    }

    public function getEmploymentTypeLabelAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->employment_type));
    }

    public function getApplicantsCountAttribute(): int
    {
        return $this->applications()->count();
    }

    public function isDeadlinePassed(): bool
    {
        return $this->application_deadline && $this->application_deadline->isPast();
    }
}
