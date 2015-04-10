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

Route::get('/',['as' => 'home','uses' => 'WelcomeController@index']);

/** MHealth ROUTE */
Route::get('/mhealth','\App\Http\Controllers\MhealthController@index');

/** PACKAGE USAGE ROUTE */
Route::get('/packageusage','\App\Http\Controllers\PackageUsageController@index');