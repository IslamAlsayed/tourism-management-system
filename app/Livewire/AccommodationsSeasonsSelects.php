<?php

namespace App\Livewire;

use App\Models\Season;
use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Models\Accommodation;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class AccommodationsSeasonsSelects extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterAccommodationId = '';
    public $isAccommodation = false;
    public $isLoading = false;
    public $accommodations = [];
    public $seasons = [];
    public $record = null;
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterAccommodationId($value)
    {
        if ($value) {
            $this->isLoading = true;
            $this->isAccommodation = false;
            $this->seasons = [];

            $this->seasons = Season::where('accommodation_id', $value)->orderBy('name')->get(['id', 'name']);
            $this->isAccommodation = true;
            $this->isLoading = false;
        } else {
            $this->isAccommodation = false;
            $this->isLoading = false;
            $this->seasons = [];
        }
    }

    public function mount($record = null)
    {
        $this->record = $record;
        $this->accommodations = Accommodation::orderBy('name')->get(['id', 'name']);

        // If editing, load the accommodation and seasons
        if ($record && $record->accommodation_id) {
            $this->filterAccommodationId = $record->accommodation_id;
            $this->isAccommodation = true;
            $this->seasons = Season::where('accommodation_id', $record->accommodation_id)
                ->orderBy('name')
                ->get(['id', 'name']);
        } else {
            $this->filterAccommodationId = '';
            $this->isAccommodation = false;
            $this->seasons = [];
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.accommodations-seasons-selects');
    }
}