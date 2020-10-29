<?php

namespace App\Http\Controllers\Store;

use App\Entities\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function landing(){
        $products = Cache::remember('products', 800, function (){
            return Product::inRandomOrder()
                    ->take(3)
                    ->paginate(3);
        });
        return view('store.productLanding',compact('products'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProducts(Request $request)
    {
      $key = "product.page". request('page', 1);

       $products = Cache::remember($key,800, function ()
        use ($request){
            return
                Product::with('category')
                ->ProductInfo($request->input('search'))
                ->ActiveProduct()
                ->paginate(15);
        });

        return view('store.productShow', compact('products'));
    }

    public function showSpecs(Product $product)
    {
        return view('store.productEspecs', compact('product'));
    }

}

