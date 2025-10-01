<?php

namespace App\Livewire\Transportation;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use Livewire\Component;
use App\Models\Subregion;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Models\TransportationCompany;

class Companies extends Component
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
        $this->mountWithCustomColumns(TransportationCompany::class, 5);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = TransportationCompany::count();
        // $data = $this->scopeSearch(Subregion::class);

        $data = TransportationCompany::query()->when($this->search, function ($query) {
            $search = strtolower($this->search);

            $query->where(function ($q) use ($search) {
                foreach ($this->searchColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        })->with($this->relations)->paginate(getPaginate());

        // $data = Subregion::query()
        //     ->when($this->search, function ($query) {
        //         $search = strtolower($this->search);
        //         $query->where(function ($q) use ($search) {
        //             foreach ($this->searchColumns as $column) {
        //                 $q->orWhere($column, 'like', '%' . $search . '%');
        //             }
        //         });
        //     })->paginate(getPaginate());

        return view('livewire.transportation.companies', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}