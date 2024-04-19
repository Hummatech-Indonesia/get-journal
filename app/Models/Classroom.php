<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
