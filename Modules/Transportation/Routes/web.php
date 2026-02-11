<?php

use Illuminate\Support\Facades\Route;
use Modules\Transportation\Http\Controllers\CompanyController;
use Modules\Transportation\Http\Controllers\JeepController;
use Modules\Transportation\Http\Controllers\PricingController;
use Modules\Transportation\Http\Controllers\RouteAssignmentController;
use Modules\Transportation\Http\Controllers\RouteController;
use Modules\Transportation\Http\Controllers\VehicleTypeController;

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

Route::prefix('dashboard/transportation')->name('dashboard.transportation.')->middleware('auth')->group(function () {
    // === COMPANIES MANAGEMENT ===
    Route::resource('companies', CompanyController::class)->names('companies');

    // === VEHICLE TYPES MANAGEMENT ===
    Route::resource('vehicle-types', VehicleTypeController::class)->names('vehicle-types');

    // === JEEPS MANAGEMENT ===
    Route::resource('jeeps', JeepController::class)->names('jeeps');

    // === ROUTES MANAGEMENT ===
    Route::resource('routes', RouteController::class)->names('routes');

    // === ROUTES ASSIGNMENTS MANAGEMENT ===
    Route::resource('route-assignments', RouteAssignmentController::class)->names('route-assignments');

    // === PRICINGS MANAGEMENT ===
    Route::resource('pricings', PricingController::class)->names('pricings');
});
