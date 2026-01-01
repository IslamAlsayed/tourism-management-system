<?php

namespace App\Livewire;

use App\Models\Room;
use App\Models\Season;
use Livewire\Component;
use App\Models\Currency;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Rooms extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterSeasonId = '';
    public $seasons = [];
    public $filterCurrencyId = '';
    public $currencies = [];
    public $filterStatus = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterSeasonId()
    {
        $this->resetPage();
    }

    public function updatingFilterCurrencyId()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Room::class);
        $this->seasons = Season::with('accommodation')->get()
            ->mapWithKeys(function ($season) {
                $label = $season->name . ' (' . optional($season->accommodation)->name . ')';
                return [$season->id => $label];
            })->toArray();
        $this->currencies = Currency::whereIn('id', Room::pluck('currency_id'))->get(['code', 'name', 'id'])->toArray();
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'room');
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
        $paginator = Room::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Room::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.rooms'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], Room::class, $cols, 'rooms');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], Room::class, $cols, 'rooms', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterSeasonId', 'filterCurrencyId', 'filterStatus']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = Room::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        if ($this->filterSeasonId && $this->filterSeasonId != 'all') {
            $query->where('season_id', $this->filterSeasonId);
        }
        if ($this->filterCurrencyId && $this->filterCurrencyId != 'all') {
            $query->where('currency_id', $this->filterCurrencyId);
        }
        if ($this->filterStatus && $this->filterStatus['payload']['value'] !== 'all') {
            $query->where('is_active', $this->filterStatus['payload']['value'] === 'active' ? true : false);
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.rooms', ['data' => $data, 'totalCount' => $this->totalCount ?: Room::count(), 'selectedIds' => $this->selectedIds]);
    }
}