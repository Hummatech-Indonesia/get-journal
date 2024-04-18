<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    // public $incrementing = false;
    // protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'profile_id',
        'title',
        'content',
        'reminder_at'
    ];
}
