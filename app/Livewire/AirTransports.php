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

    public function updatingSearch()
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

    public function render()
    {
        $query = AirTransport::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);

        $this->applySorting($query);
        return view('livewire.air-transports', ['data' => $query->paginate(getPaginate()), 'totalCount' => $this->totalCount ?: AirTransport::count()]);
    }
}