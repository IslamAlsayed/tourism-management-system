<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Currency;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Currencies extends Component
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
        $this->mountWithCustomColumns(Currency::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'currency');
    }

    public function render()
    {
        return view('livewire.currencies', [
            'data' => Currency::query()->with($this->relations)->search($this->search)->paginate(getPaginate()),
            'totalCount' => Currency::count(),
        ]);
    }
}