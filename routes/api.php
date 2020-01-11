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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/v1/traffic/summary', 'Api\v1\LogController@trafficSummary');
Route::get('/v1/traffic/client', 'Api\v1\LogController@trafficClient');
Route::get('/v1/traffic/sourcemap', 'Api\v1\LogController@traficSourcesMap');
