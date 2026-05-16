<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChallengeFile extends Model
{
    protected $fillable = [
        'challenge_id',
        'original_name',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'uploaded_at',
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}