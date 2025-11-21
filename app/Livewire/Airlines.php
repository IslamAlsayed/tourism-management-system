<?php

namespace App\Livewire;

use App\Models\Airline;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Airlines extends Component
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
        $this->mountWithCustomColumns(Airline::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'airlines');
    }

    public function render()
    {
        $query = Airline::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.airlines', ['data' => $data, 'totalCount' => $this->totalCount ?: Airline::count()]);
    }
}