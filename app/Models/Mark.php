<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'classroom_student_id',
        'score',
    ];
}
