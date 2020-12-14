<?php


namespace App\Repository;


use App\Entities\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class OrderRepository extends BaseRepositories
{
    /**
     * @var CartService
     */
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @return Order
     */
    public function getModel(): Order
    {
        return new Order();
    }

    /**
     * @param $data
     * @return Order
     */
    public function createOrder($data): Order
    {
        $orderData = array_merge($data, [
            'reference' => substr(Str::uuid()->toString(), 0, 10),
            'user_id' => Auth::id(),
            'total' => $this->cartService->getACartFromUser()->getTotal()
        ]);

        $order = $this->create($orderData);

        foreach ($this->cartService->getAContentCartFromAUser() as $product) {
            $order->products()->attach($product['id']);
        }
        return $order;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getOrderForAdmin(): LengthAwarePaginator
    {
        return Order::ordersToShow()
            ->paginate();
    }
}
