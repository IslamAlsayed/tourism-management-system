<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AiController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\DashboardController;

/*
|--------------------|
|---- API Routes ----|
|--------------------|
*/

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/get-references-test', [DashboardController::class, 'getReferencesForTest'])->name('api.get-references-test');
    Route::post('/get-references', [DashboardController::class, 'getReferences'])->name('api.get-references');

    // Update user status to offline (called when browser/tab closes)
    Route::post('/user-status/offline', [DashboardController::class, 'userOfflineStatus'])->name('user.status.offline');
    Route::post('/translate-record-event', [DashboardController::class, 'translateRecordEvent'])->name('api.translate-record-event');
    Route::post('/web-push-notifications', [DashboardController::class, 'webPushNotifications'])->name('web-push-notifications');

    // Location APIs for accommodations
    Route::get('/countries/{countryId}/cities', [\App\Http\Controllers\Api\LocationController::class, 'getCitiesByCountry']);
    Route::get('/regions/{regionId}/subregions', [\App\Http\Controllers\Api\LocationController::class, 'getSubregionsByRegion']);

    Route::post('/ai/correct-text', [AiController::class, 'correctByGpt']);

    Route::get('routes/cities', [RouteController::class, 'getCities'])->name('routes.cities');
});