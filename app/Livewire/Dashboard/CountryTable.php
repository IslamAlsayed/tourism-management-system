<?php

namespace App\Livewire\Dashboard;

use App\Models\Country;
use Livewire\Component;
use App\Models\Currency;
use Livewire\WithPagination;
use App\Traits\CustomPagination;

class CountryTable extends Component
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
        // عرض جميع أعمدة العملات (id, name, code, symbol, created_at, updated_at)
        $this->columns = ['id', 'name', 'code', 'created_at', 'updated_at'];
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Country::count();

        $data = Country::query()
            ->when($this->search, function ($query) {
                $search = strtolower($this->search);
                $query->where(function ($q) use ($search) {
                    foreach ($this->columns as $column) {
                        $q->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            })->paginate(getPaginate());

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