<?php

namespace App\Traits;

use App\Models\Setting;

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
        Setting::updateOrCreate(['id' => 1], ['app_paginate_count' => $value]);
    }
}