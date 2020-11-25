<?php

namespace App\Http\Controllers\Admin;

use App\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Jobs\NotifyAdminOfCompletedImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    public function productImport(ImportRequest $request)
    {
        $import = new ProductsImport();
        $import->queue($request->file('file'))->chain([
            new NotifyAdminOfCompletedImport(
                Auth::user(),
                'You had been import '. $import->getRowCount(). ' products'
            )]
        );

        Log::notice('the user number ' . Auth::id() . ' has import ' . $import->getRowCount() . ' products');
        return redirect()
            ->route('product.index');
    }
}
