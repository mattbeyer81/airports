<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\OpeningHour;

class OpeningHourController extends Controller
{
    /**
    * Create a new airport.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return Airport
    */
    public function create(Request $request, $serviceId)
    {
        $openingHours = $request->all();

        foreach ($openingHours as $openingHour) {
            $openingHourObj = OpeningHour
            ::where('service_id', $serviceId)
            ->where('day_of_week', $openingHour['day_of_week'])->first();
            if ($openingHourObj) {
                $openingHourObj->opening_time = $openingHour['opening_time'];
                $openingHourObj->closing_time = $openingHour['closing_time'];
                $openingHourObj->save();
            } else {
                OpeningHour::create([
                    'service_id' => $serviceId,
                    'day_of_week' => $openingHour['day_of_week'],
                    'opening_time' => $openingHour['opening_time'],
                    'closing_time' => $openingHour['closing_time'],
                ]);
            }
        }
    }
}
