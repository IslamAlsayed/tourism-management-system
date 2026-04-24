<?php

namespace App\Traits;

use Modules\Core\Entities\Setting;

trait CustomPagination
{
    public $paginate;

    public function mountWithCustomPagination()
    {
        $currentPaginate = getPaginate();
        $this->paginate = ($currentPaginate == config('app.paginate_max')) ? 'all' : $currentPaginate;
    }

    public function updatedPaginate($value)
    {
        $mainValue = $value == 'all' ? config('app.paginate_max') : (int) $value;
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
