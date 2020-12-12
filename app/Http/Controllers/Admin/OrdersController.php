<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Order;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::ordersToShow()
            ->paginate();
     return view('admin.orders.index', compact('orders'));
    }
}
