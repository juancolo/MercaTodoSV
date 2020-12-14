<?php

namespace App\Http\Controllers\Ecomerce;

use App\Entities\Order;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Order $orders
     * @return View
     */
    public function show(Order $orders): View
    {
        $orders = $orders->allowed()
            ->paginate(3);
        return view('orders.show', compact('orders'));
    }

}
