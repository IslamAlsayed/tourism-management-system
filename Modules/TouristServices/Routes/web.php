<?php

use Illuminate\Support\Facades\Route;
use Modules\TouristServices\Http\Controllers\ServiceController;

Route::prefix('dashboard/touristservices')->name('dashboard.touristservices.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('services', ServiceController::class)->names('services');
});
