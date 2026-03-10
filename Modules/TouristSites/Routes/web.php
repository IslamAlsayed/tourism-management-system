<?php

use Illuminate\Support\Facades\Route;
use Modules\TouristSites\Http\Controllers\SiteController;
use Modules\TouristSites\Http\Controllers\FacilityController;

Route::prefix('dashboard/touristsites')->name('dashboard.touristsites.')->middleware('auth')->group(function () {
    Route::resource('sites', SiteController::class)->names('sites');
    Route::resource('facilities', FacilityController::class)->names('facilities');
});
