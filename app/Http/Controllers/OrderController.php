<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return View
     */
    public function show(): View
    {
        $orders = Order::where('user_id', Auth::id())->get();
        //dd($orders);
        return view('orders.show', compact('orders'));
    }
}
