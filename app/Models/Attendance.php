<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'journal_id',
        'status',
    ];

    /**
     * Get the profile that owns the attendance.
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
