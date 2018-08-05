<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'airport_id'];


    public function openingHours()
    {
        return $this->hasMany(OpeningHour::class);
    }

}
