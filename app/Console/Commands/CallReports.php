<?php

namespace App\Console\Commands;

use App\Constants\Procedures;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CallReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:generate-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the table for order reports';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS reports_generate');
        DB::unprepared(Procedures::ORDER_REPORTS_PROCEDURE);

        $dateFrom = now()->subYear()->format('Y-m-d');
        $dateTo = now()->format('Y-m-d');

        DB::unprepared("call reports_generate('$dateFrom', '$dateTo')");

    }
}
