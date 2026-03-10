<?php

namespace App\Traits;

use App\Enums\TaskStatus;

trait Helpers
{
    public function resetValuesFilters()
    {
        $this->search = '';
        $this->sort = 'ASC';
        $this->sortBy = '';
    }

    public function sortTasksByDesc($tasks)
    {
        return $tasks->sortByDesc(function ($task) {
            return match ($task->pivot->status) {
                TaskStatus::IN_PROGRESS => 4,
                TaskStatus::PENDING => 3,
                TaskStatus::COMPLETED => 2,
                TaskStatus::ABANDONED => 1,
                default => 0,
            };
        })->sortByDesc(function ($task) {
            return $task->pivot->status === TaskStatus::COMPLETED ? $task->pivot->updated_at : now()->addYears(10);
        });
    }
}
