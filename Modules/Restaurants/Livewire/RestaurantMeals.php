<?php

namespace Modules\Restaurants\Livewire;

use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\ExportsData;
use App\Traits\HandlesCrudSafely;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Restaurants\Entities\RestaurantMeal;
use Modules\Localization\Entities\Currency;

class RestaurantMeals extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterCurrencyId = '';
    public $currencies = [];
    public $filterStatus = '';
    public $filterIsIncluded = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterCurrencyId($value)
    {
        $this->filterCurrencyId = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterStatus($value)
    {
        $this->filterStatus = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterIsIncluded($value)
    {
        $this->filterIsIncluded = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(RestaurantMeal::class);
        $this->currencies = Currency::whereIn('id', RestaurantMeal::pluck('currency_id'))->get(['code', 'name', 'id'])->toArray();
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, RestaurantMeal::class, 'meal');
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
        $paginator = RestaurantMeal::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        RestaurantMeal::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(RestaurantMeal::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.meals'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], RestaurantMeal::class, $cols, 'restaurant-meals');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], RestaurantMeal::class, $cols, 'restaurant-meals', $extension);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterCurrencyId', 'filterStatus', 'filterIsIncluded']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = RestaurantMeal::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        if ($this->filterCurrencyId && $this->filterCurrencyId !== 'all') {
            $query->where('currency_id', $this->filterCurrencyId);
        }
        if ($this->filterStatus && $this->filterStatus !== 'all') {
            $query->where('is_active', $this->filterStatus === 'active' ? true : false);
        }
        if ($this->filterIsIncluded && $this->filterIsIncluded !== 'all') {
            $query->where('is_included', $this->filterIsIncluded === 'yes' ? true : false);
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('restaurants::livewire.meals', ['data' => $data, 'totalCount' => $this->totalCount ?: RestaurantMeal::count(), 'selectedIds' => $this->selectedIds]);
    }
}

