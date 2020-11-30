<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasSort
{

    /**
     * @param Builder $query
     * @param null $sort
     * @return void
     */
    public function scopeApplySorts(Builder $query, $sort): void
    {
        if (! property_exists($this, 'allowedSorts')){
            abort(500, 'Pleas give the $allowedSorts property inside '.get_class($this));
        }

        if (is_null($sort)){
            return;
        }

        $sortFields = Str::of($sort)->explode(',');

        foreach ($sortFields as $sortField) {
            $direction = 'asc';

            if (Str::of($sortField)->startsWith('-')) {
                $direction = 'desc';
                $sortField = Str::of($sortField)->substr(1);
            }

            if (! collect($this->allowedSorts)->contains($sortField)){
                abort(400);
            }

            $query->orderBy($sortField, $direction);
        }
    }

}
