<?php


namespace App\Report\Behaviour;


use App\Contracts\ReportContract;
use App\Entities\Report;
use Illuminate\Support\Collection;

class ReportBehaviour implements ReportContract
{
    public function read(array $filter): Collection
    {
        $primary = $filter['primary'] ?? null;

        $report = Report::filterByPrimaryId($primary)
            ->whereBetween('date',[
                $filter['from'] ?? now()->subMonth()->format('Y-m-d'),
                $filter['to'] ?? now()->format('Y-m-d'),
            ])->selectRaw('SUM(total) as `total`,
            `date` as `date`,
            `status`')
            ->groupBy('status', 'date')
            ->get(['date', 'status', 'total']);

        return Report::readThreeLevelsReport($report);
    }
}
