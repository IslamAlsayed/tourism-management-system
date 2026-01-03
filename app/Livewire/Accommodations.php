<?php

namespace App\Livewire;

use App\Models\Meal;
use App\Models\Room;
use App\Models\Type;
use App\Models\Season;
use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Models\Accommodation;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Accommodations extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;
    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $types = [];
    public $filterTypeId = '';
    public $filterSeasonId = '';
    public $seasons = [];
    public $filterRoomId = '';
    public $rooms = [];
    public $filterMealId = '';
    public $meals = [];
    public $filterStatus = '';
    public $filter = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterTypeId($value)
    {
        // Handle Select2 array structure
        if (is_array($value) && isset($value['payload']['value'])) {
            $this->filterTypeId = $value['payload']['value'];
        }
        $this->resetPage();
    }

    public function updatingFilterSeasonId($value)
    {
        // Handle Select2 array structure
        if (is_array($value) && isset($value['payload']['value'])) {
            $this->filterSeasonId = $value['payload']['value'];
        }
        $this->resetPage();
    }

    public function updatingFilterStatus($value)
    {
        // Handle Select2 array structure
        if (is_array($value) && isset($value['payload']['value'])) {
            $this->filterStatus = $value['payload']['value'];
        }
        $this->resetPage();
    }
    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Accommodation::class);
        $this->types = Type::pluck('name', 'id')->toArray();
        $this->seasons = Season::pluck('name', 'id')->toArray();
        $this->rooms = Room::pluck('name', 'id')->toArray();
        $this->meals = Meal::pluck('name', 'id')->toArray();
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Accommodation::class, 'accommodation');
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
        $paginator = Accommodation::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Accommodation::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('accommodation.accommodations'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], Accommodation::class, $cols, 'accommodations');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], Accommodation::class, $cols, 'accommodations', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterTypeId', 'filterSeasonId', 'filterStatus']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = Accommodation::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        if ($this->filterTypeId && $this->filterTypeId !== 'all') {
            $query->where('type_id', $this->filterTypeId);
        }
        if ($this->filterSeasonId && $this->filterSeasonId['payload']['value'] !== 'all') {
            $query->whereHas('seasons', function ($q) {
                $q->where('id', $this->filterSeasonId['payload']['value']);
            });
        }
        if ($this->filterRoomId && $this->filterRoomId['payload']['value'] !== 'all') {
            $query->whereHas('rooms', function ($q) {
                $q->where('id', $this->filterRoomId['payload']['value']);
            });
        }
        if ($this->filterMealId && $this->filterMealId['payload']['value'] !== 'all') {
            $query->whereHas('meals', function ($q) {
                $q->where('id', $this->filterMealId['payload']['value']);
            });
        }
        if ($this->filterStatus && $this->filterStatus['payload']['value'] !== 'all') {
            $query->where('is_active', $this->filterStatus['payload']['value'] === 'active' ? true : false);
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.accommodations', ['data' => $data, 'totalCount' => $this->totalCount ?: Accommodation::count(), 'selectedIds' => $this->selectedIds]);
    }
}