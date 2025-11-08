<?php

namespace App\Livewire\Accommodations;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Accommodation;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\WithSorting;

class Accommodations extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting;

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
        $this->mountWithCustomColumns(Accommodation::class);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Accommodation::count();
        $query = Accommodation::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $this->applySorting($query);
        return view('livewire.accommodations.accommodations', ['data' => $query->paginate(getPaginate()), 'totalCount' => $this->totalCount]);
    }
}