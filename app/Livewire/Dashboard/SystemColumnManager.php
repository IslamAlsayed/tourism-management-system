<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\TableColumn;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SystemColumnManager extends Component
{
    public $modules = [
        'Users' => \Modules\Core\Entities\User::class,
        'Roles' => \Spatie\Permission\Models\Role::class,
        'Permissions' => \Spatie\Permission\Models\Permission::class,
        'Activity Logs' => \Spatie\Activitylog\Models\Activity::class,
        'Page Banners' => \App\Models\PageBanner::class,
        // Geography
        'Regions' => \Modules\Geography\Entities\Region::class,
        'Subregions' => \Modules\Geography\Entities\Subregion::class,
        'Countries' => \Modules\Geography\Entities\Country::class,
        'States' => \Modules\Geography\Entities\State::class,
        'Cities' => \Modules\Geography\Entities\City::class,
        'Nationalities' => \Modules\Geography\Entities\Nationality::class,
        // Accommodations
        'Accommodations' => \Modules\Accommodations\Entities\Accommodation::class,
        'Accommodation Rooms' => \Modules\Accommodations\Entities\Room::class,
        'Accommodation Seasons' => \Modules\Accommodations\Entities\Season::class,
        // Tour Guides
        'Tour Guides' => \Modules\TourGuides\Entities\TourGuide::class,
    ];

    public $selectedModule = '';
    public $availableColumns = [];
    public $selectedColumns = [];
    public $excludedColumns = ['uuid', 'created_at', 'updated_at', 'deleted_at'];

    public function updatedSelectedModule()
    {
        $this->loadColumns();
    }

    public function loadColumns()
    {
        $this->availableColumns = [];
        $this->selectedColumns = [];

        if (!$this->selectedModule || !isset($this->modules[$this->selectedModule])) {
            return;
        }

        $modelClass = $this->modules[$this->selectedModule];
        
        if (!class_exists($modelClass)) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Model class does not exist: ' . $modelClass
            ]);
            return;
        }

        $model = new $modelClass();
        $table = $model->getTable();

        // Get actual database columns
        $allColumns = Schema::getColumnListing($table);
        
        // Remove strictly excluded columns
        $this->availableColumns = array_values(array_diff($allColumns, $this->excludedColumns));

        // Get custom relations if defined in model
        if (method_exists($model, 'getRelationshipNames')) {
            $relations = $model->getRelationshipNames();
            $this->availableColumns = array_merge($this->availableColumns, $relations);
        }

        // Ensure no duplicates exist
        $this->availableColumns = array_values(array_unique($this->availableColumns));

        // Fetch existing system configuration (where user_id is null)
        $systemConfig = TableColumn::where('model_class', $modelClass)
            ->whereNull('user_id')
            ->first();

        if ($systemConfig && is_array($systemConfig->columns)) {
            $this->selectedColumns = $systemConfig->columns;
        } else {
            // Default selection based on app settings or first 6 columns
            $defaultCount = optional(getActiveSettings())->app_columns_length ?? config('app.app_columns_length', 6);
            $this->selectedColumns = array_slice($this->availableColumns, 0, $defaultCount);
        }
    }

    public function saveColumns()
    {
        if (!$this->selectedModule) return;

        $modelClass = $this->modules[$this->selectedModule];

        DB::beginTransaction();
        try {
            TableColumn::updateOrCreate(
                [
                    'model_class' => $modelClass,
                    'user_id' => null, // Global System Setting
                ],
                [
                    'columns' => $this->selectedColumns
                ]
            );

            DB::commit();

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => __('main.columns_updated_successfully')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function toggleColumn($column)
    {
        if (in_array($column, $this->selectedColumns)) {
            $this->selectedColumns = array_diff($this->selectedColumns, [$column]);
        } else {
            $this->selectedColumns[] = $column;
        }
        $this->selectedColumns = array_values($this->selectedColumns);
    }

    public function render()
    {
        return view('livewire.dashboard.system-column-manager')
            ->layout('layouts.master');
    }
}
