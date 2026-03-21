<?php

namespace Modules\Restaurants\Livewire;

use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\ExportsData;
use App\Traits\HandlesCrudSafely;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Restaurants\Entities\RestaurantType;

class RestaurantTypes extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterActive = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterActive()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(RestaurantType::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, RestaurantType::class, 'type');
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
        $paginator = RestaurantType::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        RestaurantType::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(RestaurantType::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.types'), 'count' => $count]),
        ]);
    }

    public function forceDeleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        RestaurantType::whereIn('id', $this->selectedIds)->forceDelete();
        $this->resetAutoIncrementIfEmpty(RestaurantType::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.types'), 'count' => $count]),
        ]);
        $this->dispatch('refresh-page');
    }

    public function activateSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        RestaurantType::whereIn('id', $this->selectedIds)->update(['is_active' => true]);
        $count = count($this->selectedIds);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => $count . ' ' . __('main.types') . ' ' . __('main.activated'),
        ]);
    }

    public function deactivateSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        RestaurantType::whereIn('id', $this->selectedIds)->update(['is_active' => false]);
        $count = count($this->selectedIds);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => $count . ' ' . __('main.types') . ' ' . __('main.deactivated'),
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterActive']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = RestaurantType::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        if ($this->filterActive && $this->filterActive !== 'all') {
            $query->where('is_active', $this->filterActive === 'active' ? true : false);
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('restaurants::livewire.types', ['data' => $data, 'totalCount' => $this->totalCount ?: RestaurantType::count(), 'selectedIds' => $this->selectedIds]);
    }
}

