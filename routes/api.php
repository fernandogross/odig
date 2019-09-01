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

// API root message
Route::post('/', function() {
	return response()->json(['message' => 'ODIG Test API', 'status' => 'Connected']);
});

// Sort appointments
Route::post('/appointments/sort/', 'AppointmentController@sort');

// Resource for appointments CRUD
Route::resource('appointments', 'AppointmentController');