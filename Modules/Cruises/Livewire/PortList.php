<?php

namespace Modules\Cruises\Livewire;

use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\CustomColumnsLivewireLegacy;
use Modules\Cruises\Entities\CruisePort;

class PortList extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(CruisePort::class);
        // Default columns to display if custom columns aren't set
        if (empty($this->columns)) {
            $this->columns = ['id', 'name', 'type', 'country_id', 'city_id'];
        }
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, CruisePort::class, 'port');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        CruisePort::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(CruisePort::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.ports'), 'count' => $count]),
        ]);
    }

    public function render()
    {
        $query = CruisePort::with(['city', 'country']);
        
        if ($this->search) {
            $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: []);
        }

        $this->applySorting($query);
        
        $data = $query->paginate(getPaginate());
        
        return view('cruises::livewire.port-list', [
            'data' => $data, 
            'totalCount' => $this->totalCount ?: CruisePort::count(), 
            'selectedIds' => $this->selectedIds
        ]);
    }
}
