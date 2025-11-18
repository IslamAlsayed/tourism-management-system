<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Restaurant;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Restaurants extends Component
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
        $this->mountWithCustomColumns(Restaurant::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'restaurant');
    }

    public function render()
    {
        $query = Restaurant::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $data = $this->paginate != 'all' ? $query->paginate(getPaginate()) : $query->get();
        foreach ($data as $restaurant) {
            $restaurant['states'] = $restaurant->states();
            $restaurant['cities'] = $restaurant->cities();
        }
        $this->applySorting($query);
        return view('livewire.restaurants', ['data' => $data, 'totalCount' => $this->totalCount ?: Restaurant::count()]);
    }
}