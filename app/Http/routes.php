<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/test', function()
{
 $response 	= 	(new App\Tigo\MiddleWare\Services\SendNotification)->send('TIGO','250722123127','SMS FOR PACKAGE');
  
  dd($response);
});

/** MHealth ROUTE */
Route::get('/mhealth','\App\Http\Controllers\MhealthController@index');

/** PACKAGE USAGE ROUTE */
Route::get('/packageusage','\App\Http\Controllers\PackageUsageController@index');

/** OPT ROUTE */
Route::get('/opt','\App\Http\Controllers\OptInOptOutController@index');
