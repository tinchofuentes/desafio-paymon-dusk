<?php

namespace App\Models;

use App\Enums\CommunicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'course_id',
        'age_from',
        'age_to',
        'send_date',
        'status'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'send_date' => 'date',
            'age_from' => 'integer',
            'age_to' => 'integer',
            'status' => CommunicationStatus::class,
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function guardians(): BelongsToMany
    {
        return $this->belongsToMany(Guardian::class, 'communication_guardian')
            ->withPivot('read_at')
            ->withTimestamps();
    }
}
