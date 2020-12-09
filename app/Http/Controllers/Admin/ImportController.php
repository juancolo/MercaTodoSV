<?php

namespace App\Http\Controllers\Admin;

use App\Imports\ProductsImport;
use App\Http\Requests\ImportRequest;
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
        $import->import($request->file('file'));

        if (count($import->failures()) > 0) {

            $this->dispatch(new NotifyAdminOfIncompleteImport(
                    Auth::user(),
                    $this->getValidationErrors($import->failures()))
            );
        } else {
            Excel::queueImport(new ProductsImport(), $request->file('file'));
                $this->dispatch(new NotifyAdminOfCompletedImport(
                Auth::user(),
                trans('products.messages.import.ready')));
        }

        return redirect()
            ->route('product.index')
            ->with('status', trans('products.messages.import.start'));
    }

    /**
     * @param $importFailures
     * @return array
     */
    public function getValidationErrors($importFailures): array
    {
        $validationErrors = [];
        foreach ($importFailures as $failure) {
            $validationErrors []= [
                'message' => $failure->errors()[0],
                'row' => $failure->row(),
            ];
        }
        return $validationErrors;
    }
}
