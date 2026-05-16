<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'website_name',
        'event_name',
        'event_description',
        'start_time',
        'end_time',
        'registration_open',
        'scoreboard_visible',
        'maintenance_mode',
    ];
}