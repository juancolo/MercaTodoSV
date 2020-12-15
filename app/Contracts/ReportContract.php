<?php


namespace App\Contracts;


use Illuminate\Support\Collection;

interface ReportContract
{
    public function read(array $filter): Collection;
}
