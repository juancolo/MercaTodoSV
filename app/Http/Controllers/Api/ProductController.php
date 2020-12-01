<?php

namespace App\Http\Controllers\Api;

use App\Entities\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('name', 'like', Str::of(request('filters.name')))
            ->applySorts()->jsonPaginate();

        return ProductCollection::make($products);
    }

    public function show(Product $product)
    {
        return ProductResource::make($product);
    }
}

