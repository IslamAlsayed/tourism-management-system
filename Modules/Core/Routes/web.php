<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\RoleController;
use Modules\Core\Http\Controllers\UserController;
use Modules\Core\Http\Controllers\ProfileController;
use Modules\Core\Http\Controllers\ReportsController;
use Modules\Core\Http\Controllers\SettingController;
use Modules\Core\Http\Controllers\PermissionController;
use Modules\Core\Http\Controllers\ActivityLogController;

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

Route::prefix('dashboard/core')->name('dashboard.core.')->middleware('auth')->group(function () {
    // === USER MANAGEMENT ===
    Route::resource('users', UserController::class)->names('users');

    // === ROLE MANAGEMENT ===
    Route::resource('roles', RoleController::class)->names('roles');

    // === PERMISSIONS MANAGEMENT ===
    Route::resource('permissions', PermissionController::class)->names('permissions');

    // === REPORTS ===
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportsController::class, 'index'])->name('index');
        Route::get('/users', [ReportsController::class, 'users'])->name('users');
        Route::get('/locations', [ReportsController::class, 'locations'])->name('locations');
        Route::get('/analytics', [ReportsController::class, 'analytics'])->name('analytics');
    });

    // === ACTIVITY LOG ===
    Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
    Route::get('activity-log/users', [ActivityLogController::class, 'users'])->name('activity-log.users');
    Route::get('activity-log/system', [ActivityLogController::class, 'system'])->name('activity-log.system');

    // === PROFILE MANAGEMENT ===
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::get('/change_password', [ProfileController::class, 'changePassword'])->name('change_password');
        Route::put('/update_password', [ProfileController::class, 'updatePassword'])->name('update_password');
        Route::post('/update', [ProfileController::class, 'update'])->name('update');
        Route::post('/photo', [ProfileController::class, 'updatePhoto'])->name('photo');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');

        // Profile Settings Pages
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/test', [ProfileController::class, 'settingsTest'])->name('test');
            Route::get('/new', [ProfileController::class, 'settingsNew'])->name('new');
            Route::get('/final', [ProfileController::class, 'settingsFinal'])->name('final');
            Route::get('/security', [ProfileController::class, 'security'])->name('security');
            Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
        });
    });

    // Alternative Profile
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');

    // === SYSTEM SETTINGS ===    
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('general', [SettingController::class, 'general'])->name('general');
        Route::get('security', [SettingController::class, 'security'])->name('security');
        Route::get('notifications', [SettingController::class, 'notifications'])->name('notifications');
        Route::get('backup', [SettingController::class, 'backup'])->name('backup');
        Route::get('booking', [SettingController::class, 'booking'])->name('booking');
        Route::get('integration', [SettingController::class, 'integration'])->name('integration');
        Route::get('system', [SettingController::class, 'system'])->name('system');
        Route::post('backup/create', [SettingController::class, 'createBackup'])->name('backup.create');
    });
    Route::resource('settings', SettingController::class)->names('settings');
});

require __DIR__ . '/auth.php';
