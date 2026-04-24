<?php

use Illuminate\Support\Facades\Route;
use Modules\TravelDocuments\Http\Controllers\TravelPasseController;
use Modules\TravelDocuments\Http\Controllers\VisaRequirementController;

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

Route::prefix('dashboard/traveldocuments')->name('dashboard.traveldocuments.')->middleware(['auth', 'admin'])->group(function () {
    // === VISA REQUIREMENTS MANAGEMENT ===
    Route::resource('visa-requirements', VisaRequirementController::class)->names('visa-requirements');

    // === TRAVEL PASSES MANAGEMENT ===
    Route::resource('travel-passes', TravelPasseController::class)->names('travel-passes');
});
