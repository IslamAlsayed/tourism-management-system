<?php

use Illuminate\Support\Facades\Route;
use Modules\Restaurants\Http\Controllers\RestaurantController;
use Modules\Restaurants\Http\Controllers\RestaurantMealController;
use Modules\Restaurants\Http\Controllers\RestaurantTypeController;
use Modules\Restaurants\Http\Controllers\RestaurantSupplementController;
use Modules\Restaurants\Http\Controllers\SeasonController;

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

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', 'admin'])->group(function () {
    // === RESTAURANT TYPES === (must be before restaurants resource)
    Route::resource('restaurants/types', RestaurantTypeController::class)->names('restaurants.types');

    // === RESTAURANT MEALS ===
    Route::resource('restaurants/meals', RestaurantMealController::class)->names('restaurants.meals');

    // === RESTAURANT SUPPLEMENTS ===
    Route::resource('restaurants/supplements', RestaurantSupplementController::class)->names('restaurants.supplements');

    // === RESTAURANT SEASONS ===
    Route::resource('restaurants/seasons', SeasonController::class)->names('restaurants.seasons');

    // === RESTAURANT MANAGEMENT ===
    Route::resource('restaurants', RestaurantController::class);
});
