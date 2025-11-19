<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subregion;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Subregions extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely;
    public $search = '';
    public $totalCount = '';
    public $message = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Subregion::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'subregion');
    }

    public function render()
    {
        $query = Subregion::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $data = $query->paginate(getPaginate());
        $this->applySorting($query);
        return view('livewire.subregions', ['data' => $data, 'totalCount' => $this->totalCount ?: Subregion::count()]);
    }
}