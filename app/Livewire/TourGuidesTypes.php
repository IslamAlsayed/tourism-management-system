<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TourGuideType;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class TourGuidesTypes extends Component
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
        $this->mountWithCustomColumns(TourGuideType::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'tourGuideType');
    }

    public function render()
    {
        $data = TourGuideType::query()->with($this->relations)->search($this->search)->paginate(getPaginate());
        foreach ($data as $tourGuideType) {
            $tourGuideType['states'] = $tourGuideType->states();
            $tourGuideType['cities'] = $tourGuideType->cities();
        }
        return view('livewire.tour-guides-types', [
            'data' => $data,
            'totalCount' => TourGuideType::count(),
        ]);
    }
}