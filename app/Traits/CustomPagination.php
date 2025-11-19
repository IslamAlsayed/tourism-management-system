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
        $mainValue = $value == 'all' ? config('app.paginate_max') : $value;
        session(['paginate_count' => $mainValue]);
        $this->dispatch('updatedPaginate', ['value' => $value]);
        Setting::updateOrCreate(['id' => 1], ['app_paginate_count' => $mainValue]);
    }

    public function updatingPaginate()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }
}