<?php

use Illuminate\Support\Facades\Route;
use Modules\Accommodations\Http\Controllers\AccommodationController;
use Modules\Accommodations\Http\Controllers\MealController;
use Modules\Accommodations\Http\Controllers\RoomController;
use Modules\Accommodations\Http\Controllers\SeasonController;
use Modules\Accommodations\Http\Controllers\SupplementController;
use Modules\Accommodations\Http\Controllers\TypeController;
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
    // === TYPES MANAGEMENT ===
    Route::resource('accommodations/types', TypeController::class)->names('accommodations.types');

    // === ROOMS MANAGEMENT ===
    Route::resource('accommodations/rooms', RoomController::class)->names('accommodations.rooms');

    // === SEASONS MANAGEMENT ===
    Route::resource('accommodations/seasons', SeasonController::class)->names('accommodations.seasons');

    // === MEALS MANAGEMENT ===
    Route::resource('accommodations/meals', MealController::class)->names('accommodations.meals');

    // === SUPPLEMENTS MANAGEMENT ===
    Route::resource('accommodations/supplements', SupplementController::class)->names('accommodations.supplements');

    // === SUPPLEMENTS MANAGEMENT ===
    Route::resource('shared-space/rooms', RoomController::class)->names('shared-space.rooms');

    // === ACCOMMODATIONS MANAGEMENT ===
    Route::resource('accommodations', AccommodationController::class)->names('accommodations');
});
