<?php

use App\Entities\Order;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Order::class, 100)->create()->each(function (Order $order){
            $order->products()->attach([
                rand(1, 5),
                rand(6, 12),
                rand(13, 20),
                rand(20, 40),
                rand(40, 51),

            ]);
        });
    }
}
