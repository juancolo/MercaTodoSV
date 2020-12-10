<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Exports\ProductsExport;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Jobs\NotifyAdminOfCompletedExport;
use App\Http\Requests\Product\ExportRequest;

class ExportController extends Controller
{
    /**
     * @param ExportRequest $request
     * @param ProductsExport $productsExport
     * @return RedirectResponse
     */
    public function productExport(ExportRequest $request, ProductsExport $productsExport)
    {
        $filePath = date('d-m-Y', strtotime(now())).'-products.' . $request->extension;

        $productsExport->queue($filePath)->chain([
            new NotifyAdminOfCompletedExport(
                Auth::user(),
                asset('storage/' . $filePath)
            )
        ]);

        return redirect()
            ->route('product.index')
            ->with('status', trans('products.messages.export.status'));
    }

    public function userExport(UsersExport $usersExport)
    {
        return $usersExport->download('user.xlsx');
    }
}
