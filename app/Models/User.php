<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function team()
    {
        return $this->hasOne(Team::class);
    }

    public function solves()
    {
        return $this->hasMany(Solve::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}