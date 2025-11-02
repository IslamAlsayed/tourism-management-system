<?php

namespace App\Livewire;

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
    public $message = [];

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
        $data = TourGuide::query()->with($this->relations)->search($this->search)->paginate(getPaginate());
        foreach ($data as $tourGuides) {
            $tourGuides['states'] = $tourGuides->states();
            $tourGuides['cities'] = $tourGuides->cities();
        }
        return view('livewire.tour-guides', [
            'data' => $data,
            'totalCount' => TourGuide::count(),
        ]);
    }
}