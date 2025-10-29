<?php

namespace App\Livewire\Transportation;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Models\TransportationBusType;

class BusTypes extends Component
{
    use WithPagination, CustomPagination, CustomColumns, HandlesCrudSafely;
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
        $this->mountWithCustomColumns(TransportationBusType::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'transportationBusType');
    }

    public function render()
    {
        return view('livewire.transportation.bus-types', [
            'data' => TransportationBusType::query()->with($this->relations)->search($this->search)->paginate(getPaginate()),
            'totalCount' => TransportationBusType::count(),
        ]);
    }
}