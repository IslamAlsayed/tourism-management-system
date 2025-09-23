<?php

namespace App\Livewire\Accommodations;

use App\Models\Type;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Accommodation;
use App\Traits\CustomPagination;

class Types extends Component
{
    use WithPagination, CustomPagination;

    public $search = '';
    public $totalCount = '';
    public $type = '';
    public array $columns = [];

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
        $this->resetPage();
        $this->mountWithCustomPagination();
        $this->columns = ['id', 'name', 'name_ar', 'created_at', 'updated_at'];
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $typeModel = Type::where('name', 'like', '%' . $this->type . '%')->first();
        $data = Accommodation::with('type')->where('type_id', $typeModel?->id ?? 0)->paginate(getPaginate());
        $this->totalCount = $data->total();

        return view('livewire.accommodations.types', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}