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

    /**
     * Save current column configuration as system default (for all users)
     * Requires superadmin role check in UI
     */
    public function saveAsSystemDefault()
    {
        if (!Auth::check() || !getActiveUser()->hasRole('superadmin')) {
            return;
        }

        \App\Models\TableColumn::updateOrCreate(
            ['model_class' => $this->modelClass, 'user_id' => null],
            ['columns' => $this->columns]
        );

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => __('messages.system_default_saved') ?? 'System default columns saved successfully.'
        ]);
        
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('main.system_default_saved') ?? 'System default columns saved successfully.'
        ]);
    }

    public function applyColumns()
    {
        $model = new $this->modelClass();
        $excluded = $this->getExcludedColumnsWithSettings($model);

        $cleanPending = array_diff($this->pendingColumns, $excluded);
        $this->columns = array_values(array_intersect($cleanPending, $this->allColumns));

        if (Auth::check()) {
            getActiveUser()->saveTableColumnsFor($this->modelClass, $this->columns);
            $this->hasCustomColumns = true;
        }
        
        $this->dispatch('close-modal');
        $this->dispatch('refresh-page');
    }

    public function toggleAll(): void
    {
        $model = new $this->modelClass();
        $excluded = $this->getExcludedColumnsWithSettings($model);

        if ($this->isAllSelected) {
            $defaultColumnsCount = optional(getActiveSettings())->app_columns_length ?? config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5));
            $this->pendingColumns = array_slice($this->allColumns, 0, $defaultColumnsCount);
        } else {
            $this->pendingColumns = $this->allColumns;
        }

        $this->applyColumns();
    }

    public function resetColumns(): void
    {
        if (Auth::check()) {
            getActiveUser()->deleteTableColumnsFor($this->modelClass);
            $this->hasCustomColumns = false; 
        }

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

    public function updatedPendingColumns(): void
    {
        $model = new $this->modelClass();
        $excluded = $this->getExcludedColumnsWithSettings($model);
        $this->pendingColumns = array_values(array_diff($this->pendingColumns, $excluded));
    }
}
