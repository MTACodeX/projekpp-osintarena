<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'user_id',
        'team_name',
        'team_name_type',
        'score',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function solves()
    {
        return $this->hasMany(Solve::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}