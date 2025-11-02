<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Cities extends Component
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
        $this->mountWithCustomColumns(City::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'city');
    }

    public function render()
    {
        $data = City::query()->with($this->relations)->search($this->search)->paginate(getPaginate());
        foreach ($data as $city) {
            $city['states'] = $city->states();
        }
        return view('livewire.cities', [
            'data' => $data,
            'totalCount' => City::count(),
        ]);
    }
}