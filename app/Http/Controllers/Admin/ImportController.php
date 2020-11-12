<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Imports\ProductsImport;
use App\Jobs\NotifyAdminOfCompletedImport;
use Illuminate\Support\Facades\Auth;

class ImportController extends Controller
{
    public function productImport(ImportRequest $request)
    {
        $filePath = $request->file('file')->getClientOriginalName();

        $import = new ProductsImport();
        $import->queue($request->file('file'))->chain([
            new NotifyAdminOfCompletedImport(Auth::user(), $filePath)
        ]);
        $importedProducts = $import->toArray($request->file('file'));

        return redirect()
            ->route('product.index')
            ->with('status', trans('products.messages.imported', ['count' => count($importedProducts)]));
    }
}
