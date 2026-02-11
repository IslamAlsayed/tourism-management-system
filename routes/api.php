<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\DashboardController;

/*
|--------------------|
|---- API Routes ----|
|--------------------|
*/

Route::middleware(['api'])->group(function () {
    Route::get('/image/download', [DashboardController::class, 'download'])->name('image.download');

    // Route::patch('patch/toggleStatus', [DashboardController::class, 'toggleStatus'])->name('patch.toggleStatus');
    Route::patch('/toggle-field', [DashboardController::class, 'toggleField'])->name('patch.toggleField');

    // Update user status to offline (called when browser/tab closes)
    Route::post('/user-status/offline', [DashboardController::class, 'userOfflineStatus'])->name('user.status.offline');
    Route::post('/translate-record-event', [DashboardController::class, 'translateRecordEvent'])->name('api.translate-record-event');
    Route::post('/web-push-notifications', [DashboardController::class, 'webPushNotifications'])->name('web-push-notifications');

    // Location APIs for accommodations
    Route::get('/countries/{countryId}/cities', [LocationController::class, 'getCitiesByCountry']);
    Route::get('/regions/{regionId}/subregions', [LocationController::class, 'getSubregionsByRegion']);

    Route::post('/ai/correct-text', [AiController::class, 'correctByGpt']);

    Route::get('routes/cities', [RouteController::class, 'getCities'])->name('routes.cities');
    Route::get('routes/cities/{id}', [RouteController::class, 'getCityById'])->name('routes.city.show');

    Route::get('routes/nationalities', [RouteController::class, 'getNationalities'])->name('routes.nationalities');
    Route::get('routes/nationalities/{id}', [RouteController::class, 'getNationalityById'])->name('routes.nationality.show');
});

Route::middleware(['api'])->group(function () {
    // Auth
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');

    // Regions
    Route::get('/regions', [RegionController::class, 'index']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/regions', [RegionController::class, 'store']);
        Route::put('/regions/{region}', [RegionController::class, 'update']);
        Route::delete('/regions/{region}', [RegionController::class, 'destroy']);
    });
});
