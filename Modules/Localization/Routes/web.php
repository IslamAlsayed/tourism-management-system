<?php

use Illuminate\Support\Facades\Route;
use Modules\Localization\Http\Controllers\CurrencyController;
use Modules\Localization\Http\Controllers\LanguageController;
use Modules\Localization\Http\Controllers\SystemLanguageController;
use Modules\Localization\Http\Controllers\TimezoneController;
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

Route::prefix('dashboard/localization')->name('dashboard.localization.')->middleware(['auth', 'admin'])->group(function () {
    // === LANGUAGE MANAGEMENT ===
    Route::resource('languages', LanguageController::class)->names('languages');

    // === SYSTEM LANGUAGE MANAGEMENT ===
    Route::get('languages/{locale}/locale', [SystemLanguageController::class, 'locale'])->name('system-languages.change');
    Route::resource('system-languages', SystemLanguageController::class)->names('system-languages');

    // === CURRENCY MANAGEMENT ===
    Route::resource('currencies', CurrencyController::class)->names('currencies');

    // === TIMEZONE MANAGEMENT ===
    Route::resource('timezones', TimezoneController::class)->names('timezones');
});
