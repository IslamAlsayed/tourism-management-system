<?php

namespace App\Livewire\Currencies;

use App\Models\Currency;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    public $search = '';
    public $totalCount = '';
    public $perPage = 50;
    public array $columns = [];

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
        $this->resetPage();
        $this->columns = ['id', 'name', 'name_ar', 'created_at', 'updated_at'];
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Currency::count();

        $data = Currency::query()
            ->when($this->search, function ($query) {
                $search = strtolower($this->search);
                $query->where(function ($q) use ($search) {
                    foreach ($this->columns as $column) {
                        $q->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            })
            ->paginate($this->perPage);

        return view('livewire.currencies.table', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }

    // Toggle active status for a region
    public function toggleActive($id)
    {
        $currency = Currency::find($id);
        if ($currency) {
            $currency->is_active = !$currency->is_active;
            $currency->save();
            session()->flash('message', __('تم تحديث حالة العملة بنجاح.'));
        }
    }
}