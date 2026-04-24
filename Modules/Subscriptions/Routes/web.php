<?php

use Illuminate\Support\Facades\Route;
use Modules\Subscriptions\Http\Controllers\SubscriptionsController;

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

Route::prefix('dashboard/subscriptions')->name('dashboard.subscriptions.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [SubscriptionsController::class, 'index'])->name('index');
    Route::get('my-modules', [SubscriptionsController::class, 'myModules'])->name('my-modules');
    Route::post('activate/{moduleKey}', [SubscriptionsController::class, 'activate'])->name('activate');
    Route::post('deactivate/{moduleKey}', [SubscriptionsController::class, 'deactivate'])->name('deactivate');
});
