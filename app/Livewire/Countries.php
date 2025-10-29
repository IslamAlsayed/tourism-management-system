<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Countries extends Component
{
    use WithPagination, CustomPagination, CustomColumns, HandlesCrudSafely;
    public $search = '';
    public $totalCount = '';
    public $message = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Country::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'country');
    }

    public function render()
    {
        $data = Country::query()->with($this->relations)->search($this->search)->paginate(getPaginate());
        foreach ($data as $country) {
            $country['states'] = $country->states();
            $country['cities'] = $country->cities();
        }
        return view('livewire.countries', [
            'data' => $data,
            'totalCount' => Country::count(),
        ]);
    }
}