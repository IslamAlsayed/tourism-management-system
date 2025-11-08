<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Nationality;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Nationalities extends Component
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
        $this->mountWithCustomColumns(Nationality::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'nationality');
    }

    public function render()
    {
        $query = Nationality::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        foreach ($data as $nationality) {
            $nationality['states'] = $nationality->states();
            $nationality['cities'] = $nationality->cities();
        }
        return view('livewire.nationalities', ['data' => $data, 'totalCount' => $this->totalCount ?: Nationality::count()]);
    }
}