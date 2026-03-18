<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;

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
        if (optional(getActiveSettings())->app_show_uuid_column == 0) {
            $excluded[] = 'uuid';
        }

        return $excluded;
    }

    #[On('filterColumn')]
    public function filterColumn($column, $value)
    {
        $this->searchColumns[$column] = $value;
        $this->resetPage(); // Reset pagination when filtering
    }

    public function mountWithCustomColumns(string $modelClass)
    {
        $this->modelClass = $modelClass;
        $model = new $modelClass();
        $this->relations = method_exists($model, 'getRelationshipNames') ? $model->getRelationshipNames() : [];

        // Fetch all actual columns from the database schema
        $schemaColumns = \Illuminate\Support\Facades\Schema::getColumnListing($model->getTable());
        
        $this->fillable = $schemaColumns;
        array_splice($this->fillable, optional(getActiveSettings())->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5)), 0, $this->relations);

        $excluded = $this->getExcludedColumnsWithSettings($model);

        // Sort columns
        $this->allColumns = array_values(array_diff($this->fillable, $excluded));

        $this->searchColumns = [];

        // استرجاع الأعمدة من DB للمستخدم الحالي
        $savedColumns = null;

        if (Auth::check()) {
            $savedColumns = getActiveUser()->getTableColumnsFor($modelClass);
            
            // إذا لم توجد إعدادات خاصة بالمستخدم، ابحث عن إعدادات النظام الافتراضية (user_id = null)
            if (is_null($savedColumns)) {
                $savedColumns = \App\Models\TableColumn::where('model_class', $modelClass)
                    ->whereNull('user_id')
                    ->first()
                    ?->columns;
            }

            $this->hasCustomColumns = !is_null($savedColumns); // Set flag if custom columns exist
        }

        // إذا لم توجد إعدادات محفوظة، استخدم الافتراضي
        $defaultColumnsCount = optional(getActiveSettings())->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5));
        $this->columns = $savedColumns ?? array_slice($this->allColumns, 0, $defaultColumnsCount);

        $this->pendingColumns = $this->columns;
    }

    /**
     * Save current column configuration as system default (for all users)
     * Requires superadmin role check in UI
     */
    public function saveAsSystemDefault()
    {
        if (!Auth::check() || !getActiveUser()->hasRole('superadmin')) {
            return;
        }

        $model = new $this->modelClass();
        $excluded = $this->getExcludedColumnsWithSettings($model);
        $cleanPending = array_diff($this->pendingColumns, $excluded);
        $columnsToSave = array_values(array_intersect($cleanPending, $this->allColumns));

        // Save as system default
        \App\Models\TableColumn::updateOrCreate(
            ['model_class' => $this->modelClass, 'user_id' => null],
            ['columns' => $columnsToSave]
        );

        // Also apply to current user view
        $this->columns = $columnsToSave;
        getActiveUser()->saveTableColumnsFor($this->modelClass, $this->columns);
        $this->hasCustomColumns = true;

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('main.system_default_saved') ?? 'System default columns saved successfully.'
        ]);
        
        // Refresh page so rows are updated
        $this->dispatch('refresh-page');
    }

    public function applyColumns()
    {
        $model = new $this->modelClass();
        // $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];
        $excluded = $this->getExcludedColumnsWithSettings($model);

        // تأكد من استبعاد الأعمدة غير المسموح بها
        $cleanPending = array_diff($this->pendingColumns, $excluded);

        // رتب الأعمدة بناءً على الترتيب الجديد في pendingColumns
        // مع التأكد من أنها موجودة في allColumns
        $this->columns = array_values(array_intersect($cleanPending, $this->allColumns));

        // حفظ التغييرات في قاعدة البيانات للمستخدم الحالي
        if (Auth::check()) {
            getActiveUser()->saveTableColumnsFor($this->modelClass, $this->columns);
            $this->hasCustomColumns = true; // Mark that user now has custom columns
        }
        
        $this->dispatch('close-modal');
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
            $defaultColumnsCount = optional(getActiveSettings())->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5));
            $this->pendingColumns = array_slice($this->allColumns, 0, $defaultColumnsCount);
        }
        // غير كده → حدد الكل
        else {
            $this->pendingColumns = $this->allColumns;
        }

        // Apply changes immediately for toggleAll for better UX
        $this->applyColumns();
    }

    /**
     * Clear all selected columns (keeps minimum essential columns)
     */
    public function clearAllColumns(): void
    {
        // Keep essential columns to prevent empty table
        $essentialColumns = array_values(array_intersect(
            ['id', 'name'],
            $this->allColumns
        ));

        // If no essential columns found, keep at least the first column
        if (empty($essentialColumns) && !empty($this->allColumns)) {
            $essentialColumns = [reset($this->allColumns)];
        }

        $this->pendingColumns = $essentialColumns;
        $this->applyColumns();

        $this->dispatch('show-toast', [
            'type' => 'info',
            'message' => __('messages.columns_cleared_to_minimum', ['default' => 'Columns reset to minimum essentials.']),
        ]);
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

        // استرجع الافتراضي العام للنظام إذا وجد، وإلا استخدم الافتراضي البرمجي
        $systemDefault = \App\Models\TableColumn::where('model_class', $this->modelClass)
            ->whereNull('user_id')
            ->first()
            ?->columns;

        if ($systemDefault) {
            $this->columns = $systemDefault;
        } else {
            $defaultColumnsCount = optional(getActiveSettings())->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5));
            $this->columns = array_slice($this->allColumns, 0, $defaultColumnsCount);
        }

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
