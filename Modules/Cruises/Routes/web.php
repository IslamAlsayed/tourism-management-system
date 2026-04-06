<?php

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

use Illuminate\Support\Facades\Route;
use Modules\Cruises\Http\Controllers\CruiseController;
use Modules\Cruises\Http\Controllers\CabinCategoryController;
use Modules\Cruises\Http\Controllers\CruiseSeasonController;
use Modules\Cruises\Http\Controllers\CruisePortController;
use Modules\Cruises\Http\Controllers\CruiseSupplierController;

Route::prefix('dashboard/cruises')->name('dashboard.cruises.')->middleware('auth')->group(function() {
    // Sub-resources MUST be registered BEFORE the main resource
    // to prevent {cruise} wildcard from catching 'categories', 'seasons', etc.
    Route::resource('categories', CabinCategoryController::class)->except(['show'])->names('categories');
    Route::resource('seasons', CruiseSeasonController::class)->except(['show'])->names('seasons');
    Route::resource('ports', CruisePortController::class)->except(['show'])->names('ports');
    Route::resource('suppliers', CruiseSupplierController::class)->except(['show'])->names('suppliers');
    
    // Experimental standalone pricing page
    Route::get('pricing/{cruise}', [CruiseController::class, 'pricing'])->name('pricing.standalone');

    // Main cruise resource LAST (its {cruise} wildcard would catch everything above)
    Route::resource('', CruiseController::class)->names([
        'index' => 'index',
        'create' => 'create',
        'store' => 'store',
        'show' => 'show',
        'edit' => 'edit',
        'update' => 'update',
        'destroy' => 'destroy',
    ])->parameters(['' => 'cruise']);
});
