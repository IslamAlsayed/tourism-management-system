<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Countries extends Component
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
        $this->mountWithCustomColumns(Country::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'country');
    }

    public function render()
    {
        $query = Country::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $data = $this->paginate != 'all' ? $query->paginate(getPaginate()) : $query->get();
        foreach ($data as $country) {
            $country->states = $country->states();
            $country->cities = $country->cities();
        }
        $this->applySorting($query);
        return view('livewire.countries', ['data' => $data, 'totalCount' => $this->totalCount ?: Country::count()]);
    }
}