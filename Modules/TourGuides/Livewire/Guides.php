<?php

namespace Modules\TourGuides\Livewire;

use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\ExportsData;
use App\Traits\HandlesCrudSafely;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\TourGuides\Entities\TourGuide;

class Guides extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;
    public $search = '';
    public $totalCount = 0;
    public $filterActive = '';
    public $filterRegionId = '';
    public $filterSubregionId = '';
    public $filterCountryId = '';
    public $filterStateId = '';
    public $filterCityId = '';
    public $filterTypeId = '';
    
    protected $listeners = ['recordUpdated' => '$refresh', 'refresh-page' => '$refresh', 'reset-checkout-boxes' => '$refresh', 'filterColumn' => 'filterColumn'];

    public function updated($property)
    {
        $filters = ['search', 'filterActive', 'filterRegionId', 'filterSubregionId', 'filterCountryId', 'filterStateId', 'filterCityId', 'filterTypeId'];
        
        if (in_array($property, $filters)) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterActive', 'filterRegionId', 'filterSubregionId', 'filterCountryId', 'filterStateId', 'filterCityId', 'filterTypeId']);
        $this->resetPage();
    }

    public function mount()
    {
        set_time_limit(120);
        ini_set('memory_limit', '512M');
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(TourGuide::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, TourGuide::class, 'tour_guide');
    }

    public function forceDelete($id)
    {
        $this->safeForceDelete($id, TourGuide::class, 'tour_guide');
    }

    public function updatedSelectPage($value)
    {
        $this->selectedIds = $value ? $this->currentPageDataIds()->toArray() : [];
    }

    public function updatedSelectedIds()
    {
        $this->selectPage = count($this->selectedIds) === $this->currentPageDataIds()->count();
    }

    protected function currentPageDataIds()
    {
        return $this->buildQuery()->paginate(getPaginate())->getCollection()->pluck('id');
    }

    protected function buildQuery()
    {
        $query = TourGuide::query()
            ->without(['richTextDescription', 'richTextNotes'])
            ->with([
                'country:id,name,name_ar',
                'state:id,name,name_ar',
                'city:id,name,name_ar',
                'guide_type:id,type',
                'currency:id,name,code,symbol',
            ]);

        if ($this->filterActive === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterActive === 'inactive') {
            $query->where('is_active', false);
        }

        if ($this->filterRegionId && $this->filterRegionId !== 'all') {
            $query->whereHas('country.subregion', function ($q) {
                $q->where('region_id', $this->filterRegionId);
            });
        }
        
        if ($this->filterSubregionId && $this->filterSubregionId !== 'all') {
            $query->whereHas('country', function ($q) {
                $q->where('subregion_id', $this->filterSubregionId);
            });
        }

        if ($this->filterCountryId && $this->filterCountryId !== 'all') {
            $query->where('country_id', $this->filterCountryId);
        }

        if ($this->filterStateId && $this->filterStateId !== 'all') {
            $query->where('state_id', $this->filterStateId);
        }

        if ($this->filterCityId && $this->filterCityId !== 'all') {
            $query->where('city_id', $this->filterCityId);
        }

        if ($this->filterTypeId && $this->filterTypeId !== 'all') {
            $query->where('type_id', $this->filterTypeId);
        }

        $query->searchWithRelations(
            search: $this->search,
            selectedColumns: $this->columns,
            availableRelations: $this->relations,
            searchColumnsFilters: $this->searchColumns
        );

        $this->applySorting($query);

        return $query;
    }

    public function activateSelected()
    {
        if (empty($this->selectedIds)) return;
        TourGuide::whereIn('id', $this->selectedIds)->update(['is_active' => true]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deactivateSelected()
    {
        if (empty($this->selectedIds)) return;
        TourGuide::whereIn('id', $this->selectedIds)->update(['is_active' => false]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        TourGuide::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(TourGuide::class);
        $count = count($this->selectedIds);
        $this->clearSelected();

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.tour_guides'), 'count' => $count]),
        ]);
    }

    public function forceDeleteSelected()
    {
        if (empty($this->selectedIds)) return;
        TourGuide::whereIn('id', $this->selectedIds)->forceDelete();
        $this->resetAutoIncrementIfEmpty(TourGuide::class);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function clearSelected()
    {
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], TourGuide::class, $cols, 'tour_guides');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], TourGuide::class, $cols, 'tour_guides', $extension);
    }

    public function render()
    {
        ini_set('memory_limit', '512M');
        $query = $this->buildQuery();
        $perPage = min(getPaginate(), 25); // Tour Guides: max 25 per page for performance
        $data = $query->paginate($perPage);
        
        // جلب أسماء الأعمدة الجغرافية حسب اللغة
        $nameCol = 'name' . (app()->getLocale() == 'ar' ? '_ar' : '');

        // جلب الأقاليم
        $regions = \Modules\Geography\Entities\Region::where('is_active', true)->pluck($nameCol, 'id');

        // جلب الأقاليم الفرعية بناءً على الإقليم المختار
        $subregionsQuery = \Modules\Geography\Entities\Subregion::where('is_active', true);
        if ($this->filterRegionId && $this->filterRegionId !== 'all') {
            $subregionsQuery->where('region_id', $this->filterRegionId);
        }
        $subregions = $subregionsQuery->pluck($nameCol, 'id');

        // جلب الدول بناءً على الإقليم الفرعي أو الإقليم الأساسي
        $countriesQuery = \Modules\Geography\Entities\Country::where('is_active', true);
        if ($this->filterSubregionId && $this->filterSubregionId !== 'all') {
            $countriesQuery->where('subregion_id', $this->filterSubregionId);
        } elseif ($this->filterRegionId && $this->filterRegionId !== 'all') {
            $countriesQuery->whereHas('subregion', function($q) {
                $q->where('region_id', $this->filterRegionId);
            });
        }
        $countries = $countriesQuery->pluck($nameCol, 'id');

        // جلب المحافظات بناءً على الدولة
        $statesQuery = \Modules\Geography\Entities\State::where('is_active', true);
        if ($this->filterCountryId && $this->filterCountryId !== 'all') {
            $statesQuery->where('country_id', $this->filterCountryId);
        }
        $states = $statesQuery->pluck($nameCol, 'id');

        // جلب المدن بناءً على المحافظة
        $citiesQuery = \Modules\Geography\Entities\City::where('is_active', true);
        if ($this->filterStateId && $this->filterStateId !== 'all') {
            $citiesQuery->where('state_id', $this->filterStateId);
        }
        $cities = $citiesQuery->pluck($nameCol, 'id');

        // جلب أنواع المرشدين
        $types = \Modules\TourGuides\Entities\TourGuideType::where('is_active', true)->pluck('type', 'id');
        
        return view('tourguides::livewire.guides', [
            'data' => $data, 
            'totalCount' => $data->total(), 
            'selectedIds' => $this->selectedIds,
            'regions' => $regions,
            'subregions' => $subregions,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
            'types' => $types,
        ]);
    }
}

