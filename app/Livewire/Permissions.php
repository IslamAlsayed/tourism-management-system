<?php

namespace App\Livewire;

use App\Models\Currency;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\ExportsData;
use App\Traits\HandlesCrudSafely;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;
    public $search = '';
    public $totalCount = '';
    public $message = [];
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Permission::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Permission::class, 'permission');
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
        $paginator = Permission::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Permission::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.permissions'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], Permission::class, $cols, 'permissions');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], Permission::class, $cols, 'permissions', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function render()
    {
        $query = Permission::query();
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.permissions', ['data' => $data, 'totalCount' => $this->totalCount ?: Permission::count(), 'selectedIds' => $this->selectedIds]);
    }
}
