<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    protected $fillable = [
        'challenge_id',
        'flag_text',
        'is_case_sensitive',
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}