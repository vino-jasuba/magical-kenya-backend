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

Route::apiResource('activities', 'ActivityController');
Route::apiResource('locations', 'LocationController');
Route::apiResource('experiences', 'TouristExperienceController');
Route::apiResource('media', 'MediaController')->only(['store', 'update', 'destroy']);
Route::get('tags', 'TagController');
Route::get('search', 'SearchController');
