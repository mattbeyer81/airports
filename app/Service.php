<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'airport_id', 'data'];

    protected $casts = [
        'data' => 'array'
    ];

    public function openingHours()
    {
        return $this->hasMany(OpeningHour::class);
    }

    public function airport()
    {
        return $this->belongsTo(Airport::class);
    }

}
