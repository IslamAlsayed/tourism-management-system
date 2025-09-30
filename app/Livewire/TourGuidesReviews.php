<?php

namespace App\Livewire;

use App\Models\TourGuide;
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
        // $data = $this->scopeSearch(TourGuideReview::class);

        $data = TourGuideReview::query()->when($this->search, function ($query) {
            $search = strtolower($this->search);

            $items1 = TourGuide::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new TourGuide())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $query->where(function ($q) use ($search, $items1) {
                $q->orWhereIn('tour_guide_id', $items1);

                foreach ($this->searchColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        })->with($this->relations)->orderBy('rating', 'desc')->paginate(getPaginate());

        // $data = TourGuideReview::query()
        //     ->when($this->search, function ($query) {
        //         $search = strtolower($this->search);
        //         $query->where(function ($q) use ($search) {
        //             foreach ($this->searchColumns as $column) {
        //                 $q->orWhere($column, 'like', '%' . $search . '%');
        //             }
        //         });
        //     })->with('tour_guide')
        //     ->paginate(getPaginate());

        return view('livewire.tour-guides-reviews', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}