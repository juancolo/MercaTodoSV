<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\ProductRequest;
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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

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
    public function store(ProductRequest $request)
    {
        $product = Product::create([
            'name'          => $request->input('name'),
            'slug'          => $request->input('slug'),
            'details'       => $request->input('details'),
            'description'   => $request->input('description'),
            'actualPrice'  => $request->input('actualPrice'),
            'category_id'   => $request->input('category_id')
            ]);

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
     * @param  Product $slug
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
     *
     * @param ProductRequest $request
     * @param   $slug
     */
    public function update(ProductRequest $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();

        $product->name          = $request->name;
        $product->slug          = $request->slug;
        $product->details       = $request->details;
        $product->description   = $request->description;
        $product->actualPrice   = $request->actual_price;
        $product->oldPrice      = $request->old_price;
        $product->status        = $request->status;
        $product->category_id   = $request->input('category_id');
        $product->tags()->sync($request->get('tags'));

//Image
        if($request->file('file'))
        {
            if($product->file) {
                Storage::delete($product->file);
            }
            $file = $request->file('file')->store('public');
            $product->file = Storage::url($file);
        }

        $product->save();

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
        $product->delete();

        return redirect()
            ->route('product.index')
            ->with('status', 'Se ha eliminado el producto correctamente');
    }


}
