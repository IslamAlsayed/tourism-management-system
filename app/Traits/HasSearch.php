<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSearch
{
    /**
     * Apply search to the query.
     * Searches in model's searchable/fillable columns and defined relations.
     * Uses case-insensitive matching with LOWER() for better index support.
     * 
     * @param Builder $query
     * @param string|null $search The search term
     * @return Builder
     */
    public function scopeSearch(Builder $query, ?string $search = null): Builder
    {
        if (empty($search)) {
            return $query;
        }

        $search = strtolower(trim($search));
        $model = $this;

        // Use searchable columns if defined, otherwise use fillable minus excluded
        if (method_exists($model, 'getSearchableColumns')) {
            $columns = $model->getSearchableColumns();
        } else {
            $columns = method_exists($model, 'getExcludedColumns')
                ? array_diff($model->getFillable(), $model->getExcludedColumns())
                : $model->getFillable();
        }

        $relations = method_exists($model, 'getRelationshipNames')
            ? $model->getRelationshipNames()
            : [];

        return $query->where(function ($q) use ($search, $columns, $relations) {
            // Search in model columns
            foreach ($columns as $column) {
                // Use whereRaw with LOWER for case-insensitive search with index support
                $q->orWhereRaw("LOWER({$column}) LIKE ?", ["%{$search}%"]);
            }

            // Search in relations - optimized
            foreach ($relations as $relation) {
                $q->orWhereHas($relation, function ($relQuery) use ($search) {
                    $relModel = $relQuery->getModel();

                    // Use searchable columns if defined
                    if (method_exists($relModel, 'getSearchableColumns')) {
                        $relColumns = $relModel->getSearchableColumns();
                    } else {
                        // Get only searchable columns (exclude IDs, timestamps, etc.)
                        $relColumns = array_filter($relModel->getFillable(), function ($col) {
                            return !in_array($col, ['id', 'created_at', 'updated_at', 'deleted_at'])
                                && !str_ends_with($col, '_id');
                        });
                    }

                    $relQuery->where(function ($qq) use ($relColumns, $search) {
                        foreach ($relColumns as $col) {
                            $qq->orWhereRaw("LOWER({$col}) LIKE ?", ["%{$search}%"]);
                        }
                    });
                });
            }
        });
    }

    /**
     * Apply optimized search with eager loading based on selected columns.
     * This method combines search functionality with smart relation loading.
     * 
     * @param Builder $query
     * @param string|null $search
     * @param array $selectedColumns The columns selected for display
     * @param array $availableRelations Available relation names that can be loaded
     * @return Builder
     */
    public function scopeSearchWithRelations(Builder $query, ?string $search = null, array $selectedColumns = [], array $availableRelations = []): Builder
    {
        // Apply search
        if (!empty($search)) {
            $query->search($search);
        }

        // Eager load relations only if they're in selected columns
        if (!empty($selectedColumns) && !empty($availableRelations)) {
            $relationsToLoad = array_intersect($availableRelations, $selectedColumns);
            if (!empty($relationsToLoad)) {
                $query->with($relationsToLoad);
            }
        }

        return $query;
    }

    /**
     * Get a paginated result with optimized search and relation loading.
     * This is a complete solution for Livewire components.
     * 
     * @param string|null $search
     * @param array $selectedColumns
     * @param array $availableRelations
     * @param int|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function searchAndPaginate(?string $search = null, array $selectedColumns = [], array $availableRelations = [], ?int $perPage = null)
    {
        $query = static::query();

        // Apply search
        if (!empty($search)) {
            $query->search($search);
        }

        // Eager load relations only if they're in selected columns
        if (!empty($selectedColumns) && !empty($availableRelations)) {
            $relationsToLoad = array_intersect($availableRelations, $selectedColumns);
            if (!empty($relationsToLoad)) {
                $query->with($relationsToLoad);
            }
        }

        return $query->paginate($perPage ?? getPaginate());
    }
}