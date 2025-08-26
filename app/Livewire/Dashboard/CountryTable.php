<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Country;



class CountryTable extends Component
{
    use WithPagination;
    public $search = '';
    public $status = '';
    public $sort = '';
    public $totalCount = '';
    public $perPage = 50;
    public array $columns = [];
    public $countries = null;
    public $selected = [];

    public function mount($countries = null)
    {
        $this->resetPage();
        $this->columns = ['id', 'name', 'code', 'created_at', 'updated_at'];
        if ($countries) {
            $this->countries = $countries;
        }
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingPaginate() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }
    public function resetFilters() { $this->resetPage(); }

    public function render()
    {
        if ($this->countries) {
            $data = $this->countries;
            $this->totalCount = $this->countries->total();
        } else {
            $query = Country::query();
            $this->totalCount = $query->count();

            // Search
            $query->when($this->search, function ($query) {
                $search = $this->search;
                $query->where(function ($q) use ($search) {

                    foreach ($this->columns as $column) {
                        // Only lowercase if column is string
                        if (in_array($column, ['name', 'code'])) {
                            $q->orWhereRaw('LOWER(' . $column . ") LIKE ?", ['%' . strtolower($search) . '%']);
                        } else {
                            $q->orWhere($column, 'like', '%' . $search . '%');
                        }
                    }
                });
            });

            // Status filter
            $query->when($this->status, function ($query) {
                if ($this->status === 'active') {
                    $query->where('active', 1);
                } elseif ($this->status === 'inactive') {
                    $query->where('active', 0);
                }
            });

            // Sorting
            if ($this->sort === 'name_asc') {
                $query->orderBy('name', 'asc');
            } elseif ($this->sort === 'name_desc') {
                $query->orderBy('name', 'desc');
            } elseif ($this->sort === 'created_desc') {
                $query->orderBy('created_at', 'desc');
            } elseif ($this->sort === 'created_asc') {
                $query->orderBy('created_at', 'asc');
            }

            $data = $query->with('cities')->paginate($this->perPage);
        }
        return view('livewire.dashboard.country-table', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }

    // Bulk Edit Action Example (implement your logic here)
    public function bulkEdit()
    {
        // فقط مثال: عرض رسالة تأكيد (يمكنك استبدالها بمنطقك)
        session()->flash('message', __('تم تنفيذ التعديل الجماعي على العناصر المحددة: ') . implode(',', $this->selected));
    }

    // Toggle active status for a country
    public function toggleActive($id)
    {
        $country = Country::find($id);
        if ($country) {
            $country->is_active = !$country->is_active;
            $country->save();
            session()->flash('message', __('تم تحديث حالة الدولة بنجاح.'));
        }
    }
}
