<?php

namespace App\Livewire;

use App\Models\Jeep;
use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use Illuminate\Support\Facades\Cache;
use App\Traits\CustomColumnsLivewireLegacy;

class Jeeps extends Component
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
        $this->resetPage();
        $this->reset('search', 'totalCount');
        $this->render();

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.data_refreshed_successfully')
        ]);
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Jeep::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Jeep::class, 'jeep');
        Cache::tags(['jeeps'])->flush();
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
        $paginator = Jeep::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Jeep::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.jeeps'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], Jeep::class, $cols, 'jeeps');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], Jeep::class, $cols, 'jeeps', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    protected function getCacheKey()
    {
        return 'jeeps_list:' . md5(json_encode([
            'search' => $this->search,
            'page' => request()->get('page', 1),
            'sort' => $this->sortField ?? null,
            'dir' => $this->sortDirection ?? null,
            'perPage' => getPaginate(),
            'user_id' => getActiveUserId(),
        ]));
    }

    public function render()
    {
        $cacheKey = $this->getCacheKey();
        $data = Cache::remember($cacheKey, now()->addMinutes(1), function () {
            $query = Jeep::query(); // Add relations if needed: with('currency', 'country')

            $query->searchWithRelations(
                search: $this->search,
                selectedColumns: $this->columns,
                availableRelations: $this->relations ?? [] // Should define relations in Jeep model
            );
            $this->applySorting($query);
            return $query->paginate(getPaginate());
        });

        return view('livewire.jeeps', [
            'data' => $data,
            'totalCount' => $this->totalCount ?: Jeep::count(),
            'selectedIds' => $this->selectedIds
        ]);
    }
}
