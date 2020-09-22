<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function landing(){

        $products = Product::inRandomOrder()->take(3)->paginate(3);

        return view('store.productLanding')->with('products', $products);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProducts(Request $request)
    {
        $products = Product::ProductInfo($request->input('search'))->paginate(15);

        return view('store.productShow', compact('products', $products));
    }


    public function showSpecs($slug){

        $product = Product::where('slug', $slug)->first();

        return view('store.productEspecs', compact('product'));

        /*$products = Product::findorfail($id);

        return view('store.productShow')->with('products', $products);*/
    }

}

