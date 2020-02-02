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

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\ExperiencesController;
use App\Http\Controllers\Admin\LocationController;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
    Route::get('activities', [ActivityController::class, 'index'])->name('admin.activities.index');
    Route::get('activities/create', [ActivityController::class, 'create'])->name('admin.activities.create');
	Route::get('activities/{activity}', [ActivityController::class, 'edit'])->name('admin.activities.edit');
	Route::get('locations', [LocationController::class, 'index'])->name('admin.locations.index');
    Route::get('locations/create', [LocationController::class, 'create'])->name('admin.locations.create');
	Route::get('locations/{location}', [LocationController::class, 'edit'])->name('admin.locations.edit');
	Route::get('experiences', [ExperiencesController::class, 'index'])->name('admin.experiences.index');
    Route::get('experiences/create', [ExperiencesController::class, 'create'])->name('admin.experiences.create');
    Route::get('experiences/{experience}', [ExperiencesController::class, 'edit'])->name('admin.experiences.edit');
});
