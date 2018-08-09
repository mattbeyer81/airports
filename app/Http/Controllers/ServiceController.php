<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
    Service,
    Airport
};
use Exception;
use Carbon\Carbon;
use Log;
use GuzzleHttp\Client as GuzzleClient;

class ServiceController extends Controller
{
    /**
     * Create a new airport service.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function create(Request $request)
    {

        try {
            $airport = Airport::where('code', $request->get('airport_code'))->first();
            if (!$airport) {
                throw new Exception('Airport with code provided does not exists');
            }

            if ($request->get('company_number')) {
                $companyHouseDetails = $this->getCompanyHouseDetailsByCompanyNumber($request->get('company_number'));
            }

            $service = $airport->services()->firstOrCreate([
                'name' => $request->get('name'),
                'data' => $companyHouseDetails
            ]);

            for ($i = 0; $i < 7; $i++) {
                $service->openingHours()->where('day_of_week', $i)->firstOrCreate(['day_of_week' => $i]);
            }

            return response()->json([
                'status' => 'success',
                'service' => $service
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 'error'
            ], 500);
        }


    }

    /**
     * Get company data from Companies House using company number.
     *
     * @param  string   $companyNumber
     * @return array
     */

    private function getCompanyHouseDetailsByCompanyNumber($companyNumber)
    {
        try {
            $guzzle = new GuzzleClient;
            $response = $guzzle->request('GET', "https://api.companieshouse.gov.uk/company/{$companyNumber}", [
                'auth' => [
                    '2xLi0Ep2OKQDTecZlXium-RUONljnnBwzgSYfsEd',
                    ''
                ]
            ]);
            $responseJson = json_decode($response->getBody()->getContents());

            return [
                'company_name' => $responseJson->company_name,
                'company_number' => $companyNumber
            ];
        } catch (Exception $s){
            return [];
        }
    }

    /**
     * Update a new airport service.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */

    public function update(Request $request)
    {
        try {
            $airport = Airport::where('code', $request->get('airport_code'))->first();
            if (!$airport) {
                throw new Exception('No airport with airport_code does not exists');
            }

            $service = $airport->services()->firstOrCreate([
                'name' => $request->get('name')
            ]);

            $openingHour = $service->openingHours()->where('day_of_week', 'Tuesday')->firstOrCreate([
                'day_of_week' => 'Monday'
            ]);

            if ($request->get('company_number')) {
                $companyHouseDetails = $this->getCompanyHouseDetailsByCompanyNumber($request->get('company_number'));
            }

            return response()->json([
                'status' => 'success',
                'service' => $service
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Get time string for DB query from ISO Date string.
     *
     * @param  string   $str
     * @return string
     */
    private function getFromTimeStr($str)
    {
        $datetime = Carbon::createFromFormat('Y-m-d\TH:i:s+', $str);
        return $datetime->format('H:m:i');
    }

    /**
     * Get airport services.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function getServices(Request $request)
    {
        try {
            $services = Service::with(['openingHours', 'airport'])->get();
            return response()->json([
                'status' => 'success',
                'results' => $services
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 'error'
            ], 500);
        }

    }

    /**
     * Search airport services.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function search(Request $request)
    {
        try {
            $from = $request->get('from');
            $to = $request->get('to');
            $dayOfWeek = $request->get('day_of_week');
            $serviceQ = Service::query()
                ->with('airport')
                ->with('openingHours');

            $fromTimeStr = $this->getFromTimeStr($from);
            $toTimeStr = $this->getFromTimeStr($to);
            $airport = Airport::find($request->get('airport_id'));

            $serviceQ  = $airport->services()
                ->with('airport')
                ->with('openingHours');

            $serviceQ->whereHas('openingHours', function($q) use ($fromTimeStr, $toTimeStr, $dayOfWeek) {
                    $q->where('day_of_week', 0);
                    $q->whereNotNull('opening_time');
                    $q->whereNotNull('closing_time');
                    $q->where(function($q) use ($fromTimeStr, $toTimeStr) {
                        $q->where(function($q) use ($fromTimeStr, $toTimeStr) {#

                            // Does service open after start time?
                            // Does service open before end time?

                            $q->where('opening_time', '>', $fromTimeStr);
                            $q->where('opening_time', '<', $toTimeStr);
                        });
                        $q->orWhere(function($q) use ($fromTimeStr, $toTimeStr) {

                            // Does services close after start time?
                            // Does service close before the end time?

                            $q->where('closing_time', '>', $fromTimeStr);
                            $q->where('closing_time', '<', $toTimeStr);
                        });
                        $q->orWhere(function($q) use ($fromTimeStr, $toTimeStr) {

                            // Does the service open before the start time?
                            // Does the service close after the end time?

                            $q->where('opening_time', '<', $fromTimeStr);
                            $q->where('closing_time', '>', $toTimeStr);
                        });
                        $q->orWhere(function($q) use ($fromTimeStr, $toTimeStr) {

                            // Does the services open after the start time?
                            // Does the sevice close after the end time?

                            $q->where('opening_time', '>', $fromTimeStr);
                            $q->where('closing_time', '<', $toTimeStr);
                        });
                    });
            });

            $services = $serviceQ->get();

            return response()->json([
                'status' => 'success',
                'results' => $services
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 'error'
            ], 500);
        }

    }
}
