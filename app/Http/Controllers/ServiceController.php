<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
    Service,
    Airport
};
use Exception;

class ServiceController extends Controller
{
    /**
     * Create a new airport service.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Airport
     */
    public function create(Request $request)
    {
        $airport = Airport::where('code', $request->get('airport_code'))->first();
        if (!$airport) {
            throw Exception('No airport with airport_code does not exists');
        }

        $service = $airport->services()->firstOrCreate([
            'name' => $request->get('name')
        ]);

        return $service;

    }
}
