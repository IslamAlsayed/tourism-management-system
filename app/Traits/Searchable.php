<?php

namespace App\Traits;

trait Searchable
{
    public function scopeSearch(string $modelClass, string $search = null)
    {
        $model = new $modelClass();

        return $model::query()->when($search, function ($query) {
            $search = strtolower($this->search);
            $query->where(function ($q) use ($search) {
                foreach ($this->searchColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            });
            foreach ($this->relations as $relate) {
                $query->orWhereHas($relate, function ($q) use ($search) {
                    $model = $q->getModel();
                    foreach ($model->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            }
        })->paginate(getPaginate());
    }
}