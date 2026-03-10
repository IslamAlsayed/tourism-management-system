<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

/**
 * ===================================================
 * BACKUP - REFRESH BASED CUSTOM COLUMNS
 * ===================================================
 * 
 * This was the Form+Refresh based implementation
 * Kept as backup for potential future reference
 * 
 * Date: December 23, 2025
 * ===================================================
 */
trait CustomColumnsRefreshBased
{
    public string $modelClass;
    public array $fillable = [];
    public array $relations = [];
    public array $searchColumns = [];
    public array $allColumns = [];
    public array $columns = [];
    public array $pendingColumns = [];
    public bool $hasCustomColumns = false;

    protected function getExcludedColumnsWithSettings($model)
    {
        $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];

        if (optional(getActiveSettings())->app_show_uuid_column == 0) {
            $excluded[] = 'uuid';
        }

        return $excluded;
    }

    #[On('filterColumn')]
    public function filterColumn($column, $value)
    {
        $this->searchColumns[$column] = $value;
        // Assuming resetPage() is a method available in the Livewire component using this trait
        // If not, this line might cause an error or needs to be implemented in the component.
        // $this->resetPage(); // Reset pagination when filtering
    }

    public function initializeCustomColumns(string $modelClass)
    {
        $this->modelClass = $modelClass;
        $model = new $modelClass();
        $this->relations = method_exists($model, 'getRelationshipNames') ? $model->getRelationshipNames() : [];

        $this->fillable = $model->getFillable();
        array_splice(
            $this->fillable,
            optional(getActiveSettings())->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5)),
            0,
            $this->relations
        );

        $excluded = $this->getExcludedColumnsWithSettings($model);
        $this->allColumns = array_values(array_diff($this->fillable, $excluded));
        $this->searchColumns = array_filter($this->allColumns, fn($c) => !in_array($c, $this->relations));

        $savedColumns = null;

        if (Auth::check()) {
            $savedColumns = getActiveUser()->getTableColumnsFor($modelClass);
            $this->hasCustomColumns = !is_null($savedColumns);
        }

        $defaultColumnsCount = optional(getActiveSettings())->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5));
        $this->columns = $savedColumns ?? array_slice($this->allColumns, 0, $defaultColumnsCount);

        $this->pendingColumns = $this->columns;
    }

    public function mountWithCustomColumns(string $modelClass)
    {
        $this->initializeCustomColumns($modelClass);
    }

    public function getSelectedColumns(): array
    {
        return $this->columns;
    }

    public function getAllAvailableColumns(): array
    {
        return $this->allColumns;
    }

    public function hasCustomColumnPreferences(): bool
    {
        return $this->hasCustomColumns;
    }
}
