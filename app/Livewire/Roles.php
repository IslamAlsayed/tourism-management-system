<?php

namespace App\Livewire;

use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\ExportsData;
use App\Traits\HandlesCrudSafely;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Roles extends Component
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
        $this->mountWithCustomColumns(Role::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Role::class, 'role');
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
        $paginator = Role::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Role::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.roles'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], Role::class, $cols, 'roles');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], Role::class, $cols, 'roles', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function render()
    {
        $query = Role::query();
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.roles', ['data' => $data, 'totalCount' => $this->totalCount ?: Role::count(), 'selectedIds' => $this->selectedIds]);
    }
}
