<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

/**
 * ===================================================
 * LEGACY TRAIT - LIVEWIRE BASED CUSTOM COLUMNS
 * ===================================================
 * 
 * This is the original Livewire-based implementation
 * Kept as backup for potential future rollback
 * 
 * Date: December 23, 2025
 * 
 * This trait was replaced with a non-Livewire approach
 * that uses standard forms and page refresh.
 * 
 * To restore this implementation:
 * 1. Rename CustomColumns.php to CustomColumnsRefresh.php
 * 2. Rename this file to CustomColumns.php
 * 3. Update components/columns.blade.php to use wire:click
 * 4. Revert routes in web.php to remove column preference routes
 * ===================================================
 */
trait CustomColumnsLivewireLegacy
{
    public string $modelClass;
    public array $fillable = [];
    public array $relations = [];
    public array $searchColumns = [];
    public array $allColumns = [];
    public array $columns = [];
    public array $pendingColumns = [];
    public bool $isAllSelected = false;
    public bool $hasCustomColumns = false; // Track if user has saved custom columns

    /**
     * Get excluded columns including uuid if disabled in settings
     */
    protected function getExcludedColumnsWithSettings($model)
    {
        $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];

        // استبعد uuid إذا كان معطل في الإعدادات
        if (getActiveSettings()->app_show_uuid_column == 0) {
            $excluded[] = 'uuid';
        }

        return $excluded;
    }

    public function mountWithCustomColumns(string $modelClass)
    {
        $this->modelClass = $modelClass;
        $model = new $modelClass();
        $this->relations = method_exists($model, 'getRelationshipNames') ? $model->getRelationshipNames() : [];

        $this->fillable = $model->getFillable();
        array_splice($this->fillable, getActiveSettings()->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5)), 0, $this->relations);

        $excluded = $this->getExcludedColumnsWithSettings($model);

        // $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];

        // Sort columns
        $this->allColumns = array_values(array_diff($this->fillable, $excluded));

        $this->searchColumns = array_filter($this->allColumns, fn($c) => !in_array($c, $this->relations));

        // استرجاع الأعمدة من DB للمستخدم الحالي
        $savedColumns = null;

        if (Auth::check()) {
            $savedColumns = getActiveUser()->getTableColumnsFor($modelClass);
            $this->hasCustomColumns = !is_null($savedColumns); // Set flag if custom columns exist
        }

        // إذا لم توجد إعدادات محفوظة، استخدم الافتراضي
        $defaultColumnsCount = getActiveSettings()->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5));
        $this->columns = $savedColumns ?? array_slice($this->allColumns, 0, $defaultColumnsCount);

        $this->pendingColumns = $this->columns;
    }

    public function applyColumns()
    {
        $model = new $this->modelClass();
        // $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];
        $excluded = $this->getExcludedColumnsWithSettings($model);

        // تأكد من استبعاد الأعمدة غير المسموح بها
        $cleanPending = array_diff($this->pendingColumns, $excluded);

        // رتب الأعمدة بنفس ترتيبها الأصلي
        $this->columns = array_values(array_intersect($this->allColumns, $cleanPending));

        // حفظ التغييرات في قاعدة البيانات للمستخدم الحالي
        if (Auth::check()) {
            getActiveUser()->saveTableColumnsFor($this->modelClass, $this->columns);
            $this->hasCustomColumns = true; // Mark that user now has custom columns
        }
    }

    /**
     * Check if all columns are selected
     */
    public function getIsAllSelectedProperty(): bool
    {
        $current = array_diff($this->pendingColumns, ['all']);
        return count($current) === count($this->allColumns);
    }

    public function toggleAll(): void
    {
        $model = new $this->modelClass();
        // $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];
        $excluded = $this->getExcludedColumnsWithSettings($model);

        // لو كل الأعمدة محددة → ارجع للافتراضي
        if ($this->isAllSelected) {
            $fillable = array_values(array_diff($model->getFillable(), $excluded));
            $defaultColumnsCount = getActiveSettings()->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5));
            $this->pendingColumns = array_slice($fillable, 0, $defaultColumnsCount);
        }
        // غير كده → حدد الكل
        else {
            $this->pendingColumns = $this->allColumns;
        }

        // Apply changes immediately for toggleAll for better UX
        $this->applyColumns();
    }

    /**
     * Reset columns to default for current user
     */
    public function resetColumns(): void
    {
        if (Auth::check()) {
            getActiveUser()->deleteTableColumnsFor($this->modelClass);
            $this->hasCustomColumns = false; // Mark that custom columns are removed
        }

        $model = new $this->modelClass();
        // $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];
        $excluded = $this->getExcludedColumnsWithSettings($model);
        $fillable = array_values(array_diff($model->getFillable(), $excluded));
        $defaultColumnsCount = getActiveSettings()->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5));

        $this->columns = array_slice($fillable, 0, $defaultColumnsCount);
        $this->pendingColumns = $this->columns;
    }

    /**
     * Update pendingColumns when checkbox changes
     * This method is automatically called by Livewire when pendingColumns property is updated
     */
    public function updatedPendingColumns(): void
    {
        // Ensure that the pending columns are properly filtered and sorted
        $model = new $this->modelClass();
        // $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];
        $excluded = $this->getExcludedColumnsWithSettings($model);

        // Clean the pending columns - remove any excluded columns
        $this->pendingColumns = array_values(array_diff($this->pendingColumns, $excluded));

        // Just update the UI state, user still needs to click "Apply" to save to database
        // This provides better control and prevents accidental saves
    }
}