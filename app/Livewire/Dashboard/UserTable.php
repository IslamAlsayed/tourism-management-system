<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserTable extends Component
{
    use WithPagination;
    public $search = '';
    public $totalCount = '';
    public array $columns = [];
    public array $statusOptions = [];


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPaginate()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->resetPage();
        $this->columns = ['name', 'email', 'phone', 'department', 'position', 'created_at'];

        $this->statusOptions = array_merge(['all', ...User::select('is_active')->distinct()->get()->pluck('is_active')->toArray()]);
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = User::count();

        $data = User::query()
            ->when($this->search, function ($query) {
                $search = strtolower($this->search);
                $query->where(function ($q) use ($search) {
                    foreach ($this->columns as $column) {
                        $q->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            })
            ->paginate(20);

        return view('livewire.dashboard.user-table', [
            'data' => $data,
            'totalCount' => $this->totalCount,
            'statusOptions' => $this->statusOptions,
        ]);
    }
}