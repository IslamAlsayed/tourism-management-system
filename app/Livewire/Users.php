<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use Illuminate\Support\Facades\Cache;
use App\Traits\CustomColumnsLivewireLegacy;

class Users extends Component
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

    public function refreshData()
    {
        // Force refresh by resetting pagination and clearing any cached data
        $this->resetPage();
        $this->reset('search', 'totalCount');

        // Re-render component to fetch fresh data from database
        $this->render();

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.data_refreshed_successfully')
        ]);
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(User::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, User::class, 'user');
        Cache::tags(['users'])->flush();
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
        $paginator = User::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        User::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.users'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], User::class, $cols, 'users');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], User::class, $cols, 'users', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    protected function getCacheKey()
    {
        return 'users_list:' . md5(json_encode([
            'search' => $this->search,
            'page' => request()->get('page', 1),
            'sort' => $this->sortField ?? null,
            'dir' => $this->sortDirection ?? null,
            'perPage' => getPaginate(),
            'role' => in_array(getActiveUser()->role, ['superadmin', 'admin']) ? 'admin' : 'user',
        ]));
    }

    public function render()
    {
        $cacheKey = $this->getCacheKey();
        $data = Cache::remember($cacheKey, now()->addMinutes(5), function () {
            $query = User::query();
            if (!getActiveUser()->role) {
                $query->where('role', '!=', 'superadmin');
            }
            $query->searchWithRelations(
                search: $this->search,
                selectedColumns: $this->columns,
                availableRelations: $this->relations
            );
            $this->applySorting($query);
            return $query->paginate(getPaginate());
        });

        return view('livewire.users', [
            'data' => $data,
            'totalCount' => $this->totalCount ?: User::count(),
            'selectedIds' => $this->selectedIds
        ]);
    }
}