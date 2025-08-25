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
    public $perPage = 50;
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

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->resetPage();
        // عرض جميع أعمدة المستخدمين المهمة
        $this->columns = [
            'name', 'email', 'phone', 'department', 'position', 
            'bio', 'address', 'city', 'country', 'postal_code',
            'website', 'linkedin', 'twitter', 'facebook', 'instagram',
            'github', 'company_name', 'industry', 'experience_years',
            'education_level', 'preferred_language', 'timezone',
            'date_of_birth', 'gender', 'marital_status', 'emergency_contact',
            'emergency_phone', 'skills', 'interests', 'created_at', 'updated_at'
        ];

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
            ->paginate($this->perPage);

        return view('livewire.dashboard.user-table', [
            'data' => $data,
            'totalCount' => $this->totalCount,
            'statusOptions' => $this->statusOptions,
        ]);
    }
}