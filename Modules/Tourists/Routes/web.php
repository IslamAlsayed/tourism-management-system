<?php

use Illuminate\Support\Facades\Route;
use Modules\Tourists\Http\Controllers\SiteController;
use Modules\Tourists\Http\Controllers\ServiceController;

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

Route::prefix('dashboard/tourists')->name('dashboard.tourists.')->middleware('auth')->group(function () {
    Route::resource('sites', SiteController::class)->names('sites');
    Route::resource('services', ServiceController::class)->names('services');
});
