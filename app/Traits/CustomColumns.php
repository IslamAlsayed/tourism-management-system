<?php

namespace App\Traits;

trait CustomColumns
{
    public string $modelClass;
    public array $fillable = [];
    public array $relations = [];
    public array $searchColumns = [];
    public array $allColumns = [];
    public array $columns = [];
    public array $pendingColumns = [];

    public function mountWithCustomColumns(string $modelClass, int $defaultCount = 4): void
    {
        $this->modelClass = $modelClass;
        $model = new $modelClass();
        $this->relations = method_exists($model, 'getRelationshipNames') ? $model->getRelationshipNames() : [];

        $this->fillable = $model->getFillable();
        array_splice($this->fillable, $defaultCount, 0, $this->relations);

        $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];

        // Sort columns
        $this->allColumns = array_values(array_diff($this->fillable, $excluded));

        $this->searchColumns = array_filter($this->allColumns, fn($c) => !in_array($c, $this->relations));

        // استرجاع الأعمدة من الـ session أو DB أو افتراضي
        $savedColumns = session("user_table_columns_{$modelClass}");

        // تقدر تعدل لو عايز تخزن لكل مستخدم في DB
        // $savedColumns = auth()->user()->getTableColumnsFor($modelClass);

        $this->columns = $savedColumns ?? array_slice($this->allColumns, 0, $defaultCount);

        $this->pendingColumns = $this->columns;
    }

    public function applyColumns(): void
    {
        $model = new $this->modelClass();
        $excluded = method_exists($model, 'getExcludedColumns') ? $model->getExcludedColumns() : [];

        // Sort columns
        $cleanPending = array_diff($this->pendingColumns, $excluded);
        $this->columns = array_values(array_intersect($this->allColumns, $cleanPending));

        // حفظ في session
        session(["user_table_columns_{$this->modelClass}" => $this->columns]);

        // حفظ في DB (لو حابب)
        // auth()->user()->saveTableColumnsFor($this->modelClass, $this->columns);

        $this->resetPage();
    }

    public function scopeSearch(string $modelClass, string $search = null)
    {
        $model = new $modelClass();

        return $model::query()->when($search, function ($query) {
            // $search = strtolower($this->search);

            // $items = [];
            // foreach ($this->relations as $relate) {
            //     $model = $relate->getModel();
            //     $items[$relate] = $model::query()->when($this->search, function ($query) {
            //         $query->where(function ($q) {
            //             foreach ($model->getFillable() as $column) {
            //                 $q->orWhere($column, 'like', '%' . $this->search . '%');
            //             }
            //         });
            //     })->get('id');
            // }

            // $query->where(function ($q) use ($search, $items) {
            //     foreach ($items as $key => $item) {
            //         $q->orWhereIn($key . '_id', $item);
            //     }

            //     foreach ($this->searchColumns as $column) {
            //         $q->orWhere($column, 'like', '%' . $search . '%');
            //     }
            // });

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
        })->with($this->relations)->paginate(getPaginate());
    }
}