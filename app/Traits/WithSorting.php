<?php

namespace App\Traits;

trait WithSorting
{
    public $sortField = '';
    public $sortDirection = '';

    /**
     * Sort by a specific column
     * 
     * @param string $field
     * @return void
     */
    public function sortBy($field)
    {
        // If clicking on the same field, toggle direction
        if ($this->sortField == $field) {
            // First click: asc -> Second click: desc -> Third click: remove sort (empty)
            if ($this->sortDirection == 'asc') {
                $this->sortDirection = 'desc';
            } elseif ($this->sortDirection == 'desc') {
                $this->sortField = '';
                $this->sortDirection = '';
            } else {
                $this->sortDirection = 'asc';
            }
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
        if (!empty($this->sortField) && !empty($this->sortDirection)) {
            // Check if sortField is a relation (skip sorting for relations)
            if (isset($this->relations) && in_array($this->sortField, $this->relations)) {
                // Don't apply sorting for relation columns
                return $query;
            }

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
        if ($this->sortField != $field || empty($this->sortDirection)) {
            return 'fa-sort'; // Default unsorted icon
        }

        return $this->sortDirection == 'asc' ? 'fa-sort-up' : 'fa-sort-down';
    }

    /**
     * Check if a field is currently being sorted
     * 
     * @param string $field
     * @return bool
     */
    public function isSortedBy($field)
    {
        return $this->sortField == $field;
    }

    /**
     * Reset sorting to default state
     * 
     * @return void
     */
    public function resetSort()
    {
        $this->sortField = '';
        $this->sortDirection = '';
    }
}
