<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $fillable = ['name', 'code'];

    /**
     * Get the comments for the airport.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

}
