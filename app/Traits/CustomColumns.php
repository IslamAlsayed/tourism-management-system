<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CustomColumns
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

    public function mountWithCustomColumns(string $modelClass): void
    {
        $this->modelClass = $modelClass;
        $model = new $modelClass();
        $this->relations = method_exists($model, 'getRelationshipNames') ? $model->getRelationshipNames() : [];

        $this->fillable = $model->getFillable();
        array_splice($this->fillable, getActiveSettings()->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5)), 0, $this->relations);

        $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];

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

    public function applyColumns(): void
    {
        $model = new $this->modelClass();
        $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];

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
        $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];

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

        // Apply changes immediately for better UX
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
        $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];
        $fillable = array_values(array_diff($model->getFillable(), $excluded));
        $defaultColumnsCount = getActiveSettings()->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5));

        $this->columns = array_slice($fillable, 0, $defaultColumnsCount);
        $this->pendingColumns = $this->columns;
    }
}