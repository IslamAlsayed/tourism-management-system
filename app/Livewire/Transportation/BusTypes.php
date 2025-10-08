<?php

namespace App\Livewire\Transportation;

use Livewire\Component;
use App\Models\TransportationBusType;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Models\TransportationCompany;

class BusTypes extends Component
{
    use WithPagination, CustomPagination, CustomColumns;
    public $search = '';
    public $totalCount = '';

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
        $this->mountWithCustomColumns(TransportationBusType::class);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = TransportationBusType::count();
        $data = TransportationBusType::query()->with($this->relations)->search($this->search)->paginate(getPaginate());

        return view('livewire.transportation.bus-types', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}