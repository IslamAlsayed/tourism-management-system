<?php

use Illuminate\Support\Facades\Route;
use Modules\Definitions\Http\Controllers\PricingDefinitionController;
use Modules\Definitions\Http\Controllers\FieldDefinitionController;

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

Route::prefix('dashboard/definitions')->name('dashboard.definitions.')->middleware(['auth'])->group(function() {
    Route::resource('pricing-definitions', PricingDefinitionController::class)->names('pricing-definitions');
    Route::resource('field-definitions', FieldDefinitionController::class)->names('field-definitions');
});
