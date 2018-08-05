<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Airport;


class AirportController extends Controller
{

    /**
     * Create a new airport.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Airport
     */
    public function create(Request $request)
    {
        Airport::create([
            'name' => $request->get('name'),
            'code' => $request->get('code')
        ]);
    }
}
