<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Product;
use App\Exports\ProductsExport;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Jobs\NotifyAdminOfCompetedExport;
use App\Http\Requests\Product\ExportRequest;

class ExportController extends Controller
{
    /**
     * @param ExportRequest $request
     * @param ProductsExport $productsExport
     * @return RedirectResponse
     */
    public function productExport(ExportRequest $request, ProductsExport $productsExport, Product $products)
    {
        $filePath = 'products.' . $request->extension;

        $productsExport->queue($filePath)->chain([
            new NotifyAdminOfCompetedExport(
                Auth::user(),
                asset('storage/' . $filePath)
            )
        ]);

        return redirect()
            ->route('product.index')
            ->with('status', 'The export product started. We will notify by email');
    }

    public function userExport(UsersExport $usersExport)
    {
        return $usersExport->download('user.xlsx');
    }
}
