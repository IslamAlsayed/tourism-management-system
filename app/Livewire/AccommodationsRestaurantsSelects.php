<?php

namespace App\Livewire;

use App\Models\Season;
use Livewire\Component;
use App\Models\Restaurant;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Models\Accommodation;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class AccommodationsRestaurantsSelects extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterType = '';
    public $isLoading = false;
    public $accommodations = [];
    public $restaurants = [];
    public $record = null;
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterType($value)
    {
        if ($value == 'accommodation') {
            $this->isLoading = true;
            $this->accommodations = Accommodation::orderBy('name')->get(['id', 'name']);
            $this->restaurants = [];
            $this->isLoading = false;
        } elseif ($value == 'restaurant') {
            $this->isLoading = true;
            $this->restaurants = Restaurant::orderBy('name')->get(['id', 'name']);
            $this->accommodations = [];
            $this->isLoading = false;
        }
    }

    public function mount($record = null)
    {
        $this->record = $record;
        $this->filterType = in_array(request()->type, ['accommodation', 'restaurant']) ? request()->type : 'accommodation';
        $this->accommodations = Accommodation::orderBy('name')->get(['id', 'name']);
        $this->restaurants = Restaurant::orderBy('name')->get(['id', 'name']);

        // If editing, load the accommodation and seasons
        if ($record && $record->accommodation_id) {
            $this->restaurants = Season::where('accommodation_id', $record->accommodation_id)->orderBy('name')->get(['id', 'name']);
        } else {
            $this->restaurants = [];
        }

        if ($record) {
            if ($record->model_type === Restaurant::class) {
                $this->filterType = 'restaurant';
                $this->restaurants = Restaurant::orderBy('name')->get(['id', 'name']);
            } elseif ($record->model_type === Accommodation::class) {
                $this->filterType = 'accommodation';
                $this->accommodations = Accommodation::orderBy('name')->get(['id', 'name']);
            }
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.accommodations-restaurants-selects');
    }
}