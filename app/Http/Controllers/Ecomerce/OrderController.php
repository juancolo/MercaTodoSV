<?php

namespace App\Http\Controllers\Ecomerce;

use App\Entities\Order;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($request)
    {

    }
    /**
     * @return View
     */
    public function show(): View
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('orders.show', compact('orders'));
    }
}
