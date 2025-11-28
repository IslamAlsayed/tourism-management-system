<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumns;
use App\Models\TourGuideReview;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class TourGuidesReviews extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely;
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
        $this->mountWithCustomColumns(TourGuideReview::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'tourGuideReview');
    }

    public function render()
    {
        $query = TourGuideReview::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.tour-guides-reviews', ['data' => $data, 'totalCount' => $this->totalCount ?: TourGuideReview::count()]);
    }
}