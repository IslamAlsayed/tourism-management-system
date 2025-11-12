<?php

namespace App\Livewire;

use App\Models\AirTransport;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class AirTransports extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterType = '';
    public $filterServiceType = '';
    public $filterStatus = '';
    public $filterActive = '';
    public $filterInternational = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingFilterServiceType()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterActive()
    {
        $this->resetPage();
    }

    public function updatingFilterInternational()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(AirTransport::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'air_transport');
    }

    public function resetFilter()
    {
        $this->filterType = '';
        $this->filterServiceType = '';
        $this->filterStatus = '';
        $this->filterActive = '';
        $this->filterInternational = '';
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = AirTransport::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);

        if ($this->filterType) {
            $query->where('type', $this->filterType);
        }
        if ($this->filterServiceType) {
            $query->where('service_type', $this->filterServiceType);
        }
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }
        if ($this->filterActive != '') {
            $query->where('is_active', $this->filterActive);
        }
        if ($this->filterInternational != '') {
            $query->where('is_international', $this->filterInternational);
        }

        $this->applySorting($query);
        return view('livewire.air-transports', ['data' => $query->paginate(getPaginate()), 'totalCount' => $this->totalCount ?: AirTransport::count()]);
    }
}