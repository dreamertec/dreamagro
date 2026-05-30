<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceSetting extends Model
{
    protected $fillable = [
        'mode',
        'dripper_override',
        'fogger_override',
        'motor_override',
    ];
}
