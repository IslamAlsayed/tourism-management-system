<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TourGuideType;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;

class TourGuidesTypes extends Component
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
        $this->mountWithCustomColumns(TourGuideType::class);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = TourGuideType::count();
        $data = TourGuideType::query()->with($this->relations)->search($this->search)->paginate(getPaginate());

        return view('livewire.tour-guides-types', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}