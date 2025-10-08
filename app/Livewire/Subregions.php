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
        $this->mountWithCustomColumns(Subregion::class);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Subregion::count();
        $data = Subregion::query()->with($this->relations)->search($this->search)->paginate(getPaginate());

        return view('livewire.subregions', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}