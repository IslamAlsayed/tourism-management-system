<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;
use App\Models\Nationality;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;

class Nationalities extends Component
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
        $this->mountWithCustomColumns(Nationality::class);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Nationality::count();
        $data = Nationality::query()->with($this->relations)->search($this->search)->paginate(getPaginate());

        return view('livewire.nationalities', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}