<?php

namespace App\Livewire;

use App\Models\State;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumns;
use App\Traits\HandlesCrudSafely;
use App\Traits\CustomPagination;

class States extends Component
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
        $this->mountWithCustomColumns(State::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'state');
    }

    public function render()
    {
        $query = State::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $data = $query->paginate(getPaginate());
        foreach ($data as $state) {
            $state['cities'] = $state->cities();
        }
        $this->applySorting($query);
        return view('livewire.states', ['data' => $data, 'totalCount' => $this->totalCount ?: State::count()]);
    }
}