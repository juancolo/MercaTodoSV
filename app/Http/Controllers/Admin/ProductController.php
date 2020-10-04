<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\Product\IndexProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Product;
use App\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class ProductController extends Controller
{
    /**
     * CategoryController constructor.
     * Validate user is an admin and is authenticated
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('auth');
    }


    /**
     * @param IndexProductRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index(IndexProductRequest $request)

    {
        $products = Product::ProductInfo($request->input('search'))->paginate();

        return view('admin.products.manageProduct', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $tags = Tag::orderBy('name', 'ASC')->get();

        return view('admin.products.cretaProduct', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request

     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated()->all());

        $product->tags()->sync($request->input('tags'));

        //Image
        if($request->file('file'))
        {
            $file = $request->file('file')->store('public');
            $product->file = Storage::url($file);
        }

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $tags       = Tag::orderBy('name', 'ASC')->get();

        return view('admin.products.editProduct', compact('product', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Product $product
     * @param UpdateProductRequest $request
     * @return RedirectResponse
     */
    public function update(Product $product, UpdateProductRequest $request): RedirectResponse
    {
    //Image
        if($request->file('file'))
        {
            if($product->file) {
                Storage::delete($product->file);
            }
            $file = $request->file('file')->store('public');
            $product->file = Storage::url($file);
        }

        $product->update(array_filter($request->validated()));


        return redirect()->route('product.index')
                         ->with('status', 'Producto actualizado correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product) : RedirectResponse
    {
        Storage::delete($product->file);
        $product->delete();

        return redirect()
            ->route('product.index')
            ->with('status', 'Se ha eliminado el producto correctamente');
    }


}
