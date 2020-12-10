<?php

namespace App\Http\Controllers\Admin;

use App\Imports\ProductsImport;
use App\Http\Requests\ImportRequest;
use App\Jobs\CleanErrorsImportTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Jobs\NotifyAdminOfCompletedImport;
use App\Jobs\NotifyAdminOfIncompleteImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * @param ImportRequest $request
     * @param ProductsImport $import
     * @return RedirectResponse
     */
    public function productImport(ImportRequest $request, ProductsImport $import): RedirectResponse
    {
        $import->queue($request->file('file'))->chain([
            new NotifyAdminOfCompletedImport(Auth::user(), $import->getRowCount()),
            new CleanErrorsImportTable()
        ]);

        return redirect(route('product.index'));
    }
}
