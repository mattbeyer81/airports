<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
    Service,
    Airport
};
use Exception;
use Carbon\Carbon;

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

        $openingHour = $service->openingHours()->where('day_of_week', 1)->first();
        dd($openingHour);

        return $service;

    }

    public function search(Request $request)
    {
        $from = $request->get('from');
        $services = Service::whereHas('openingHours', function($q) use ($from) {

            $datetime = Carbon::createFromFormat('Y-m-d\TH:i:s+', $from);
            $dayOfWeek = $datetime->format('l');
            $q->where('day_of_week', $dayOfWeek);
            $time = $datetime->format('h:m:i');
            $q->where('opening_time', '<', $time);
            $q->where('closing_time', '>', $time);
        });

    }
}
