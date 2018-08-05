<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpeningHour extends Model
{
    protected $fillable = ['day_of_week', 'opening_time', 'closing_time',
        'service_id'
    ];
}
