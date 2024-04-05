<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Profile extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'identity_number',
        'name',
        'birthdate',
        'address',
        'gender',
        'photo',
        'is_register',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class, 'profile_id');
    }

    /**
     * Get the lessons for the profile.
     */
    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(Lesson::class, Classroom::class, 'profile_id', 'classroom_id', 'id', 'id');
    }
}
