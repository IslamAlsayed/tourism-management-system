<?php

use Illuminate\Support\Facades\Route;
use Modules\Geography\Http\Controllers\CityController;
use Modules\Geography\Http\Controllers\CountryController;
use Modules\Geography\Http\Controllers\NationalityController;
use Modules\Geography\Http\Controllers\RegionController;
use Modules\Geography\Http\Controllers\StateController;
use Modules\Geography\Http\Controllers\SubregionController;

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

Route::prefix('dashboard/geography')->name('dashboard.geography.')->middleware('auth')->group(function () {
    // === REGIONS MANAGEMENT ===
    Route::resource('regions', RegionController::class)->names('regions');

    // === SUBREGIONS MANAGEMENT ===
    Route::resource('subregions', SubregionController::class)->names('subregions');

    // === COUNTRIES MANAGEMENT ===
    Route::resource('countries', CountryController::class)->names('countries');

    // === STATES MANAGEMENT ===
    Route::resource('states', StateController::class)->names('states');

    // === CITIES MANAGEMENT ===
    Route::resource('cities', CityController::class)->names('cities');

    // === NATIONALITIES MANAGEMENT ===
    Route::resource('nationalities', NationalityController::class)->names('nationalities');
});
