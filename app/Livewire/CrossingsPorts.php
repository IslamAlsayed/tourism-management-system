<?php

namespace App\Livewire;

use App\Models\CrossingPort;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class CrossingsPorts extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterType = '';
    public $filterStatus = '';
    public $filterOperational = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterOperational()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(CrossingPort::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'crossing_port');
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterType', 'filterStatus', 'filterOperational']);
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = CrossingPort::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);

        if ($this->filterType) {
            $query->where('type', $this->filterType);
        }
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }
        if ($this->filterOperational !== '') {
            $query->where('is_operational', $this->filterOperational);
        }
        $data = $this->paginate != 'all' ? $query->paginate(getPaginate()) : $query->get();
        $this->applySorting($query);
        return view('livewire.crossings-ports', ['data' => $data, 'totalCount' => $this->totalCount ?: CrossingPort::count()]);
    }
}