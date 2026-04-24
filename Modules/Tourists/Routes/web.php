<?php

use Illuminate\Support\Facades\Route;
use Modules\Tourists\Http\Controllers\TouristsController;

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

Route::prefix('dashboard/tourists')->name('dashboard.tourists.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [TouristsController::class, 'index']);
});
