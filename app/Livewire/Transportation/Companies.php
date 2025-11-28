<?php

namespace App\Livewire\Transportation;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\WithSorting;
use App\Models\TransportationCompany;

class Companies extends Component
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
        $this->mountWithCustomColumns(TransportationCompany::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'transportationCompany');
    }

    public function render()
    {
        $query = TransportationCompany::query()->with($this->relations)->search($this->search);
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.transportation.companies', ['data' => $data, 'totalCount' => TransportationCompany::count()]);
    }
}