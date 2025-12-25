<?php

namespace App\Livewire\Transportation;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use App\Models\TransportationCarRoute;
use App\Models\TransportationCarRoutePrice;

class Vehicles extends Component
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
        $this->mountWithCustomColumns(TransportationCarRoute::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'transportationCarRoute');
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
        $paginator = TransportationCarRoute::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        TransportationCarRoute::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('transportation.car_routes'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], TransportationCarRoute::class, $cols, 'transportation_car_routes');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], TransportationCarRoute::class, $cols, 'transportation_car_routes', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function render()
    {
        $extraCols = ['route_ar', 'route'];
        foreach ($extraCols as $col) {
            if (!in_array($col, $this->allColumns)) {
                array_unshift($this->allColumns, $col);
            }
        }
        $this->totalCount = TransportationCarRoutePrice::count();
        $query = TransportationCarRoutePrice::query()->with($this->relations)->search($this->search);
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        [$this->allColumns, $this->relations, $this->columns] = $this->removeValueFromArrays('car_route', ...[$this->allColumns, $this->relations, $this->columns]);
        return view('livewire.transportation.vehicles', ['data' => $data, 'totalCount' => $this->totalCount]);
    }

    private function removeValueFromArrays($value, array ...$arrays)
    {
        foreach ($arrays as &$array) {
            if (($key = array_search($value, $array)) !== false) {
                unset($array[$key]);
                $array = array_values($array); // لإعادة الترتيب
            }
        }

        return $arrays;
    }
}