<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Models\TourGuideReview;
use App\Traits\CustomPagination;

class TourGuidesReviews extends Component
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
        $this->mountWithCustomColumns(TourGuideReview::class, 5);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = TourGuideReview::count();
        $data = TourGuideReview::query()->with($this->relations)->search($this->search)->paginate(getPaginate());

        return view('livewire.tour-guides-reviews', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}