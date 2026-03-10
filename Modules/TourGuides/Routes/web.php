<?php

use Illuminate\Support\Facades\Route;
use Modules\TourGuides\Http\Controllers\GuideController;
use Modules\TourGuides\Http\Controllers\GuideTypeController;
use Modules\TourGuides\Http\Controllers\GuideReviewController;
use Modules\TourGuides\Http\Controllers\SeasonController;
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

Route::prefix('dashboard/tourguides')->name('dashboard.tourguides.')->middleware('auth')->group(function () {
    // === TOUR GUIDE MANAGEMENT ===
    Route::resource('guides', GuideController::class)->names('guides');

    // === TOUR GUIDE TYPE MANAGEMENT ===
    Route::resource('guides-types', GuideTypeController::class)->names('guides-types');

    // === TOUR GUIDE LANGUAGE MANAGEMENT ===
    // Route::resource('guides-languages', TourGuideLanguageController::class)->names('guides-languages');

    // === TOUR GUIDE REVIEW MANAGEMENT ===
    Route::resource('guides-reviews', GuideReviewController::class)->names('guides-reviews');

    // === SEASONS MANAGEMENT ===
    Route::resource('seasons', SeasonController::class)->names('seasons');
});
