<?php

namespace App\Livewire\Accommodations;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Accommodation;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;

class Accommodations extends Component
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
        $this->mountWithCustomColumns(Accommodation::class, 5);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Accommodation::count();
        $data = $this->scopeSearch(Accommodation::class);

        // $data = Accommodation::query()
        //     ->when($this->search, function ($query) {
        //         $search = strtolower($this->search);
        //         $query->where(function ($q) use ($search) {
        //             foreach ($this->searchColumns as $column) {
        //                 $q->orWhere($column, 'like', '%' . $search . '%');
        //             }
        //         });
        //     })->paginate(getPaginate());

        return view('livewire.accommodations.accommodations', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}