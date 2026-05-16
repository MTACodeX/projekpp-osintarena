<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'difficulty',
        'points',
        'min_points',
        'decay_per_solve',
        'external_link',
        'is_active',
    ];

    public function files()
    {
        return $this->hasMany(ChallengeFile::class);
    }

    public function flags()
    {
        return $this->hasMany(Flag::class);
    }

    public function solves()
    {
        return $this->hasMany(Solve::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function calculatePoints(int $solveCountBeforeCurrentUser): int
    {
        $maxPoints = (int) $this->points;
        $minPoints = (int) $this->min_points;
        $decay = (int) $this->decay_per_solve;

        $currentPoints = $maxPoints - ($solveCountBeforeCurrentUser * $decay);

        return max($minPoints, $currentPoints);
    }
}