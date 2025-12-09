<?php

namespace App\Livewire\Accommodations;

use App\Models\AccommodationRoomRate;
use App\Models\AccommodationMealRate;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class Rates extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $rateType = 'room';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedRateType()
    {
        $this->resetPage();
        // Re-mount columns and relations for the new rate type
        $modelClass = $this->rateType === 'room' ? AccommodationRoomRate::class : AccommodationMealRate::class;
        $this->mountWithCustomColumns($modelClass);
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $modelClass = $this->rateType === 'room' ? AccommodationRoomRate::class : AccommodationMealRate::class;
        $this->mountWithCustomColumns($modelClass);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $modelType = $this->rateType === 'room' ? 'accommodation_room_rate' : 'accommodation_meal_rate';
        $this->safeDestroy($id, $modelType);
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
        $modelClass = $this->rateType === 'room' ? AccommodationRoomRate::class : AccommodationMealRate::class;
        $paginator = $modelClass::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        $modelClass = $this->rateType === 'room' ? AccommodationRoomRate::class : AccommodationMealRate::class;
        $modelClass::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $typeName = $this->rateType === 'room' ? __('main.room_rates') : __('main.meal_rates');
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => $typeName, 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $modelClass = $this->rateType === 'room' ? AccommodationRoomRate::class : AccommodationMealRate::class;
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $fileName = $this->rateType === 'room' ? 'room_rates' : 'meal_rates';
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], $modelClass, $cols, $fileName);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $modelClass = $this->rateType === 'room' ? AccommodationRoomRate::class : AccommodationMealRate::class;
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $fileName = $this->rateType === 'room' ? 'room_rates' : 'meal_rates';
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], $modelClass, $cols, $fileName, $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'rateType']);
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        if ($this->rateType === 'room') {
            $query = AccommodationRoomRate::with(['accommodation', 'season', 'roomType']);
            $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations ?? []);
            $this->applySorting($query);
            $data = $query->paginate(getPaginate());
            $totalCount = $this->totalCount ?: AccommodationRoomRate::count();
        } else {
            $query = AccommodationMealRate::with(['accommodation', 'season', 'mealType']);
            $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations ?? []);
            $this->applySorting($query);
            $data = $query->paginate(getPaginate());
            $totalCount = $this->totalCount ?: AccommodationMealRate::count();
        }

        return view('livewire.accommodations.rates', ['data' => $data, 'totalCount' => $totalCount, 'selectedIds' => $this->selectedIds]);
    }
}