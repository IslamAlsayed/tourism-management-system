<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomPagination;

class Table extends Component
{
    use WithPagination, CustomPagination;
    public $search = '';
    public $totalCount = '';
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
        $this->mountWithCustomPagination();
        $this->columns = [
            'name',
            'email',
            'password',
            'bio',
            'phone',
            'first_name',
            'last_name',
            'phone',
            'mobile',
            'address',
            'user_code',
            'employee_id',
            'hire_date',
            'department',
            'position',
            'preferred_language',
            'timezone',
            'preferences',
            'email_verified_at',
            'is_admin',
            'avatar_url',
            'is_active',
            'is_verified',
            'force_password_change',
            'last_login_at',
            'last_login_ip',
            'notes',
            'created_by',
            'updated_by',
        ];
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
            })->paginate(getPaginate());

        return view('livewire.users.table', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }
}