<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Currency;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Currencies extends Component
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
        $this->mountWithCustomColumns(Currency::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'currency');
    }

    public function render()
    {
        $query = Currency::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $this->applySorting($query);
        return view('livewire.currencies', ['data' => $query->paginate(getPaginate()), 'totalCount' => $this->totalCount ?: Currency::count()]);
    }
}