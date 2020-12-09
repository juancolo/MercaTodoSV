<?php

namespace App\Http\Controllers\Store;

use App\Entities\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Application|Factory|View
     */
    public function landing()
    {
        $products = Cache::remember('products', 800, function () {
            return Product::inRandomOrder()
                ->take(3)
                ->paginate(3);
        });

        return view('store.index', compact('products'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function showProducts(Request $request)
    {
        $key = "product.page" . request('page', 1);

        $products = Cache::remember($key, 800, function ()
        use ($request) {
            return
                Product::with('category')
                    ->ProductInfo($request->input('search'))
                    ->ActiveProduct()
                    ->paginate(15);
        });

        return view('store.show_products', compact('products'));
    }

    /**
     * @param Product $product
     * @return Application|Factory|View
     */
    public function showSpecs(Product $product)
    {
        return view('store.show_especs', compact('product'));
    }

}

