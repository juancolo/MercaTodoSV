<?php


namespace App\Report;


use App\Contracts\ReportContract;
use Illuminate\Support\Collection;

class ReportManager
{

    /** @var ReportContract */
    private $behaviour;

    /**
     * Metric constructor.
     * @param ReportContract $behaviour
     */
    public function __construct(ReportContract $behaviour)
    {
        $this->behaviour = $behaviour;
    }

    public function read(array $filters): Collection
    {
        return $this->behaviour->read($filters);
    }
}
