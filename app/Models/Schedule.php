<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'type',
        'time',
        'duration',
        'is_active',
        'days_of_week',
    ];

    protected $casts = [
        'days_of_week' => 'array',
        'is_active' => 'boolean',
    ];
}
