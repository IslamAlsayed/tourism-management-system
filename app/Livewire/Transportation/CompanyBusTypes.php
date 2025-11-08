<?php

namespace App\Livewire\Transportation;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\WithSorting;
use App\Models\TransportationCompanyBusType;

class CompanyBusTypes extends Component
{
    use WithPagination, CustomPagination, CustomColumns, HandlesCrudSafely, WithSorting;
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
        $this->mountWithCustomColumns(TransportationCompanyBusType::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'transportationCompanyBusType');
    }

    public function render()
    {
        $query = TransportationCompanyBusType::query()->with($this->relations)->search($this->search);
        $this->applySorting($query);
        return view('livewire.transportation.company-bus-types', ['data' => $query->paginate(getPaginate()), 'totalCount' => TransportationCompanyBusType::count()]);
    }
}