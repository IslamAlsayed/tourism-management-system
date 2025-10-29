<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Restaurant;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Restaurants extends Component
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
        $this->mountWithCustomColumns(Restaurant::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'restaurant');
    }

    public function render()
    {
        return view('livewire.restaurants', [
            'data' => Restaurant::query()->with($this->relations)->search($this->search)->paginate(getPaginate()),
            'totalCount' => Restaurant::count(),
        ]);
    }
}