<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Airport;
use Exception;
use Log;

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
        try {
            Airport::create([
                'name' => $request->get('name'),
                'code' => $request->get('code')
            ]);
            return response()->json([
                'status' => 'success'
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 'error'
            ], 500);
        }

    }

    /**
     * Delete a new airport.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Airport
     */
    public function delete(Request $request, $airportId)
    {
        try {
            Airport::find($airportId)->delete();
            return response()->json([
                'status' => 'success'
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 'error'
            ], 500);
        }

    }

    /**
     * Get list of all airports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function getList(Request $request)
    {
        $airports = Airport::get();
        return $airports;
    }

    /**
     * Update airport.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */

    public function update(Request $request)
    {
        try {
            $data = $request->all();
            Airport::where('id', $request->get('id'))->update($request->all());
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
