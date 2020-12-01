<?php

namespace App\Http\Controllers\Store;

use App\Entities\Cart;
use App\Entities\Product;
use Illuminate\View\View;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    /**
     * @var CartService
     */
    private $cartService;

    /**
     * CartController constructor.
     * @param CartService $cartService
     */
    public function __construct(CartService $cartService)
    {
        $this->middleware('auth');
        $this->cartService = $cartService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $user = Auth::id();
        $cartItems = $this->cartService->getAContentCartFromAUser();

        foreach ($cartItems as $item) {
            if (Product::findOrFail($item['id'])) {
            } else {
                $this->getCartOfAUser()->remove($item['id']);
            }
        }
        $cartInfo = $this->cartService->getACartFromUser();

        return view('cart.index', compact('cartItems', 'cartInfo', 'user'));
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function store(Product $product): RedirectResponse
    {
        return redirect()->route('client.product.specs', compact('product'))
            ->with('status', $this->cartService->storeACartOfAUser($product));
    }

    /**
     * @param $cartItems
     * @return RedirectResponse
     */
    public function update($cartItems): RedirectResponse
    {
        return back()
            ->with('status', $this->cartService->updateAProductToACartUser($cartItems));
    }

    /**
     * @param $productId
     * @return RedirectResponse
     */
    public function destroy($productId): RedirectResponse
    {
        $this->cartService->deleteAProductFromTheCartUser($productId);
        return back()->with('status', 'Producto eliminado del carrito adecuadamente');

    }
}
