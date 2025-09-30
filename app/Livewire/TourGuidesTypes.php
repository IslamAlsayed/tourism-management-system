<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use Livewire\Component;
use App\Models\Currency;
use App\Models\Subregion;
use Livewire\WithPagination;
use App\Models\TourGuideType;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;

class TourGuidesTypes extends Component
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
        $this->mountWithCustomColumns(TourGuideType::class, 5);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = TourGuideType::count();
        // $data = $this->scopeSearch(TourGuideType::class);

        $data = TourGuideType::query()->when($this->search, function ($query) {
            $search = strtolower($this->search);

            $items1 = Currency::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new Currency())->getFillable() as $column) {
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

            $items4 = City::query()->where('id', '<=', City::count() / 3)->when($this->search, function ($query) {
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

            $items7 = City::query()->where('id', '>=', (City::count() / 3))->where('id', '<=', City::count() - ((City::count() / 3) * 2))->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new City())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $items8 = City::query()->where('id', '>=', City::count() - ((City::count() / 3) * 2))->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new City())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $query->where(function ($q) use ($search, $items1, $items2, $items3, $items4, $items5, $items6, $items7, $items8) {
                $q->orWhereIn('currency_id', $items1);
                $q->orWhereIn('country_id', $items2);
                $q->orWhereIn('state_id', $items3);
                $q->orWhereIn('city_id', $items4);
                $q->orWhereIn('city_id', $items7);
                $q->orWhereIn('city_id', $items8);
                $q->orWhereIn('region_id', $items5);
                $q->orWhereIn('subregion_id', $items6);

                foreach ($this->searchColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        })->with($this->relations)->paginate(getPaginate());

        // $data = TourGuideType::query()
        //     ->when($this->search, function ($query) {
        //         $search = strtolower($this->search);
        //         $query->where(function ($q) use ($search) {
        //             foreach ($this->searchColumns as $column) {
        //                 $q->orWhere($column, 'like', '%' . $search . '%');
        //             }
        //         });
        //     })->paginate(getPaginate());

        return view('livewire.tour-guides-types', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}