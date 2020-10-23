<?php

namespace App\Http\Controllers;

use App\Entities\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StoreController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function landing(){

        return view('store.productLanding',[
            'products' => Product::inRandomOrder()->take(3)->paginate(3)
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProducts(Request $request)
    {
        $products = Product::with('category')
                    ->ProductInfo($request->input('search'))
                    ->paginate();

        return view('store.productShow', compact('products'));

      /* $key = "product.page". request('page', 1);

       $products = Cache::rememberForever($key, function ()
        use ($request){
            return Product::with('category')->ProductInfo($request->input('search'))->paginate(15);
        });

        return view('store.productShow', compact('products'));*/
    }

    public function showSpecs(Product $product)
    {
        return view('store.productEspecs', compact('product'));
    }

}

