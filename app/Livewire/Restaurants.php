<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\Region;
use App\Models\Country;
use Livewire\Component;
use App\Models\Subregion;
use App\Models\Restaurant;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;

class Restaurants extends Component
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
        $this->mountWithCustomColumns(Restaurant::class, 5);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Restaurant::count();
        $data = Restaurant::query()->with($this->relations)->search($this->search)->paginate(getPaginate());

        return view('livewire.restaurants', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}