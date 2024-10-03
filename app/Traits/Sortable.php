<?php

namespace App\Traits;

trait Sortable
{
    /**
     * Apply sorting to the query based on the provided column and direction.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $sorts
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortable($query, $sorts)
    {
        foreach ($sorts as $column => $direction) {
            if (in_array(strtolower($direction), ['asc', 'desc'])) {
                $query->orderBy($column, $direction);
            }
        }
        return $query;
    }
}