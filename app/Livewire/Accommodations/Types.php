<?php

namespace App\Livewire\Accommodations;

use App\Models\Type;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Accommodation;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\WithSorting;

class Types extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting;

    public $search = '';
    public $totalCount = '';
    public $type = '';

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

    public function mount($type)
    {
        $this->type = $type;
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Accommodation::class);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $typeModel = Type::where('name', 'like', '%' . $this->type . '%')->first();
        $query = Accommodation::with('type')->where('type_id', $typeModel?->id ?? 0);
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        $this->totalCount = $data->total();
        return view('livewire.accommodations.types', ['data' => $data, 'totalCount' => $this->totalCount]);
    }
}