<?php

use Illuminate\Support\Facades\Route;
use Modules\Restaurants\Http\Controllers\RestaurantController;

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

Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    // === RESTAURANT MANAGEMENT ===
    Route::resource('restaurants', RestaurantController::class);
});
