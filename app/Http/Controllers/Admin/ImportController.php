<?php

namespace App\Http\Controllers\Admin;

use App\Imports\ProductsImport;
use App\Http\Requests\ImportRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Jobs\NotifyAdminOfCompletedImport;
use App\Jobs\NotifyAdminOfIncompleteImport;

class ImportController extends Controller
{
    public function productImport(ImportRequest $request, ProductsImport $import)
    {
        $import->import($request->file('file'));

        if (count($import->failures()) > 0) {

            $this->dispatch(new NotifyAdminOfIncompleteImport(
                    Auth::user(),
                    $this->getValidationErrors($import->failures()))
            );
        } else {
            $import->queue($request->file('file'))->chain([
                new NotifyAdminOfCompletedImport(
                    Auth::user(),
                    'message'
                )
            ]);
        }

        return redirect()
            ->route('product.index')
            ->with('message', '');
    }

    public function getValidationErrors($importFailures): array
    {
        $validationErrors = [];
        foreach ($importFailures as $failure) {
            $validationErrors []= [
                'message' => $failure->errors()[0],
                'row' => $failure->row(),
            ];
        }
        dd($validationErrors);
        return $validationErrors;
    }
}
