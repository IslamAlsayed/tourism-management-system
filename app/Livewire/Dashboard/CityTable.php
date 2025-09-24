<?php

namespace App\Livewire\Dashboard;

use App\Models\City;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomPagination;

class CityTable extends Component
{
    use WithPagination, CustomPagination;
    public $search = '';
    public $totalCount = '';
    public array $columns = [];

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
        $this->resetPage();
        $this->columns = ['id', 'name', 'country_id', 'created_at', 'updated_at'];
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = City::count();

        $data = City::query()
            ->when($this->search, function ($query) {
                $search = strtolower($this->search);
                $query->where(function ($q) use ($search) {
                    foreach ($this->columns as $column) {
                        $q->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            })->with('country')
            ->paginate(getPaginate());

        return view('livewire.dashboard.city-table', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}