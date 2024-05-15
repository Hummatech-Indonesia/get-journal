<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'classroom_student_id',
        'score',
    ];

    /**
     * Get the assignment that owns the mark.
     */
    public function classroomStudent(): BelongsTo
    {
        return $this->belongsTo(ClassroomStudent::class, 'classroom_student_id');
    }
}
