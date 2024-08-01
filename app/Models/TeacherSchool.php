<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSchool extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'related_code'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo(Profile::class, 'related_code','code');
    }
}
