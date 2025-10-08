<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Region;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;

class Countries extends Component
{
    use WithPagination, CustomPagination, CustomColumns;

    public $search = '';
    public $totalCount = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPaginate()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Country::class);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Country::count();
        $data = Country::query()->with($this->relations)->search($this->search)->paginate(getPaginate());

        return view('livewire.countries', [
            'data' => $data,
            'relations' => $this->relations,
            'totalCount' => $this->totalCount,
        ]);
    }
}