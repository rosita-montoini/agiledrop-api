<?php

namespace App\Traits;

trait Filterable
{
    /**
     * Apply filters to the query based on the provided array of filters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeFilter($query, $filters = null)
    {
        // Sanitizes input
        if (!$filters || (!is_array($filters) && !is_object($filters) && !is_string($filters))) {
            return $query;
        }
        if (is_array($filters) || is_object($filters)) {
            $filters = json_encode($filters);
        }
        if (!is_string($filters)) {
            abort(422, "Options must be a JSON string or an array");
        }

        // Decode the JSON string into an associative array
        $filters = json_decode($filters, true);
        
        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                if ($key === 'title') {
                    $query->where($key, 'like', '%' . $value . '%');
                } else {
                    $query->where($key, $value);
                }
            }
        }
    
        return $query;
    }
}
