<?php

namespace Modules\Cruises\Livewire;

use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\CustomColumnsLivewireLegacy;
use Modules\Cruises\Entities\CruiseSupplier;

class SupplierList extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public string $search = '';
    public string $filterIsActive = '';
    public string $filterType = '';
    public $totalCount = '';

    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function mount(): void
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(CruiseSupplier::class);
        $this->resetPage();
    }

    public function destroy(int $id): void
    {
        $this->safeDestroy($id, CruiseSupplier::class, 'cruise-supplier');
    }

    public function deleteSelected(): void
    {
        if (empty($this->selectedIds)) {
            return;
        }

        CruiseSupplier::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(CruiseSupplier::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type'    => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.cruise-suppliers'), 'count' => $count]),
        ]);
    }

    public function render()
    {
        $query = CruiseSupplier::query();

        if ($this->search) {
            $query->searchWithRelations(
                search: $this->search,
                selectedColumns: $this->columns,
                availableRelations: $this->relations
            );
        }

        if ($this->filterIsActive && $this->filterIsActive !== 'all') {
            $query->where('is_active', $this->filterIsActive === 'active');
        }

        if ($this->filterType && $this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        $this->applySorting($query);

        $data = $query->paginate(getPaginate());

        return view('cruises::livewire.supplier-list', [
            'data'        => $data,
            'totalCount'  => $this->totalCount ?: CruiseSupplier::count(),
            'selectedIds' => $this->selectedIds,
        ]);
    }
}
