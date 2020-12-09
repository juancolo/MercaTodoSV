<?php

namespace Tests\Feature;

use App\Entities\Order;

class OrderTest
{
    public static function createOrder($user, $status)
    {
       return factory(Order::class)->create([
            'user_id'=> $user,
            'status' => $status
        ]);
    }
}
