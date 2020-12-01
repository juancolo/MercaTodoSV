<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Entities\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Entities\Product;
use App\Entities\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\IndexProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;


class ProductController extends Controller
{
    /**
     * CategoryController constructor.
     * Validate user is an admin and is authenticated
     */
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('auth');
    }


    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $products = Product::with('category')
            ->ProductInfo($request->input('search'))
            ->paginate();

        return view('admin.products.index', compact('products'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.products.create', with
            ([
                'categories' => Category::select('name', 'id')->get(),
                'tags' => Tag::pluck('name', 'id')
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

        if ($request->file('file')) {
            $file = $request->file('file')->store('images');
            $product->file = Storage::url($file);
            $product->save();
        }

        return redirect()
            ->route('product.index');
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
            'admin.products.edit', with([
                'product' => $product,
                'categories' => Category::pluck('name', 'id'),
                'tags' => Tag::pluck('name', 'id')
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
        $product->update($request->all());
        $product->tags()->sync($request->input('tags'));

        if ($request->file('file')) {
            if ($product->file) {
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
     * @param Product $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        Storage::delete($product->file);
        $product->delete();

        return redirect()
            ->route('product.index')
            ->with('status', 'Se ha eliminado el producto correctamente');
    }
}
