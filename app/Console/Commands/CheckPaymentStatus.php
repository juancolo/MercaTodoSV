<?php

namespace App\Console\Commands;

use App\Order;
use Illuminate\Console\Command;

class CheckPaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:status:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validated the payment status of the status';

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
        Order::where
        return 0;
    }
}
