<?php

namespace Modules\Localization\Livewire;

use Livewire\Component;
use Modules\Localization\Entities\Timezone;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\CustomColumnsLivewireLegacy;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class Timezones extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;
    public $search = '';
    public $totalCount = '';
    public $filterActive = '';
    public $filterCountryCode = '';
    public $filterSupportsDst = '';
    public $message = [];
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function syncTimezones()
    {
        try {
            $exitCode = Artisan::call('geography:sync-timezones');
            $output = Artisan::output();

            if ($exitCode === 0) {
                $this->dispatch('show-toast', [
                    'type' => 'success',
                    'message' => 'Timezones have been synchronized successfully.'
                ]);
            } else {
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'message' => 'Failed to synchronize timezones.'
                ]);
                Log::error('Timezone Sync UI Trigger Failed: ' . $output);
            }
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Unexpected error occurred during synchronization.'
            ]);
            Log::error('Timezone Sync UI Trigger Error: ' . $e->getMessage());
        }
        $this->dispatch('refresh-page');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterActive($value)
    {
        $this->filterActive = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterCountryCode($value)
    {
        $this->filterCountryCode = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterSupportsDst($value)
    {
        $this->filterSupportsDst = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Timezone::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Timezone::class, 'timezone');
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
        $paginator = Timezone::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function activateSelected()
    {
        if (empty($this->selectedIds)) return;
        Timezone::whereIn('id', $this->selectedIds)->update(['is_active' => true]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deactivateSelected()
    {
        if (empty($this->selectedIds)) return;
        Timezone::whereIn('id', $this->selectedIds)->update(['is_active' => false]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function clearSelected()
    {
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Timezone::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(Timezone::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.timezones'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], Timezone::class, $cols, 'timezones');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], Timezone::class, $cols, 'timezones', $extension);
    }

    public function render()
    {
        $query = Timezone::query();

        if ($this->filterActive === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterActive === 'inactive') {
            $query->where('is_active', false);
        }

        if ($this->filterCountryCode) {
            $query->where('country_code', $this->filterCountryCode);
        }

        if ($this->filterSupportsDst === 'yes') {
            $query->where('supports_dst', true);
        } elseif ($this->filterSupportsDst === 'no') {
            $query->where('supports_dst', false);
        }

        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('localization::livewire.timezones', [
            'data' => $data, 
            'totalCount' => $query->count(), 
            'selectedIds' => $this->selectedIds
        ]);
    }
}

