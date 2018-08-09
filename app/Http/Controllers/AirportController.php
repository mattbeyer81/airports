<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Airport;
use Exception;
use Log;

use Illuminate\Http\JsonResponse;

class AirportController extends Controller
{

    /**
     * Create a new airport.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
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
     * @return JsonResponse
     */
    public function delete(Request $request, $airportId) : JsonResponse
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
     * @return JsonResponse
     */

    public function getList(Request $request) : JsonResponse
    {
        try {
            $airports = Airport::get();
            return response()->json([
                'status' => 'success',
                'results' => $airports,
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Update airport.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */

    public function update(Request $request) : JsonResponse
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
