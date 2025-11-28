<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TourGuideType;
use App\Traits\WithSorting;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class TourGuidesTypes extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely;
    public $search = '';
    public $totalCount = '';
    public $message = [];
    protected $listeners = ['recordUpdated' => '$refresh'];


    public function clearMessages()
    {
        $this->reset('message');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(TourGuideType::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'tourGuideType');
    }

    public function render()
    {
        $query = TourGuideType::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        foreach ($data as $tourGuideType) {
            $tourGuideType['states'] = $tourGuideType->states();
            $tourGuideType['cities'] = $tourGuideType->cities();
        }
        return view('livewire.tour-guides-types', ['data' => $data, 'totalCount' => $this->totalCount ?: TourGuideType::count()]);
    }
}