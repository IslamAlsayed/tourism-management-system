<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Region;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use function Laravel\Prompts\search;

class Countries extends Component
{
    use WithPagination, CustomPagination, CustomColumns;
    // public $search = 'EGP';
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
        $this->mountWithCustomColumns(Country::class, 5);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Country::count();

        $data = Country::query()->when($this->search, function ($query) {
            $search = strtolower($this->search);

            $items1 = Country::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->orWhere('name', 'like', '%' . $this->search . '%');
                });
            })->get('id');

            $items2 = Currency::query()->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->orWhere('name', 'like', '%' . $this->search . '%');
                });
            })->get('id');

            $query->where(function ($q) use ($search, $items1, $items2) {
                $q->orWhereIn('country_id', $items1);
                $q->orWhereIn('currency_id', $items2);

                foreach ($this->searchColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        })->with($this->relations)->paginate(getPaginate());

        return view('livewire.countries', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}