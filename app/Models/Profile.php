<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    protected $guarded = [];

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

    /**
     * Get the reminders for the profile.
     */
    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class, 'profile_id');
    }

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the journals for the profile.
     */
    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class, 'profile_id');
    }

    /**
     * Get the attendances for the profile.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'profile_id');
    }

    /**
     * Get the attendances for the journal.
     */
    public function sick(): HasMany
    {
        return $this->attendances()->where('status', 'sick');
    }

    /**
     * Get the attendances for the journal.
     */
    public function permit(): HasMany
    {
        return $this->attendances()->where('status', 'permit');
    }

    /**
     * Get the attendances for the journal.
     */
    public function alpha(): HasMany
    {
        return $this->attendances()->where('status', 'alpha');
    }

    
    public function getSchoolRelated()
    {
        return $this->belongsTo(Profile::class, 'related_code', 'code');
    }

    public function student()
    {
        return $this->hasMany(ClassroomStudent::class,'student_id','id');
    }

    public function oneStudent()
    {
        return $this->belongsTo(ClassroomStudent::class,'id','student_id');
    }
}
