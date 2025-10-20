<?php

namespace App\Livewire;

use App\Models\Language;
use Livewire\Component;
use App\Models\TourGuide;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class TourGuides extends Component
{
    use WithPagination, CustomPagination, CustomColumns, HandlesCrudSafely;
    public $search = '';
    public $totalCount = '';
    public $message = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(TourGuide::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'tourGuide');
    }

    public function render()
    {
        return view('livewire.tour-guides', [
            'data' => TourGuide::query()->with($this->relations)->search($this->search)->paginate(getPaginate()),
            'totalCount' => TourGuide::count(),
        ]);
    }
}