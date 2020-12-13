<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Entities\Tag;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use App\Entities\Product;
use App\Entities\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Repository\ProductRepository;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;


class ProductController extends Controller
{
    protected ProductRepository $productRepo;

    /**
     * CategoryController constructor.
     * Validate user is an admin and is authenticated
     * @param ProductRepository $productRepo
     */
    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
        $this->middleware('admin');
        $this->middleware('auth');
    }


    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $products = $this->productRepo->getProductIndex($request);
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
        $this->productRepo->create($request->all());

        return redirect()
            ->route('product.index')
            ->with('message', trans('products.messages.create.created'));
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
        $this->productRepo->update($product, $request->all());

        return redirect()
            ->route('product.index')
            ->with('status', trans('products.messages.update.updated'));
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
       $this->productRepo->delete($product);
        return redirect()
            ->route('product.index')
            ->with('status', 'Se ha eliminado el producto correctamente');
    }
}
