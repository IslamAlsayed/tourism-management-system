<?php

use Illuminate\Support\Facades\Route;
use Modules\CRM\Http\Controllers\ClientController;

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

Route::prefix('dashboard/crm')->name('dashboard.crm.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('clients', ClientController::class)->names('clients');
});
