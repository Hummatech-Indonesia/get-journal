<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Classroom extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'code',
        'profile_id',
        'limit',
        'background_id',
    ];

    /**
     * Get the profile that owns the classroom.
     */
    public function students(): mixed
    {
        return $this->hasMany(ClassroomStudent::class, 'classroom_id');
    }

    /**
     * Get the profile that owns the classroom.
     */
    public function background(): BelongsTo
    {
        return $this->belongsTo(Background::class, 'background_id');
    }

    /**
     * Get the profile that owns the classroom.
     */
    public function assignments(): HasManyThrough
    {
        return $this->hasManyThrough(Assignment::class, Lesson::class, 'classroom_id', 'lesson_id');
    }

    /**
     * Get the profile that owns the classroom.
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

}
