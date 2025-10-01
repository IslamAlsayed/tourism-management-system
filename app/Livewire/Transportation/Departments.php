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
        $this->mountWithCustomColumns(TransportationCompanyDepartment::class, 5);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = TransportationCompanyDepartment::count();
        // $data = $this->scopeSearch(Subregion::class);

        $data = TransportationCompanyDepartment::query()->when($this->search, function ($query) {
            $search = strtolower($this->search);

            $items1 = TransportationCompany::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new TransportationCompany())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $items2 = Country::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new Country())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $items3 = State::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new State())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $items4 = City::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new City())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $items5 = Region::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new Region())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $items6 = Subregion::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new Subregion())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $query->where(function ($q) use ($search, $items1, $items2, $items3, $items4, $items5, $items6) {
                $q->orWhereIn('company_id', $items1);
                $q->orWhereIn('country_id', $items2);
                $q->orWhereIn('state_id', $items3);
                $q->orWhereIn('city_id', $items4);
                $q->orWhereIn('region_id', $items5);
                $q->orWhereIn('subregion_id', $items6);

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

        return view('livewire.transportation.departments', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}