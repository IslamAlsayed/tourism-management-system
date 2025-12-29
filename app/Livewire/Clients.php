<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use Illuminate\Support\Facades\Cache;
use App\Traits\CustomColumnsLivewireLegacy;

class Clients extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterClientGender = '';
    public $filterClientStatus = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterClientType()
    {
        $this->resetPage();
    }

    public function updatingFilterClientStatus()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Client::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'client');
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
        $paginator = Client::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Client::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('client.clients'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], Client::class, $cols, 'clients');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], Client::class, $cols, 'clients', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'filterClientGender', 'filterClientStatus']);
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public $getCacheKey = '';

    protected function getCacheKey()
    {
        return 'clients_list:' . md5(json_encode([
            'search' => $this->search,
            'page' => request()->get('page', 1),
            'sort' => $this->sortField ?? null,
            'dir' => $this->sortDirection ?? null,
            'perPage' => getPaginate(),
            'is_admin' => getActiveUser()->is_admin,
        ]));
    }

    public function render()
    {
        $cacheKey = $this->getCacheKey();
        $data = Cache::remember($cacheKey, now()->addMinutes(5), function () {
            $query = Client::query();
            if (!getActiveUser()->is_admin) {
                $query->where('is_admin', 0);
            }
            $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
            if ($this->filterClientGender && $this->filterClientGender['payload']['value'] !== 'all') {
                $query->where('gender', $this->filterClientGender);
            }
            if ($this->filterClientStatus && $this->filterClientStatus['payload']['value'] !== 'all') {
                $query->where('client_status', $this->filterClientStatus);
            }
            $this->applySorting($query);
            return $query->paginate(getPaginate());
        });
        return view('livewire.clients', ['data' => $data, 'totalCount' => $this->totalCount ?: Client::count(), 'selectedIds' => $this->selectedIds]);
    }
}