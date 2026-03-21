<?php

namespace Modules\Restaurants\Livewire;

use Livewire\Component;
use Modules\Restaurants\Entities\Restaurant;
use Modules\Restaurants\Entities\RestaurantType;
use Modules\Geography\Entities\Region;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class Restaurants extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;
    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterActive = '';
    public $filterTypeId = '';
    public $filterRegionId = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterActive($value)
    {
        $this->filterActive = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterTypeId($value)
    {
        $this->filterTypeId = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterRegionId($value)
    {
        $this->filterRegionId = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Restaurant::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Restaurant::class, 'restaurant');
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
        $paginator = Restaurant::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Restaurant::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(Restaurant::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.restaurants'), 'count' => $count]),
        ]);
    }

    public function forceDeleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Restaurant::whereIn('id', $this->selectedIds)->forceDelete();
        $this->resetAutoIncrementIfEmpty(Restaurant::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');

        $this->dispatch('show-toast', [
            'type' => 'success',
            // Re-using the deleted message since there isn't a specific force_deleted_count message easily available without changing lang files
            'message' => __('messages.type_deleted_count', ['type' => __('main.restaurants'), 'count' => $count]), 
        ]);
        $this->dispatch('refresh-page');
    }

    public function activateSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Restaurant::whereIn('id', $this->selectedIds)->update(['is_active' => true]);
        $count = count($this->selectedIds);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => $count . ' ' . __('main.restaurants') . ' ' . __('main.activated'),
        ]);
    }

    public function deactivateSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Restaurant::whereIn('id', $this->selectedIds)->update(['is_active' => false]);
        $count = count($this->selectedIds);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => $count . ' ' . __('main.restaurants') . ' ' . __('main.deactivated'),
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterActive', 'filterTypeId', 'filterRegionId']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], Restaurant::class, $cols, 'restaurants');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], Restaurant::class, $cols, 'restaurants', $extension);
    }

    public function render()
    {
        $query = Restaurant::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);

        // Apply filters
        if ($this->filterActive && $this->filterActive !== 'all') {
            $query->where('is_active', $this->filterActive === 'active' ? true : false);
        }
        if ($this->filterTypeId && $this->filterTypeId !== 'all') {
            $query->where('type_id', $this->filterTypeId);
        }
        if ($this->filterRegionId && $this->filterRegionId !== 'all') {
            $query->where('region_id', $this->filterRegionId);
        }

        $this->applySorting($query);
        $data = $query->paginate(getPaginate());

        // Pass filter options to view
        $types = RestaurantType::where('is_active', true)->orderBy('name')->pluck('name', 'id');
        $regions = Region::orderBy('name')->pluck('name', 'id');

        return view('restaurants::livewire.restaurants', [
            'data' => $data,
            'totalCount' => $this->totalCount ?: Restaurant::count(),
            'selectedIds' => $this->selectedIds,
            'types' => $types,
            'regions' => $regions,
        ]);
    }
}

