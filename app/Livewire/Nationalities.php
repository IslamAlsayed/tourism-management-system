<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;
use App\Models\Nationality;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;

class Nationalities extends Component
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
        $this->mountWithCustomColumns(Nationality::class, 5);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Nationality::count();
        // $data = $this->scopeSearch(Nationality::class);

        $data = Nationality::query()->when($this->search, function ($query) {
            $search = strtolower($this->search);

            $items1 = Country::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->orWhere('name', 'like', '%' . $this->search . '%');
                });
            })->get('id');

            $query->where(function ($q) use ($search, $items1) {
                $q->orWhereIn('country_id', $items1);

                foreach ($this->searchColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        })->with($this->relations)->paginate(getPaginate());

        // $data = Nationality::query()
        //     ->when($this->search, function ($query) {
        //         $search = strtolower($this->search);
        //         $query->where(function ($q) use ($search) {
        //             foreach ($this->searchColumns as $column) {
        //                 $q->orWhere($column, 'like', '%' . $search . '%');
        //             }
        //         });
        //     })->paginate(getPaginate());

        return view('livewire.nationalities', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}