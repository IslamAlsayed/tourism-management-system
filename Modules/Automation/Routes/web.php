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

Route::prefix('automation')->group(function() {
    Route::get('/', 'AutomationController@index');
    Route::get('/settings', \Modules\Automation\Livewire\WebhookSettings::class)->name('automation.settings');
});
