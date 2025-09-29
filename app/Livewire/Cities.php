<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;

class Cities extends Component
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
        $this->mountWithCustomColumns(City::class, 5);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = City::count();
        // $data = $this->scopeSearch(City::class);

        $data = City::query()->when($this->search, function ($query) {
            $search = strtolower($this->search);

            $items1 = Country::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->orWhere('name', 'like', '%' . $this->search . '%');
                });
            })->get('id');

            $items2 = State::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->orWhere('name', 'like', '%' . $this->search . '%');
                });
            })->get('id');

            $query->where(function ($q) use ($search, $items1, $items2) {
                $q->orWhereIn('country_id', $items1);
                $q->orWhereIn('state_id', $items2);

                foreach ($this->searchColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        })->with($this->relations)->paginate(getPaginate());

        // $data = City::query()
        //     ->when($this->search, function ($query) {
        //         $search = strtolower($this->search);
        //         $query->where(function ($q) use ($search) {
        //             foreach ($this->searchColumns as $column) {
        //                 $q->orWhere($column, 'like', '%' . $search . '%');
        //             }
        //         });
        //     })->paginate(getPaginate());

        return view('livewire.cities', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}