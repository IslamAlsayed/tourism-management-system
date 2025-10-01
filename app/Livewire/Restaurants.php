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
        // $data = $this->scopeSearch(Restaurant::class);

        $data = Restaurant::query()->when($this->search, function ($query) {
            $search = strtolower($this->search);

            $items1 = Country::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new Country())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $items2 = City::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new City())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $items3 = Region::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new Region())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $items4 = Subregion::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new Subregion())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $query->where(function ($q) use ($search, $items1, $items2, $items3, $items4) {
                $q->orWhereIn('country_id', $items1);
                $q->orWhereIn('city_id', $items2);
                $q->orWhereIn('region_id', $items3);
                $q->orWhereIn('subregion_id', $items4);

                foreach ($this->searchColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        })->with($this->relations)->paginate(getPaginate());

        // $data = Restaurant::query()
        //     ->when($this->search, function ($query) {
        //         $search = strtolower($this->search);
        //         $query->where(function ($q) use ($search) {
        //             foreach ($this->searchColumns as $column) {
        //                 $q->orWhere($column, 'like', '%' . $search . '%');
        //             }
        //         });
        //     })->paginate(getPaginate());

        // dd($data->toArray());

        return view('livewire.restaurants', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}