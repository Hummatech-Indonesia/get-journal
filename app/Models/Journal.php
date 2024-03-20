<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'profile_id',
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
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * Get the lesson that owns the journal.
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the attendances for the journal.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the attendances for the journal.
     */
    public function sick()
    {
        return $this->hasMany(Attendance::class)->where('status', 'sick');
    }

    /**
     * Get the attendances for the journal.
     */
    public function permit()
    {
        return $this->hasMany(Attendance::class)->where('status', 'permit');
    }

    /**
     * Get the attendances for the journal.
     */
    public function alpha()
    {
        return $this->hasMany(Attendance::class)->where('status', 'alpha');
    }
}
