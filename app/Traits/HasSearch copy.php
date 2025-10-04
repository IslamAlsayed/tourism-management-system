<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait HasSearch
{
    public function scopeSearch($query, $search, $fillable, $relations = [])
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search, $fillable, $relations) {
            // البحث في الأعمدة الرئيسية
            foreach ($fillable as $field) {
                $q->orWhere($field, 'LIKE', "%{$search}%");
            }

            // البحث في العلاقات ديناميك
            foreach ($relations as $relation) {
                $q->orWhereHas($relation, function ($subQ) use ($relation, $search) {
                    // استخرج الموديل بتاع الـ relation
                    $relatedModel = $subQ->getModel();
                    $columns = $relatedModel->getFillable(); // الأعمدة القابلة للملء

                    // fallback: لو الموديل مفيهوش fillable نجيب أعمدة الـ table من DB
                    if (empty($columns)) {
                        $table = $relatedModel->getTable();
                        $columns = Schema::getColumnListing($table);
                    }

                    foreach ($columns as $col) {
                        $subQ->orWhere($col, 'LIKE', "%{$search}%");
                    }
                });
            }
        });
    }
}