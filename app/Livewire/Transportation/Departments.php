<?php

namespace App\Livewire\Transportation;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Models\TransportationCompanyDepartment;

class Departments extends Component
{
    use WithPagination, CustomPagination, CustomColumns, HandlesCrudSafely;
    public $search = '';
    public $totalCount = '';
    public $message = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(TransportationCompanyDepartment::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'transportationCompanyDepartment');
    }

    public function render()
    {
        return view('livewire.transportation.departments', [
            'data' => TransportationCompanyDepartment::query()->with($this->relations)->search($this->search)->paginate(getPaginate()),
            'totalCount' => TransportationCompanyDepartment::count(),
        ]);
    }
}