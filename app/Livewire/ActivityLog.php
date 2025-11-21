<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Builder;
use App\Support\Activity\ActivityMessageFormatter;

class ActivityLog extends Component
{
    use WithPagination, CustomPagination, WithSorting {
        applySorting as baseApplySorting;
    }

    public string $search = '';
    public string $filterLog = '';
    public string $filterEvent = '';
    public string $filterUser = '';
    public ?string $dateFrom = null;
    public ?string $dateTo = null;
    public array $selectedIds = [];
    public bool $selectPage = false;
    public ?int $focusedActivityId = null;
    public array $filterColumns = [];
    public array $selectedActivity = [];

    protected $listeners = ['refreshActivityLog' => '$refresh', 'activityCreated' => '$refresh'];

    protected string $paginationTheme = 'tailwind';

    public function mount(): void
    {
        $this->mountWithCustomPagination();
        $this->filterColumns = [
            ['key' => 'created_at', 'label' => 'activity.activity_timestamp'],
            ['key' => 'activity_event_type', 'label' => 'activity.activity_event_type'],
            ['key' => 'activity_log_type', 'label' => 'activity.activity_log_type'],
            ['key' => 'activity_causer', 'label' => 'activity.activity_causer'],
            ['key' => 'activity_subject', 'label' => 'activity.activity_subject'],
            ['key' => 'activity_summary', 'label' => 'activity.activity_summary'],
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterLog(): void
    {
        $this->resetPage();
    }

    public function updatedFilterEvent(): void
    {
        $this->resetPage();
    }

    public function updatedFilterUser(): void
    {
        $this->resetPage();
    }

    public function updatedDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedDateTo(): void
    {
        $this->resetPage();
    }

    public function updatedSelectPage($value): void
    {
        $this->selectedIds = $value ? $this->currentPageActivityIds()->toArray() : [];
    }

    public function updatedSelectedIds(): void
    {
        $this->selectPage = count($this->selectedIds) === $this->currentPageActivityIds()->count();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'filterLog', 'filterEvent', 'filterUser', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    public function viewDetails(int $activityId): void
    {
        $activity = Activity::with(['causer', 'subject'])->find($activityId);

        if (!$activity) {
            $this->selectedActivity = [];
            $this->focusedActivityId = null;
            return;
        }

        $this->selectedActivity = $this->formatActivity($activity);
        $this->focusedActivityId = $activity->id;
    }

    public function closeDetails(): void
    {
        $this->selectedActivity = [];
        $this->focusedActivityId = null;
    }

    public function delete(int $activityId): void
    {
        if ($activity = Activity::find($activityId)) {
            $activity->delete();
            $this->afterMutation();
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => __('main.messages.type_deleted', ['type' => __('activity.activity')]),
            ]);
        }
    }

    public function deleteSelected(): void
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Activity::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->afterMutation();

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('main.messages.type_deleted_count', ['type' => __('activity.activity_logs'), 'count' => $count]),
        ]);
    }

    public function clearLog(string $logName): void
    {
        Activity::where('log_name', $logName)->delete();
        $this->afterMutation();

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('activity.activity_log_cleared', ['type' => ucfirst($logName)]),
        ]);
    }

    protected function afterMutation(): void
    {
        $this->reset(['selectedIds', 'selectPage']);
        $this->selectedActivity = [];
        $this->focusedActivityId = null;
        $this->resetPage();
        $this->dispatch('refreshActivityLog');
    }

    protected function currentPageActivityIds(): Collection
    {
        $paginator = $this->getQuery()->paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    protected function getQuery(): Builder
    {
        $query = Activity::query()->with(['causer', 'subject']);

        if ($this->search != '') {
            $search = '%' . $this->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', $search)
                    ->orWhere('log_name', 'like', $search)
                    ->orWhere('event', 'like', $search)
                    ->orWhere('subject_type', 'like', $search)
                    ->orWhere('properties->message', 'like', $search)
                    ->orWhere('properties->exception', 'like', $search)
                    ->orWhereHas('causer', function ($causer) use ($search) {
                        $causer->where(function ($userQuery) use ($search) {
                            foreach ($this->searchableUserColumns() as $column) {
                                $userQuery->orWhere($column, 'like', $search);
                            }
                        });
                    });
            });
        }

        if ($this->filterLog != '') {
            $query->where('log_name', $this->filterLog);
        }
        if ($this->filterEvent != '') {
            $query->where('event', $this->filterEvent);
        }
        if ($this->filterUser != '') {
            $query->where('causer_id', $this->filterUser);
        }
        if ($this->dateFrom) {
            $query->where('created_at', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $query->where('created_at', '<=', $this->dateTo);
        }
        $this->applySorting($query);
        return $query;
    }

    protected function formatActivity(Activity $activity): array
    {
        $subjectLabel = null;

        if ($activity->subject) {
            if (method_exists($activity->subject, 'getActivitylogSubjectTitle')) {
                $subjectLabel = $activity->subject->getActivitylogSubjectTitle();
            } elseif (method_exists($activity->subject, 'getAttribute') && $activity->subject->getAttribute('name')) {
                $subjectLabel = $activity->subject->getAttribute('name');
            } elseif (method_exists($activity->subject, 'getAttribute') && $activity->subject->getAttribute('title')) {
                $subjectLabel = $activity->subject->getAttribute('title');
            } else {
                $subjectLabel = class_basename($activity->subject) . '#' . $activity->subject->getKey();
            }
        }

        return [
            'id' => $activity->id,
            'log_name' => $activity->log_name,
            'event' => $activity->event,
            'description' => ActivityMessageFormatter::detailed($activity),
            'created_at' => optional($activity->created_at)->toDateTimeString(),
            'causer' => $activity->causer ? [
                'id' => $activity->causer->id,
                'name' => $activity->causer->name,
                'email' => $activity->causer->email,
            ] : null,
            'subject' => $activity->subject ? [
                'type' => $activity->subject_type,
                'id' => $activity->subject_id,
                'label' => $subjectLabel,
            ] : null,
            'properties' => $activity->properties ? $activity->properties->toArray() : [],
        ];
    }

    protected function stats(): array
    {
        $modelLog = config('activitylog.model_log_name');
        $systemLog = config('activitylog.system_log_name');

        $row = Activity::selectRaw(
            'count(*) as total,
            sum(case when log_name = ? then 1 else 0 end) as model_total,
            sum(case when log_name = ? then 1 else 0 end) as system_total,
            sum(case when event = ? then 1 else 0 end) as error_total',
            [$modelLog, $systemLog, 'error']
        )->first();

        return [
            'total' => (int) ($row->total ?? 0),
            'models' => (int) ($row->model_total ?? 0),
            'system' => (int) ($row->system_total ?? 0),
            'errors' => (int) ($row->error_total ?? 0),
        ];
    }

    protected function breakdown()
    {
        return Activity::select('event', DB::raw('count(*) as total'))->groupBy('event')->orderByDesc('total')->get();
    }

    protected function availableLogNames(): Collection
    {
        return Activity::select('log_name')->distinct()->orderBy('log_name')->pluck('log_name');
    }

    protected function availableEvents(): Collection
    {
        return Activity::select('event')->whereNotNull('event')->distinct()->orderBy('event')->pluck('event');
    }

    protected function availableUsers(): Collection
    {
        $ids = Activity::whereNotNull('causer_id')->distinct()->pluck('causer_id');

        if ($ids->isEmpty()) {
            return collect();
        }

        return User::whereIn('id', $ids)->select('id', 'name', 'email')->orderBy('name')->get();
    }

    protected function searchableUserColumns(): array
    {
        static $columns;

        if ($columns !== null) {
            return $columns;
        }

        $user = new User();
        $table = $user->getTable();

        $fillable = array_filter($user->getFillable());

        if (!empty($fillable)) {
            $columns = $fillable;
        } elseif (Schema::hasTable($table)) {
            $columns = array_values(array_diff(
                Schema::getColumnListing($table),
                [
                    $user->getKeyName(),
                    'password',
                    'remember_token',
                    'two_factor_secret',
                    'two_factor_recovery_codes',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ]
            ));
        } else {
            $columns = [];
        }

        $columns = array_values(array_unique(array_merge($columns, ['name', 'email'])));

        return $columns;
    }

    protected function applySorting($query)
    {
        $model = $query->getModel();
        $table = $model->getTable();
        $connection = $model->getConnection();
        $tableQualified = $connection->getTablePrefix() . $table;
        $userTable = $connection->getTablePrefix() . (new User())->getTable();

        // If no custom sort is applied, default to newest first
        if (empty($this->sortField) || empty($this->sortDirection)) {
            $query->orderBy($tableQualified . '.created_at', 'desc');
            $query->orderBy($tableQualified . '.id', 'desc');
            return $query;
        }

        $direction = strtolower($this->sortDirection) == 'asc' ? 'asc' : 'desc';

        switch ($this->sortField) {
            case 'created_at':
                $query->orderBy($tableQualified . '.created_at', $direction);
                break;
            case 'activity_event_type':
                $query->orderBy($tableQualified . '.event', $direction);
                break;
            case 'activity_log_type':
                $query->orderBy($tableQualified . '.log_name', $direction);
                break;
            case 'activity_summary':
                $query->orderBy($tableQualified . '.description', $direction);
                break;
            case 'activity_subject':
                $query->orderBy($tableQualified . '.subject_type', $direction)
                    ->orderBy($tableQualified . '.subject_id', $direction);
                break;
            case 'activity_causer':
                $raw = "COALESCE((SELECT name FROM {$userTable} WHERE {$userTable}.id = {$tableQualified}.causer_id), (SELECT email FROM {$userTable} WHERE {$userTable}.id = {$tableQualified}.causer_id), '') {$direction}";
                $query->orderByRaw($raw);
                break;
            default:
                return $this->baseApplySorting($query);
        }

        $query->orderBy($tableQualified . '.id', $direction);

        return $query;
    }

    public function render()
    {
        return view('livewire.activity-log', [
            'data' => $this->getQuery()->paginate(getPaginate()),
            'logNames' => $this->availableLogNames(),
            'events' => $this->availableEvents(),
            'users' => $this->availableUsers(),
            'stats' => $this->stats(),
            'breakdown' => $this->breakdown(),
        ]);
    }
}