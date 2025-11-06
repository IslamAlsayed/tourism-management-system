<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;

/*
|--------------------|
|---- API Routes ----|
|--------------------|
*/

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/get-references-test', [DashboardController::class, 'getReferencesForTest'])->name('api.get-references-test');
    Route::post('/get-references', [DashboardController::class, 'getReferences'])->name('api.get-references');
});
