<?php

namespace App\Models;

use App\Enums\CourseModality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'academy_id',
        'name',
        'description',
        'cost',
        'duration',
        'modality',
        'active',
        'capacity',
        'start_date',
        'end_date'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'cost' => 'decimal:2',
            'active' => 'boolean',
            'duration' => 'integer',
            'capacity' => 'integer',
            'modality' => CourseModality::class,
        ];
    }

    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class);
    }
}
