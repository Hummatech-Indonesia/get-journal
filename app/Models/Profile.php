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
    protected $fillable = [
        'user_id',
        'identity_number',
        'name',
        'birthdate',
        'address',
        'gender',
        'photo',
        'is_register',
        'is_premium',
        'premium_expired_at',
        'is_premium_private',
        'is_premium_school',
        'quantity_premium',
        'used_quantity_premium',
        'user_premium_private_id',
        'user_premium_school_id'        
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
