<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/airports', 'AirportController@create');
Route::get('/airports', 'AirportController@getList');
Route::put('/airports', 'AirportController@update');
Route::delete('/airports/{airportId}', 'AirportController@delete');
Route::post('/services', 'ServiceController@create');
Route::put('/services', 'ServiceController@update');
Route::post('/services/{serviceId}/opening-hours', 'OpeningHourController@create');
Route::get('/services/search', 'ServiceController@search');
Route::get('/services', 'ServiceController@getServices');
