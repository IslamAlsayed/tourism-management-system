<?php

namespace App\Traits;

trait CustomPagination
{
    public $paginate;

    public function mountWithCustomPagination()
    {
        $this->paginate = getPaginate();
    }

    public function updatedPaginate($value)
    {
        session(['paginate_count' => $value]);
    }
}