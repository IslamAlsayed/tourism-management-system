<?php

namespace App\Traits;

trait WithSorting
{
    public $sortField = '';
    public $sortDirection = 'asc';

    /**
     * Sort by a specific column
     * 
     * @param string $field
     * @return void
     */
    public function sortBy($field)
    {
        // If clicking on the same field, toggle direction
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // New field, default to ascending
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Apply sorting to a query
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applySorting($query)
    {
        if (!empty($this->sortField)) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        return $query;
    }

    /**
     * Get the CSS class for sort icon
     * 
     * @param string $field
     * @return string
     */
    public function getSortIcon($field)
    {
        if ($this->sortField !== $field) {
            return 'fa-sort'; // Default unsorted icon
        }

        return $this->sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down';
    }

    /**
     * Check if a field is currently being sorted
     * 
     * @param string $field
     * @return bool
     */
    public function isSortedBy($field)
    {
        return $this->sortField === $field;
    }

    /**
     * Reset sorting to default state
     * 
     * @return void
     */
    public function resetSort()
    {
        $this->sortField = '';
        $this->sortDirection = 'asc';
    }
}
