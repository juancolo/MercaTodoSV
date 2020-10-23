<?php

namespace App\Http\Controllers;

use App\Entities\Order;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

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
