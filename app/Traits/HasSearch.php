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

        // Get searchable columns
        if (method_exists($model, 'getSearchableColumns')) {
            $columns = $model->getSearchableColumns();
        } else {
            $columns = method_exists($model, 'getExcludedColumns')
                ? array_diff($model->getFillable(), $model->getExcludedColumns())
                : $model->getFillable();
        }

        // Validate columns against schema
        $schemaColumns = \Illuminate\Support\Facades\Schema::getColumnListing($model->getTable());
        $columns = array_intersect($columns, $schemaColumns);

        $relations = method_exists($model, 'getRelationshipNames')
            ? $model->getRelationshipNames()
            : [];

        return $query->where(function ($q) use ($search, $columns, $relations, $model) {
            // Search in root model columns
            foreach ($columns as $column) {
                $q->orWhereRaw("LOWER({$model->getTable()}.{$column}) LIKE ?", ["%{$search}%"]);
            }

            // Search in relations (Recursive search for nested relations)
            foreach ($relations as $relation) {
                // Support dot notation for deep relations
                $this->applySearchInRelation($q, $relation, $search);
            }
        });
    }

    /**
     * Helper to apply search in a specific relation (handles nested ones)
     */
    protected function applySearchInRelation(Builder $q, string $relation, string $search)
    {
        $q->orWhereHas($relation, function ($relQuery) use ($search) {
            $relModel = $relQuery->getModel();

            // Get searchable columns for the related model
            if (method_exists($relModel, 'getSearchableColumns')) {
                $relColumns = $relModel->getSearchableColumns();
            } else {
                $relColumns = array_filter($relModel->getFillable(), function ($col) {
                    return !in_array($col, ['id', 'created_at', 'updated_at', 'deleted_at'])
                        && !str_ends_with($col, '_id');
                });
            }

            $relSchemaColumns = \Illuminate\Support\Facades\Schema::getColumnListing($relModel->getTable());
            $relColumns = array_intersect($relColumns, $relSchemaColumns);

            $relQuery->where(function ($qq) use ($relColumns, $search, $relModel) {
                foreach ($relColumns as $col) {
                    $qq->orWhereRaw("LOWER({$relModel->getTable()}.{$col}) LIKE ?", ["%{$search}%"]);
                }

                // If the related model ALSO has relationship names to search
                if (method_exists($relModel, 'getRelationshipNames')) {
                    foreach ($relModel->getRelationshipNames() as $nestedRelation) {
                        // Prevent infinite loop by not searching back to parent if possible
                        // But for simplicity, we search one more level
                        $qq->orWhereHas($nestedRelation, function ($nestedQuery) use ($search) {
                            $nestedModel = $nestedQuery->getModel();
                            $targetCols = method_exists($nestedModel, 'getSearchableColumns') 
                                ? $nestedModel->getSearchableColumns() 
                                : ['name', 'title', 'label']; // default fallback for deep nested
                            
                            $nestedSchema = \Illuminate\Support\Facades\Schema::getColumnListing($nestedModel->getTable());
                            $targetCols = array_intersect($targetCols, $nestedSchema);

                            $nestedQuery->where(function ($lastQ) use ($targetCols, $search, $nestedModel) {
                                foreach ($targetCols as $c) {
                                    $lastQ->orWhereRaw("LOWER({$nestedModel->getTable()}.{$c}) LIKE ?", ["%{$search}%"]);
                                }
                            });
                        });
                    }
                }
            });
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

        $modelTable = $query->getModel()->getTable();
        // Apply column-specific filters
        if (!empty($searchColumnsFilters)) {
            $query->where(function ($q) use ($searchColumnsFilters, $modelTable) {
                foreach ($searchColumnsFilters as $column => $searchTerm) {
                    if (!empty($searchTerm) && is_string($column)) {
                        $q->whereRaw("LOWER({$modelTable}.{$column}) LIKE ?", ["%" . strtolower(trim($searchTerm)) . "%"]);
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

        $modelTable = $query->getModel()->getTable();
        // Apply column-specific filters
        if (!empty($searchColumnsFilters)) {
            $query->where(function ($q) use ($searchColumnsFilters, $modelTable) {
                foreach ($searchColumnsFilters as $column => $searchTerm) {
                    if (!empty($searchTerm) && is_string($column)) {
                        $q->whereRaw("LOWER({$modelTable}.{$column}) LIKE ?", ["%" . strtolower(trim($searchTerm)) . "%"]);
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
