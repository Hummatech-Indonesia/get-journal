<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    ];

    /**
     * Get the profile that owns the classroom.
     */
    public function countStudents(): HasMany
    {
        return $this->hasMany(ClassroomStudent::class, 'student_id')->count();
    }
}
