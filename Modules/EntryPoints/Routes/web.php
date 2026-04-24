<?php

use Illuminate\Support\Facades\Route;
use Modules\EntryPoints\Http\Controllers\AirportController;
use Modules\EntryPoints\Http\Controllers\EntryPointsController;
use Modules\EntryPoints\Http\Controllers\LandcrossingController;
use Modules\EntryPoints\Http\Controllers\SeaportController;

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

Route::prefix('dashboard/entrypoints')->name('dashboard.entrypoints.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('filtered/{filtered?}', [EntryPointsController::class, 'index'])->name('filtered');
    Route::resource('land-crossings', LandcrossingController::class)->names('land-crossings');
    Route::resource('seaports', SeaportController::class)->names('seaports');
    Route::resource('airports', AirportController::class)->names('airports');
});
