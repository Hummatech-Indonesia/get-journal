<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotaPremium extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'quota_premiums';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
