<?php

namespace App\Traits;

trait CustomPagination
{
    public $paginate = 20;

    public function mountWithCustomPagination()
    {
        $this->paginate = session('paginate_count') ?: config('app.paginate_count');
    }

    public function updatedPaginate($value)
    {
        session(['paginate_count' => $value]);
    }
}