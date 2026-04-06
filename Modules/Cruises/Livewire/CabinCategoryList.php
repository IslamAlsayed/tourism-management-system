<?php

namespace Modules\Cruises\Livewire;

use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\CustomColumnsLivewireLegacy;
use Modules\Cruises\Entities\CruiseCabinCategory;

class CabinCategoryList extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $filterIsActive = '';
    
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(CruiseCabinCategory::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, CruiseCabinCategory::class, 'cabin-category');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        CruiseCabinCategory::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(CruiseCabinCategory::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.cabin-categories'), 'count' => $count]),
        ]);
    }

    public function render()
    {
        $query = CruiseCabinCategory::query();
        
        if ($this->search) {
            $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        }

        if ($this->filterIsActive && $this->filterIsActive !== 'all') {
            $query->where('is_active', $this->filterIsActive === 'active');
        }

        $this->applySorting($query);
        
        $data = $query->paginate(getPaginate());
        
        return view('cruises::livewire.cabin-category-list', [
            'data' => $data, 
            'totalCount' => $this->totalCount ?: CruiseCabinCategory::count(), 
            'selectedIds' => $this->selectedIds
        ]);
    }
}
