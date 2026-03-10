<?php

namespace Modules\Restaurants\Livewire;

use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use Modules\Restaurants\Entities\RestaurantSupplement;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class RestaurantSupplements extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterPriceType = '';
    public $filterMandatory = '';
    public $filterActive = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterPriceType($value)
    {
        $this->filterPriceType = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterMandatory($value)
    {
        $this->filterMandatory = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterActive($value)
    {
        $this->filterActive = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(RestaurantSupplement::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, RestaurantSupplement::class, 'supplement');
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
        $paginator = RestaurantSupplement::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        RestaurantSupplement::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(RestaurantSupplement::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.supplements'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], RestaurantSupplement::class, $cols, 'restaurant-supplements');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], RestaurantSupplement::class, $cols, 'restaurant-supplements', $extension);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterPriceType', 'filterMandatory', 'filterActive']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = RestaurantSupplement::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        if ($this->filterPriceType && $this->filterPriceType !== 'all') {
            $query->where('price_type', $this->filterPriceType);
        }
        if ($this->filterMandatory && $this->filterMandatory !== 'all') {
            $query->where('is_mandatory', $this->filterMandatory === 'yes' ? true : false);
        }
        if ($this->filterActive && $this->filterActive !== 'all') {
            $query->where('is_active', $this->filterActive === 'active' ? true : false);
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('restaurants::livewire.supplements', ['data' => $data, 'totalCount' => $this->totalCount ?: RestaurantSupplement::count(), 'selectedIds' => $this->selectedIds]);
    }
}

