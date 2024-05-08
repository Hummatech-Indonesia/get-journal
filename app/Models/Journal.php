<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Journal extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'profile_id',
        'classroom_id',
        'lesson_id',
        'title',
        'description',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Get the profile that owns the journal.
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * Get the lesson that owns the journal.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the classroom that owns the journal.
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Get the attendances for the journal.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the attendances for the journal.
     */
    public function sick(): HasMany
    {
        return $this->hasMany(Attendance::class)->where('status', 'sick');
    }

    /**
     * Get the attendances for the journal.
     */
    public function permit(): HasMany
    {
        return $this->hasMany(Attendance::class)->where('status', 'permit');
    }

    /**
     * Get the attendances for the journal.
     */
    public function alpha(): HasMany
    {
        return $this->hasMany(Attendance::class)->where('status', 'alpha');
    }
}
