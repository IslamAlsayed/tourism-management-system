<?php

namespace Modules\Cruises\Livewire;

use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\CustomColumnsLivewireLegacy;
use Modules\Cruises\Entities\Cruise;

class CruiseList extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $filterType = '';
    public $filterIsActive = '';
    
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Cruise::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Cruise::class, 'cruise');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Cruise::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(Cruise::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.cruises'), 'count' => $count]),
        ]);
    }

    public function render()
    {
        set_time_limit(120);

        $query = Cruise::query();
        
        // Search using the HasSearch trait functionality
        if ($this->search) {
            $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        }

        if ($this->filterType && $this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }
        
        if ($this->filterIsActive && $this->filterIsActive !== 'all') {
            $query->where('is_active', $this->filterIsActive === 'active');
        }

        $this->applySorting($query);
        
        $data = $query->paginate(getPaginate());
        
        return view('cruises::livewire.cruise-list', [
            'data' => $data, 
            'totalCount' => $this->totalCount ?: Cruise::count(), 
            'selectedIds' => $this->selectedIds
        ]);
    }
}
