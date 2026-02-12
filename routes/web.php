<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ExcelController;
use App\Http\Controllers\ColumnPreferenceController;
use App\Http\Controllers\Dashboard\AirlineController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\MediaFileController;
use App\Http\Controllers\Admin\SidebarManagerController;
use App\Http\Controllers\Dashboard\EntryPointController;
use App\Http\Controllers\Dashboard\NotificationController;
use Modules\Transportation\Http\Controllers\PricingDefinitionController;

/*
|----------------------|
|----- Web Routes -----|
|----------------------|
*/

Route::get('/', fn() => view('welcome'));

// Admin routes
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    // Dashboard Main
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('delete-all-selected-items', [DashboardController::class, 'deleteAll'])->name('deleteAll');

    // === COLUMN PREFERENCES ===
    Route::prefix('columns')->name('columns.')->group(function () {
        Route::post('/save', [ColumnPreferenceController::class, 'save'])->name('save');
        Route::post('/toggle-all', [ColumnPreferenceController::class, 'toggleAll'])->name('toggle-all');
        Route::post('/reset', [ColumnPreferenceController::class, 'reset'])->name('reset');
    });

    // === AIR TRANSPORT MANAGEMENT ===
    Route::resource('airlines', AirlineController::class)->names('airlines');
    Route::get('airlines/type/{type}', [AirlineController::class, 'type'])->name('airlines.type');

    // === MEDIA FILES MANAGEMENT ===
    Route::resource('media-files', MediaFileController::class)->names('media-files');
    Route::post('media-files/bulk-delete', [MediaFileController::class, 'bulkDelete'])->name('media-files.bulk-delete');

    // === ADMIN TOOLS ===
    Route::prefix('admin/sidebar')->name('sidebar.')->middleware('admin')->group(function () {
        Route::get('/', [SidebarManagerController::class, 'index'])->name('index');
        Route::get('/test', fn() => view('sidebar-manager.test'))->name('test');
        Route::post('/update-order', [SidebarManagerController::class, 'updateOrder'])->name('update-order');
        Route::post('/toggle-visibility', [SidebarManagerController::class, 'toggleVisibility'])->name('toggle-visibility');
        Route::post('/reset', [SidebarManagerController::class, 'resetToDefault'])->name('reset');
        Route::get('/export', [SidebarManagerController::class, 'exportConfig'])->name('export');
    });

    // === NOTIFICATIONS ===
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');

        // Keep API routes for any AJAX calls if needed
        Route::get('/recent', [NotificationController::class, 'getRecent'])->name('recent');
        Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('unread-count');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::post('/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/{notification}/mark-unread', [NotificationController::class, 'markAsUnread'])->name('mark-unread');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
    });

    // Route::get('import/data?{model?}&{models?}&{view?}', [ExcelController::class, 'import'])->name('import.data');
    Route::get('import/data', [ExcelController::class, 'import'])->name('import.data');
    Route::post('import/{models}/data/{type?}', [ExcelController::class, 'importData'])->name('import.data.post');
    Route::get('export/{models}/data/{type?}', [ExcelController::class, 'exportData'])->name('export.data');
});
