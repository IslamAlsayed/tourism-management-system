<?php

namespace App\Livewire;

use App\Models\AccommodationRoomRate;
use App\Models\AccommodationMealRate;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class AccommodationsRates extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filter = 'rooms'; // rooms, meals
    public $allCount = 0;
    public $roomsCount = 0;
    public $mealsCount = 0;

    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
        
        // Re-initialize custom columns for the new model
        $modelClass = $this->filter === 'rooms' ? AccommodationRoomRate::class : AccommodationMealRate::class;
        $this->mountWithCustomColumns($modelClass);
    }

    public function refreshRates()
    {
        $this->roomsCount = AccommodationRoomRate::count();
        $this->mealsCount = AccommodationMealRate::count();
        $this->allCount = $this->roomsCount + $this->mealsCount;
    }

    public function mount()
    {
        $this->refreshRates();
        $this->mountWithCustomPagination();
        $modelClass = $this->filter === 'rooms' ? AccommodationRoomRate::class : AccommodationMealRate::class;
        $this->mountWithCustomColumns($modelClass);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $modelType = $this->filter === 'rooms' ? 'accommodation_room_rate' : 'accommodation_meal_rate';
        $this->safeDestroy($id, $modelType);
        $this->refreshRates();
    }

    public function updatedSelectPage($value)
    {
        $this->selectedIds = $value ? $this->currentPageDataIds()->toArray() : [];
    }

    public function updatedSelectedIds()
    {
        $this->selectPage = count($this->selectedIds) === $this->currentPageDataIds()->count();
    }

    protected function currentPageDataIds()
    {
        $modelClass = $this->filter === 'rooms' ? AccommodationRoomRate::class : AccommodationMealRate::class;
        $paginator = $modelClass::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        $modelClass = $this->filter === 'rooms' ? AccommodationRoomRate::class : AccommodationMealRate::class;
        $modelClass::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $typeName = $this->filter === 'rooms' ? __('main.room_rates') : __('main.meal_rates');
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => $typeName, 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $modelClass = $this->filter === 'rooms' ? AccommodationRoomRate::class : AccommodationMealRate::class;
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $fileName = $this->filter === 'rooms' ? 'room_rates' : 'meal_rates';
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], $modelClass, $cols, $fileName);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $modelClass = $this->filter === 'rooms' ? AccommodationRoomRate::class : AccommodationMealRate::class;
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $fileName = $this->filter === 'rooms' ? 'room_rates' : 'meal_rates';
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], $modelClass, $cols, $fileName, $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'filter']);
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        if ($this->filter === 'rooms') {
            $query = AccommodationRoomRate::with(['accommodation', 'season', 'room', 'currency']);
            $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations ?? []);
            $this->applySorting($query);
            $data = $query->paginate(getPaginate());
            $totalCount = $this->totalCount ?: AccommodationRoomRate::count();
        } else {
            $query = AccommodationMealRate::with(['accommodation', 'season', 'meal', 'currency']);
            $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations ?? []);
            $this->applySorting($query);
            $data = $query->paginate(getPaginate());
            $totalCount = $this->totalCount ?: AccommodationMealRate::count();
        }

        return view('livewire.accommodations-rates', ['data' => $data, 'totalCount' => $totalCount, 'selectedIds' => $this->selectedIds]);
    }
}