<?php

namespace App\Console\Commands;

use App\Entities\Order;
use Dnetix\Redirection\PlacetoPay;
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
    public function handle(PlacetoPay $placetoPay)
    {
        $ordersToUpdate = Order::WithoutFinalStatus()->get();
        //dd($ordersToUpdate->count());
            if ($ordersToUpdate->count() > 0)
                foreach ($ordersToUpdate as $order)
                    $order->status = $placetoPay->query($order->reference);
        return 0;
    }
}
