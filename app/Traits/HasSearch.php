<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSearch
{
    public function scopeSearch(Builder $query, ?string $search = null): Builder
    {
        if (empty($search)) {
            return $query;
        }
        
        $search = trim($search);

        $model = $this;

        $columns = method_exists($model, 'getExcludedColumns')
            ? array_diff($model->getFillable(), $model->getExcludedColumns())
            : $model->getFillable();

        $relations = method_exists($model, 'getRelationshipNames')
            ? $model->getRelationshipNames()
            : [];

        return $query->where(function ($q) use ($search, $columns, $relations) {
            // ابحث في أعمدة الموديل نفسه
            foreach ($columns as $column) {
                $q->orWhere($column, 'LIKE', "%{$search}%");
            }

            // ابحث في العلاقات
            foreach ($relations as $relation) {
                $q->orWhereHas($relation, function ($relQuery) use ($search) {
                    $relModel = $relQuery->getModel();
                    $relColumns = $relModel->getFillable();

                    $relQuery->where(function ($qq) use ($relColumns, $search) {
                        foreach ($relColumns as $col) {
                            $qq->orWhere($col, 'LIKE', "%{$search}%");
                        }
                    });
                });
            }
        });
    }
}