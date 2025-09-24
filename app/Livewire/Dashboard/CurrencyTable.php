<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Currency;
use Livewire\WithPagination;
use App\Traits\CustomPagination;

class CurrencyTable extends Component
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
        $this->columns = ['id', 'name', 'code', 'symbol', 'created_at', 'updated_at'];
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Currency::count();

        $data = Currency::query()
            ->when($this->search, function ($query) {
                $search = strtolower($this->search);
                $query->where(function ($q) use ($search) {
                    foreach ($this->columns as $column) {
                        $q->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            })->paginate(getPaginate());

        return view('livewire.dashboard.currency-table', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}