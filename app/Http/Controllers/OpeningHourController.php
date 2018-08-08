<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\OpeningHour;
use Carbon\Carbon;

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

        try {
            $openingHours = $request->all();

            foreach ($openingHours as $openingHour) {
                $openingHourObj = OpeningHour::find($openingHour['id']);
                $openingHourObj->opening_time = isset($openingHour['opening_time']) ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $openingHour['opening_time']) : null;
                $openingHourObj->closing_time = isset($openingHour['closing_time']) ? Carbon::createFromFormat('Y-m-d\TH:i:s+', $openingHour['closing_time']) : null;
                $openingHourObj->save();

            }
            return response()->json([
                'status' => 'success'
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 'error'
            ], 500);
        }

    }
}
