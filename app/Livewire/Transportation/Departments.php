<?php

namespace App\Livewire\Transportation;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use App\Models\TransportationCompanyDepartment;
use Livewire\Component;
use App\Models\Subregion;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Models\TransportationCompany;

class Departments extends Component
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
        $this->mountWithCustomColumns(TransportationCompanyDepartment::class);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = TransportationCompanyDepartment::count();
        $data = TransportationCompanyDepartment::query()->with($this->relations)->search($this->search)->paginate(getPaginate());

        return view('livewire.transportation.departments', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}