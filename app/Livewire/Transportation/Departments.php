<?php

namespace App\Livewire\Transportation;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\WithSorting;
use App\Models\TransportationCompanyDepartment;

class Departments extends Component
{
    use WithPagination, CustomPagination, CustomColumns, HandlesCrudSafely, WithSorting;
    public $search = '';
    public $totalCount = '';
    public $message = [];
    protected $listeners = ['recordUpdated' => '$refresh'];

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
        $query = TransportationCompanyDepartment::query()->with($this->relations)->search($this->search);
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.transportation.departments', ['data' => $data, 'totalCount' => TransportationCompanyDepartment::count()]);
    }
}