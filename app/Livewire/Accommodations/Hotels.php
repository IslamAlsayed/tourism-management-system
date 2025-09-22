<?php

namespace App\Livewire\Accommodations;

use App\Models\Hotel;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomPagination;

class Hotels extends Component
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
        $this->resetPage();
        $this->mountWithCustomPagination();
        $this->columns = ['id', 'name', 'name_ar', 'created_at', 'updated_at'];
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Hotel::count();

        $data = Hotel::query()
            ->when($this->search, function ($query) {
                $search = strtolower($this->search);
                $query->where(function ($q) use ($search) {
                    foreach ($this->columns as $column) {
                        $q->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            })
            ->paginate(getPaginate());

        return view('livewire.accommodations.hotels', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}