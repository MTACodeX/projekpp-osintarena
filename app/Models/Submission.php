<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'user_id',
        'team_id',
        'challenge_id',
        'submitted_flag',
        'is_correct',
        'ip_address',
        'submitted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}