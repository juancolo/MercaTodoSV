<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Tag;
use App\Entities\Product;
use App\Http\Requests\ImportRequest;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Entities\Category;
use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\IndexProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Maatwebsite\Excel\Facades\Excel;


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
     * @return View
     */
    public function index(IndexProductRequest $request): View
    {
        $products = Product::with('category')
            ->ProductInfo($request->input('search'))
            ->paginate();

        return view('admin.products.manageProduct', compact('products') );
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.products.cretaProduct', with
            ([
             'categories'=> Category::select('name', 'id')->get(),
             'tags'=>  Tag::pluck('name', 'id')
            ])
        );
    }

    /**
     * @param StoreProductRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $product = Product::create($request->validated());

        $product->tags()->sync($request->input('tags'));
        $product->save();
        //Image
        if($request->file('file'))
        {
            $file = $request->file('file')->store('images');
            $product->file = Storage::url($file);
            $product->save();
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
    public function edit(Product $product): View
    {

        return view(
            'admin.products.editProduct', with([
                'product' => $product,
                'categories'=> Category::pluck('name', 'id'),
                'tags'=> Tag::pluck('name', 'id')
            ])
        );
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
        $product->update($request->validated());
        $product->tags()->sync($request->input('tags'));

        if($request->file('file'))
        {
            if($product->file) {
                Storage::delete($product->file);
            }
            $file = $request->file('file')->store('images');
            $product->file = Storage::url($file);
            $product->save();
        }
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

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function export(Request $request, ProductsExport $productsExport): RedirectResponse
    {
        $productsExport->download('product'.$request->extension);
        return redirect()->route('product.index');
    }

    /**
     * @param ImportRequest $request
     * @return RedirectResponse
     */
    public function import(ImportRequest $request)
    {
        Excel::import(new ProductsImport(), $request->file('file'));
        return redirect()->route('product.index')->with('success', 'All Good!');
    }
}
