<?php

namespace App\Livewire\Transportation;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\WithSorting;
use App\Models\TransportationCarRoute;
use App\Models\TransportationCarRoutePrice;

class Vehicles extends Component
{
    use WithPagination, CustomPagination, CustomColumns, HandlesCrudSafely, WithSorting;
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