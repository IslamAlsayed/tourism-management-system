<?php

namespace App\Livewire\Transportation;

use App\Models\Currency;
use App\Models\TransportationBusType;
use App\Models\TransportationCarRoutePrice;
use Livewire\Component;
use App\Models\TransportationCarRoute;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Models\TransportationCompany;

class Vehicles extends Component
{
    use WithPagination, CustomPagination, CustomColumns;
    public $search = '';
    public $totalCount = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPaginate()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(TransportationCarRoutePrice::class);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
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
        $data = TransportationCarRoutePrice::query()->with($this->relations)->search($this->search)->paginate(getPaginate());

        [$this->allColumns, $this->relations, $this->columns] = $this->removeValueFromArrays('car_route', ...[$this->allColumns, $this->relations, $this->columns]);


        return view('livewire.transportation.vehicles', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
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