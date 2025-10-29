<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Models\TourGuideReview;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class TourGuidesReviews extends Component
{
    use WithPagination, CustomPagination, CustomColumns, HandlesCrudSafely;
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
        $this->mountWithCustomColumns(TourGuideReview::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'tourGuideReview');
    }

    public function render()
    {
        return view('livewire.tour-guides-reviews', [
            'data' => TourGuideReview::query()->with($this->relations)->search($this->search)->paginate(getPaginate()),
            'totalCount' => TourGuideReview::count(),
        ]);
    }
}