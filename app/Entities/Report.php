<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'report',
        'primary_id',
        'secondary_id',
        'date',
        'keyword',
        'status_type',
        'status'
    ];

    /**
     * @param $primaryId
     * @return bool
     */
    public static function isFilteredByPrimaryId($primaryId): bool
    {
        return $primaryId != 'all' && $primaryId != null;
    }

    /**
     * @param Builder $query
     * @param $primaryId
     * @return Builder
     */
    public static function scopeFilterByPrimaryId(Builder $query, $primaryId): Builder
    {
        if (self::isFilteredByPrimaryId($primaryId)) {
            $user = User::where('id', $primaryId['value'])->select('id')->first();

            return $query->where('primary_id', $user->id);
        }

        return $query;
    }


    /**
     * @param Collection $reports
     * @return Collection
     */
    public static function readThreeLevelsReport(Collection $reports): Collection
    {
        $data = [];

        foreach ($reports as $report) {
            $data[$report->status][$report->date] = ($data[$report->status][$report->date] ?? 0) + $report->total;
        }
        return collect($data);
    }
}
