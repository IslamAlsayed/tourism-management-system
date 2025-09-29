<?php

namespace App\Livewire;

use App\Models\Region;
use Livewire\Component;
use App\Models\Subregion;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;

class Subregions extends Component
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
        $this->mountWithCustomColumns(Subregion::class, 5);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Subregion::count();
        // $data = $this->scopeSearch(Subregion::class);

        $data = Subregion::query()->when($this->search, function ($query) {
            $search = strtolower($this->search);

            $items1 = Region::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->orWhere('name', 'like', '%' . $this->search . '%');
                });
            })->get('id');

            $query->where(function ($q) use ($search, $items1) {
                $q->orWhereIn('region_id', $items1);

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

        return view('livewire.subregions', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}