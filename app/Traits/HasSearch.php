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

        // Validate columns against actual DB schema to prevent "no such column" errors
        $schemaColumns = \Illuminate\Support\Facades\Schema::getColumnListing($model->getTable());
        $columns = array_intersect($columns, $schemaColumns);

        $relations = method_exists($model, 'getRelationshipNames')
            ? $model->getRelationshipNames()
            : [];

        return $query->where(function ($q) use ($search, $columns, $relations, $model) {
            // Search in model columns
            foreach ($columns as $column) {
                // Use whereRaw with LOWER for case-insensitive search with index support
                // Explicitly define the table name to prevent "ambiguous column name" errors in JOINs
                $q->orWhereRaw("LOWER({$model->getTable()}.{$column}) LIKE ?", ["%{$search}%"]);
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

                    // Validate relation columns against actual DB schema
                    $relSchemaColumns = \Illuminate\Support\Facades\Schema::getColumnListing($relModel->getTable());
                    $relColumns = array_intersect($relColumns, $relSchemaColumns);

                    $relQuery->where(function ($qq) use ($relColumns, $search, $relModel) {
                        foreach ($relColumns as $col) {
                            // Explicitly define the relation's table name
                            $qq->orWhereRaw("LOWER({$relModel->getTable()}.{$col}) LIKE ?", ["%{$search}%"]);
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
     * @param array $searchColumnsFilters Associative array of column => search_term
     * @return Builder
     */
    public function scopeSearchWithRelations(Builder $query, ?string $search = null, array $selectedColumns = [], array $availableRelations = [], array $searchColumnsFilters = []): Builder
    {
        // Apply search
        if (!empty($search)) {
            $query->search($search);
        }

        // Apply column-specific filters
        if (!empty($searchColumnsFilters)) {
            $query->where(function ($q) use ($searchColumnsFilters) {
                foreach ($searchColumnsFilters as $column => $searchTerm) {
                    if (!empty($searchTerm) && is_string($column)) {
                        $q->whereRaw("LOWER(`$column`) LIKE ?", ["%" . strtolower(trim($searchTerm)) . "%"]);
                    }
                }
            });
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
     * @param array $searchColumnsFilters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function searchAndPaginate(?string $search = null, array $selectedColumns = [], array $availableRelations = [], ?int $perPage = null, array $searchColumnsFilters = [])
    {
        $query = static::query();

        // Apply general search
        if (!empty($search)) {
            $query->search($search);
        }

        // Apply column-specific filters
        if (!empty($searchColumnsFilters)) {
            $query->where(function ($q) use ($searchColumnsFilters) {
                foreach ($searchColumnsFilters as $column => $searchTerm) {
                    if (!empty($searchTerm) && is_string($column)) {
                        $q->whereRaw("LOWER(`$column`) LIKE ?", ["%" . strtolower(trim($searchTerm)) . "%"]);
                    }
                }
            });
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
