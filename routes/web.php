<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Auth::routes(['verify' => true]);

Route::get('/', 'AppController@index')->middleware('verified');


// Create Tracking Period

Route::post('/create', 'TrackingPeriodController@store');

Route::get('/checkActivePeriod', 'TrackingPeriodController@checkActivePeriod');
