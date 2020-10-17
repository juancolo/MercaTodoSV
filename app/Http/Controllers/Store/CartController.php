<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartUpdateRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Product;
use App\Services\CartService;
use App\User;
use Darryldecode\Cart\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
    public function __construct(CartService $cartService) {
        $this->middleware('auth');
        $this->cartService = $cartService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->id();

        $cartItems = $this->cartService->getAContentCartFormAUser();

        //Verify if the items into the cart still exist into the project
        foreach ($cartItems as $item){

            if (Product::find($item['id'])) {

            }
            else{
                $this->getCartOfAUser()->remove($item['id']);
            }
        }
        $cartInfo = $this->getCartOfAUser();
        return view('cart.index', compact('cartItems', 'cartInfo', 'user' ));
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function store(Product $product): RedirectResponse
    {
        return back()->with('status', $this->cartService->storeACartOfAUser($product));
    }


    /**
     * @param $cartItems
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($cartItems)
    {
        $this->cartService->updateAProductToACartUser($cartItems);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $productId
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId)
    {
        $this->cartService->deleteAProductFromTheCartUser($productId);

        return back()->with('status', 'Producto eliminado del carrito adecuadamente');

    }
    public function getCartOfAUser(){
        $user = \Cart::session(auth()->id());

        return $user;
    }
}
