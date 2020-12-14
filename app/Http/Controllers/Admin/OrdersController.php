<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Order;
use App\Http\Controllers\Controller;
use App\Repository\OrderRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\View;

class OrdersController extends Controller
{
    /**
     * @var OrderRepository
     */
    private OrderRepository $orderRepo;

    /**
     * OrdersController constructor.
     * @param OrderRepository $orderRepo
     */
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $this->orderRepo->getOrderForAdmin();
        
        return view('admin.orders.index', compact('orders'));
    }
}
