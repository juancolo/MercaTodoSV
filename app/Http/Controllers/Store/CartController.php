<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Product;
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
        return view('cart.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * @param Product $product
     */
    public function store(Product $product)
    {
        $user = auth()->id();

        \Cart::session ($user)->add(array(
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $productId
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId)
    {
        \Cart::session(auth()->id())->remove($productId);

        return back()->with('status', 'Producto eliminado del carrito adecuadamente');

    }
}
