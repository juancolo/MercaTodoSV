<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartUpdateRequest;
use App\Product;
use App\User;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->id();

        $cartItems = $this->getCartOfAUser()->getContent();

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
     */
    public function store(Product $product)
    {
        $this->getCartOfAUser()->add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->actualPrice,
            'quantity' => 1,
            'attributes' => array($product->file),
            'associateModel' => Product::class
        ));
        return back()->with('status', $product->name.' se ha agregado tu carrito');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $cartItems
     * @return \Illuminate\Http\Response
     */
    public function update( $cartItems)
    {

        $this->getCartOfAUser()->update($cartItems, array(
                'quantity' => array(
                'relative' => false,
                'value' => request('quantity')
            ),
        ));

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
        $this->getCartOfAUser()->remove($productId);

        return back()->with('status', 'Producto eliminado del carrito adecuadamente');

    }
    public function getCartOfAUser(){
        $user = \Cart::session(auth()->id());

        return $user;
    }
}
