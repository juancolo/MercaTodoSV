<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
    public function show(User $user): View
    {
        $orders = Order::where('user_id', $user->id);
        return view('orders.show', compact('orders'));
    }
}
