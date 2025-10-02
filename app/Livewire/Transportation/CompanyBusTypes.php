<?php

namespace App\Livewire\Transportation;

use App\Models\TransportationBusType;
use Livewire\Component;
use App\Models\TransportationCompanyBusType;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Models\TransportationCompany;

class CompanyBusTypes extends Component
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
        $this->mountWithCustomColumns(TransportationCompanyBusType::class, 5);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = TransportationCompanyBusType::count();
        // $data = $this->scopeSearch(Subregion::class);

        $data = TransportationCompanyBusType::query()->when($this->search, function ($query) {
            $search = strtolower($this->search);

            $items1 = TransportationCompany::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new TransportationCompany())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $items2 = TransportationBusType::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    foreach ((new TransportationBusType())->getFillable() as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })->get('id');

            $query->where(function ($q) use ($search, $items1, $items2) {
                $q->orWhereIn('company_id', $items1);
                $q->orWhereIn('bus_type_id', $items2);

                foreach ($this->searchColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        })->with($this->relations)->paginate(getPaginate());

        // $data = Subregion::query()
        //     ->when($this->search, function ($query) {
        //         $search = strtolower($this->search);
        //         $query->where(function ($q) use ($search) {
        //             foreach ($this->searchColumns as $column) {
        //                 $q->orWhere($column, 'like', '%' . $search . '%');
        //             }
        //         });
        //     })->paginate(getPaginate());

        return view('livewire.transportation.bus-types', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}