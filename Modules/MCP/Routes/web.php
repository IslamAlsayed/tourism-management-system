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

Route::prefix('dashboard/mcp')->name('dashboard.mcp.')->middleware('auth')->group(function() {
    Route::get('/', 'MCPController@index')->name('index');
    Route::get('/google-maps', 'MCPController@googleMaps')->name('google-maps');
    Route::get('/google-drive', 'MCPController@googleDrive')->name('google-drive');
});
