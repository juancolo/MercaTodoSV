<?php


namespace App\Services;

use App\Entities\Product;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\CartCollection;

class CartService
{
    /**
     * @return Cart
     */
    public function getACartFromUser()
    {
        return \Cart::session(Auth::id());
    }

    /**
     * @return CartCollection
     */
    public function getAContentCartFormAUser(): CartCollection
    {
        return $this->getACartFromUser()->getContent();
    }

    /**
     * @param Product $product
     * @return string
     * @throws \Darryldecode\Cart\Exceptions\InvalidItemException
     */
    public function storeACartOfAUser(Product $product)
    {
        if ($product->stock < 1)
            return ( 'no hay suficiente stock del producto');
        else
            $this->getACartFromUser()->add(array(
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->actual_price,
                    'quantity' => 1,
                    'attributes' => array($product->file),
                    'associateModel' => Product::class
                )
            );
            return ('se ha agregado '.$product->name .' al carrito');
    }

    /**
     * @param string $cartItem
     */
    public function updateAProductToACartUser(string $cartItem)
    {
        $product = $this->getAProductOfACart($cartItem);
        if (request('quantity') > $product->stock)
        {
          return ('the amount of the product is bigger than the stock');
        }
        $this->getACartFromUser()->update($cartItem, array
            (
            'quantity'=>array(
                'relative'=>false,
                'value'=>request('quantity')
                )
            )
        );
        return ('your cart is update');
    }

    /**
     * @param string $productId
     */
    public function deleteAProductFromTheCartUser(string $productId)
    {
        $this->getACartFromUser()->remove($productId);
    }

    public function getAProductOfACart($cartItem)
    {
        return Product::where('id',
            $this
                ->getACartFromUser()
                ->get($cartItem)
                ->toArray()['id']
        )->first();
    }
}
